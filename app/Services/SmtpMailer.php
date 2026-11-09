<?php
// app/Services/SmtpMailer.php

namespace App\Services;

use Exception;

class SmtpMailer {
    private $host;
    private $port;
    private $user;
    private $pass;
    private $encryption;
    private $fromEmail;
    private $fromName;
    private $socket;

    public function __construct() {
        $settings = get_settings();
        $this->host = $settings['smtp_host'] ?? '';
        $this->port = $settings['smtp_port'] ?? 587;
        $this->user = $settings['smtp_user'] ?? '';
        $this->pass = $settings['smtp_pass'] ?? '';
        $this->encryption = $settings['smtp_encryption'] ?? 'tls';
        $this->fromEmail = $settings['mail_from_email'] ?? 'noreply@school.com';
        $this->fromName = $settings['mail_from_name'] ?? ($settings['school_name'] ?? 'SchoolDesk');
    }

    public function send($toEmail, $subject, $body) {
        if (empty($this->host) || empty($this->user)) {
            return false; // SMTP not configured
        }

        try {
            $this->connect();
            $this->authenticate();
            $this->sendEmail($toEmail, $subject, $body);
            $this->disconnect();
            return true;
        } catch (Exception $e) {
            // Log error silently or return false
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
            throw new Exception("SMTP Authentication failed");
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
        fclose($this->socket);
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
}
