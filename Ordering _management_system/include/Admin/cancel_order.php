<?php
include('./admin_connect.php'); // Include your database connection

// Function to cancel the order
function cancelOrder($order_id) {
    global $conn;

    // Retrieve order information from the database
    $query = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        // Check payment status
    if ($order['payment_type'] == 'Fullcashpayment') {
            echo "Your order is processing and cannot be cancelled as the full payment is made.";
        } elseif ($order['payment_type'] == 'Downpayment') {
            // Update order status to 'cancelled'
            $query_update = "UPDATE orders SET order_status = 'cancelled' WHERE order_id = ?";
            $stmt_update = $conn->prepare($query_update);
            $stmt_update->bind_param("i", $order_id);
            $stmt_update->execute();
            echo "Your order has been cancelled successfully.";
        } else {
            echo "Unable to cancel your order. Please contact support.";
        }
    } else {
        echo "Order not found.";
    }
}

// Check if the request is a POST request with the order ID
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    cancelOrder($order_id); // Call the function to cancel the order
}
?>
