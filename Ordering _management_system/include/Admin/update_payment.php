<?php
require_once './admin_connect.php';

$order_id = $_POST['order_id'] ?? null;
$total_amount = $_POST['total_amount'] ?? null;
$remaining_balance = $_POST['remaining_balance'] ?? null;
$payment_type = $_POST['payment_type'] ?? null;
$payment_method = $_POST['payment_method'] ?? null;

// Check for valid input
if ($order_id && $total_amount && $payment_type && $payment_method) {
    // Set payment status based on the payment type
    $payment_status = ($payment_type === 'full_cash') ? 'finish' : 'Pending';

    // Prepare SQL query
    $query = "UPDATE orders 
              SET total_amount = ?, 
                  remaining_balance = ?, 
                  payment_type = ?, 
                  payment_method = ?, 
                  payment_status = ?
              WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ddsssi", $total_amount, $remaining_balance, $payment_type, $payment_method, $payment_status, $order_id);

    // Execute and handle response
    if ($stmt->execute()) {
        
        echo json_encode(['success' => true, 'message' => 'Payment updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update payment.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
