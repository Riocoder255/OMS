<?php 



// payment_success.php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    // Fetch the order details from the database using $order_id
    // Mark the order as completed or process payment status
    echo "Payment successful! Your order ID is: " . htmlspecialchars($order_id);
} else {
    echo "Payment failed or incomplete.";
}
?>