<?php
// app/Services/SmsService.php

namespace App\Services;

use Database;
use Exception;

class SmsService {
    
    private $host;
    private $port;
    private $user;
    private $pass;
    private $encryption;
    private $fromEmail;
    private $fromName;
    private $socket;

    public function __construct() {
        // Read directly from the .env file using our env() helper
        $this->host       = env('SMTP_HOST', 'smtp.gmail.com');
        $this->port       = env('SMTP_PORT', 587);
        $this->user       = env('SMTP_USER', '');
        $this->pass       = env('SMTP_PASS', '');
        $this->encryption = env('SMTP_ENCRYPTION', 'tls');
        $this->fromEmail  = env('MAIL_FROM_EMAIL', 'noreply@school.com');
        $this->fromName   = env('MAIL_FROM_NAME', 'SchoolDesk');
    }

    /**
     * Send an Email using raw SMTP
     */
    public function send($toEmail, $subject, $message) {
        if (empty($this->host) || empty($this->user) || empty($this->pass)) {
            return false; // SMTP credentials missing in .env
        }

        try {
            $this->connect();
            $this->authenticate();
            $this->sendEmail($toEmail, $subject, $message);
            $this->disconnect();
            
            // Log success to database
            $this->logMessage($toEmail, $subject, 'sent');
            
            return true;
        } catch (Exception $e) {
            // Log failure to database
            $this->logMessage($toEmail, $subject, 'failed');
            return false;
        }
    }

    private function connect() {
        $protocol = $this->encryption === 'ssl' ? 'ssl://' : '';
        $this->socket = fsockopen($protocol . $this->host, $this->port, $errno, $errstr, 15);
        
        if (!$this->socket) {
            throw new Exception("Could not connect to SMTP server: $errstr ($errno)");
        }
        $this->getResponse();
        
        $this->sendCommand("EHLO " . gethostname());
        $this->getResponse();

        if ($this->encryption === 'tls') {
            $this->sendCommand("STARTTLS");
            $this->getResponse();
            if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                throw new Exception("Failed to enable TLS encryption");
            }
            $this->sendCommand("EHLO " . gethostname());
            $this->getResponse();
        }
    }

    private function authenticate() {
        $this->sendCommand("AUTH LOGIN");
        $this->getResponse();
        
        $this->sendCommand(base64_encode($this->user));
        $this->getResponse();
        
        $this->sendCommand(base64_encode($this->pass));
        $response = $this->getResponse();
        
        if (substr($response, 0, 3) !== '235') {
            throw new Exception("SMTP Authentication failed. Check your App Password.");
        }
    }

    private function sendEmail($to, $subject, $body) {
        $this->sendCommand("MAIL FROM: <{$this->fromEmail}>");
        $this->getResponse();
        
        $this->sendCommand("RCPT TO: <{$to}>");
        $this->getResponse();
        
        $this->sendCommand("DATA");
        $this->getResponse();

        $headers = [
            "MIME-Version: 1.0",
            "Content-Type: text/html; charset=UTF-8",
            "From: =?UTF-8?B?" . base64_encode($this->fromName) . "?= <{$this->fromEmail}>",
            "To: <{$to}>",
            "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=",
            "Date: " . date('r')
        ];

        $data = implode("\r\n", $headers) . "\r\n\r\n" . $body . "\r\n.";
        $this->sendCommand($data);
        
        $response = $this->getResponse();
        if (substr($response, 0, 3) !== '250') {
            throw new Exception("Message sending failed");
        }
    }

    private function disconnect() {
        $this->sendCommand("QUIT");
        if ($this->socket) {
            fclose($this->socket);
        }
    }

    private function sendCommand($command) {
        fwrite($this->socket, $command . "\r\n");
    }

    private function getResponse() {
        $response = '';
        while ($line = fgets($this->socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') break;
        }
        return $response;
    }

    /**
     * Helper to log the email to the database
     */
    private function logMessage($email, $subject, $status) {
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("INSERT INTO message_logs (recipient_type, recipient_email, message, status, sent_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute(['parent', $email, $subject, $status, $_SESSION['user_id'] ?? 1]);
        } catch (Exception $e) {
            // Silently fail
        }
    }
}
