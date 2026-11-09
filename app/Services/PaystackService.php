<?php
// app/Services/PaystackService.php

namespace App\Services;

class PaystackService {
    private $secretKey;
    private $publicKey;

    public function __construct() {
        $this->secretKey = env('PAYSTACK_SECRET_KEY', '');
        $this->publicKey = env('PAYSTACK_PUBLIC_KEY', '');
    }

    public function getPublicKey() {
        return $this->publicKey;
    }

    /**
     * Initialize a transaction
     */
    public function initialize($email, $amount, $reference, $callbackUrl) {
        $url = "https://api.paystack.co/transaction/initialize";
        
        $fields = [
            'email' => $email,
            'amount' => $amount * 100, // Paystack uses kobo (multiply by 100)
            'reference' => $reference,
            'callback_url' => $callbackUrl
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->secretKey,
            "Cache-Control: no-cache",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * Verify a transaction
     */
    public function verify($reference) {
        $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->secretKey,
            "Cache-Control: no-cache",
        ]);
        
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
