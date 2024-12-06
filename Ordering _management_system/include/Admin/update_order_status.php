<?php
header("Content-Type: application/json");
require_once './admin_connect.php'; // Replace with your database connection file

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);

$order_id = $data['order_id'];
$order_approval = $data['order_approval'];

// Validate input
if (!empty($order_id) && !empty($order_approval)) {
    // Update the `order_approval` column in the database
    $query = "UPDATE orders SET order_approval = ? WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $order_approval, $order_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update the database."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data."]);
}

$conn->close();
?>
