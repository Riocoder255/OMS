<?php
header("Content-Type: application/json");
require_once './admin_connect.php'; // Include database connection file

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data['order_id'];

if (!empty($order_id)) {
    // Fetch payment history from database
    $query = "SELECT  total_amount,total_item ,remaining_balance ,	payment_method , payment_type,	order_approval,payment_status FROM orders
     WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $payments = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode(["success" => true, "payments" => $payments]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to fetch payment history."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid order ID."]);
}

$conn->close();
?>
