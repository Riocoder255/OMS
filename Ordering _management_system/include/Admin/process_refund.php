<?php
include('./admin_connect.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $order_id = $_POST['order_id'];
    $refund_amount = $_POST['refund_amount'];
    $refund_reason = $_POST['refund_reason'];
    $refunded_by = $_POST['refunded_by'];

    // Ensure refund amount is valid (e.g., not greater than the order total)
    $query = "SELECT  total_amount FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($order_total);
    $stmt->fetch();
    $stmt->close();

    if ($refund_amount > $order_total) {
        echo "Error: Refund amount cannot exceed the order total.";
        exit();
    }

    // Insert refund details into the database
    $query = "INSERT INTO refunds (order_id, refund_amount, refund_reason, refunded_by, status) 
              VALUES (?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("dsis", $order_id, $refund_amount, $refund_reason, $refunded_by);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Refund request submitted successfully. It is pending approval.";
    } else {
        echo "Error submitting refund request.";
    }
}
?>
