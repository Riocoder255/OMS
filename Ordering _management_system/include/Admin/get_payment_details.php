<?php
require_once './admin_connect.php';

$order_id = $_GET['order_id'] ?? null;

if ($order_id) {
    $query = "SELECT total_amount, remaining_balance, payment_type, payment_method 
              FROM orders 
              
              WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'payment' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment details not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Order ID is missing.']);
}
?>
