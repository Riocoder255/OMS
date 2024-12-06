<?php
include  './admin_connect.php';
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Connect to your database
   

    // Query to fetch customer name and order ID
    $sql = "
        SELECT c.customer_name, o.order_id
        FROM customer_tbl c
        JOIN orders_tbl o ON c.customer_id = o.customer_id
        WHERE o.order_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($customer_name, $order_id);
    $stmt->fetch();

    // Return the result as JSON
    if ($name && $order_id) {
        echo json_encode(['customer_namee' => $customer_name, 'order_id' => $order_id]);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'No order ID provided']);
}
?>


   

