<?php
// app/Helpers/PaystackHelper.php

class PaystackHelper
{
    public static function initializePayment($data)
    {
        $secretKey = env('PAYSTACK_SECRET_KEY');

        if (!$secretKey) {
            return ['success' => false, 'message' => 'Paystack secret key not configured'];
        }

        $url = "https://api.paystack.co/transaction/initialize";

        $fields = [
            'amount' => $data['amount'] * 100, // Convert to pesewas
            'email' => $data['email'],
            'currency' => 'GHS',
            'reference' => $data['reference'] ?? 'PAY_' . time(),
            'callback_url' => route('payment.callback'),
            'metadata' => $data['metadata'] ?? []
        ];

        // Add payment channels
        if (isset($data['channels'])) {
            $fields['channels'] = $data['channels'];
        }

        // Add mobile money details
        if (isset($data['mobile_money'])) {
            $fields['mobile_money'] = $data['mobile_money'];
        }

        // Make API call
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $secretKey,
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['success' => false, 'message' => 'CURL Error: ' . $error];
        }

        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status']) {
            return [
                'success' => true,
                'authorization_url' => $result['data']['authorization_url'],
                'reference' => $result['data']['reference'],
                'access_code' => $result['data']['access_code']
            ];
        }

        return ['success' => false, 'message' => $result['message'] ?? 'Payment initialization failed'];
    }

    public static function verifyPayment($reference)
    {
        $secretKey = env('PAYSTACK_SECRET_KEY');

        $url = "https://api.paystack.co/transaction/verify/" . $reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $secretKey,
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['success' => false, 'message' => 'CURL Error: ' . $error];
        }

        $result = json_decode($response, true);

        return [
            'success' => isset($result['status']) && $result['status'],
            'data' => $result['data'] ?? null,
            'message' => $result['message'] ?? 'Verification failed'
        ];
    }
}
