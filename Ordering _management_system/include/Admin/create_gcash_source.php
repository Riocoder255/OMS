<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include './admin_connect.php'; // Database connection
    $apiKey = 'sk_test_your_paymongo_secret_key';

    $amount = intval($_POST['total_cart_value']) * 100; // Convert to cents
    $branch = $_POST['branch'];
    $paymentType = $_POST['payment_type'];
    $customerName = "Customer Name"; // Replace with actual customer data

    $data = [
        'data' => [
            'attributes' => [
                'amount' => $amount,
                'currency' => 'PHP',
                'type' => 'gcash',
                'redirect' => [
                    'success' => 'https://yourdomain.com/payment_success.php',
                    'failed' => 'https://yourdomain.com/payment_failed.php',
                ],
            ],
        ],
    ];

    $ch = curl_init('https://api.paymongo.com/v1/sources');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($apiKey . ':'),
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 201) {
        $responseData = json_decode($response, true);
        echo json_encode(['redirect_url' => $responseData['data']['attributes']['redirect']['checkout_url']]);
    } else {
        echo json_encode(['error' => 'Failed to create payment source']);
    }
}
