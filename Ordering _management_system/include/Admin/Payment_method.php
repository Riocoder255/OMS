<?php

// PayMongo Webhook secret (from your PayMongo account settings)
$webhook_secret = 'sk_test_viqjbEWMc5ht6zB69HEweMSB';

// Get payload and signature from PayMongo
$payload = file_get_contents('php://input');
$headers = getallheaders();
$signature = $headers['Paymongo-Signature'] ?? '';

if ($signature && hash_equals($webhook_secret, $signature)) {
    $event = json_decode($payload, true);

    if ($event['data']['attributes']['status'] === 'succeeded') {
        $amount = $event['data']['attributes']['amount'] / 100; // Convert from cents to PHP
        $payment_method = $event['data']['attributes']['payment_method_type'];

        // Update your database with the payment status
        file_put_contents('payment_logs.txt', "Payment succeeded: ₱{$amount} via {$payment_method}\n", FILE_APPEND);
    }
}
?>

