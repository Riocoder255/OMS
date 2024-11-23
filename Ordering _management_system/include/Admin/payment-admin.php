<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';
require_once "./admin_connect.php";
require_once "./function-c.php";


if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
} else {
    die('Invalid order ID');
}

// Fetch order details
$order_query = "SELECT 
    o.id, 
    o.total_amount, 
    o.down_payment,
    o.balance,
    o.payment_status, 
    p.payment_name,
    c.firstname, 
    c.email, 
    c.phone
  FROM 
    orders AS o
  INNER JOIN 
    customer_info AS c ON o.customer_id = c.id
  INNER JOIN 
    payment_method AS p ON o.payment_id = p.id
  WHERE 
    o.id = $order_id";

$order_result = mysqli_query($conn, $order_query) or die('QUERY FAILED: ' . mysqli_error($conn));
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    die('Order not found');
}

// Fetch payment methods
$payment_methods_query = "SELECT id, payment_name FROM payment_method";
$payment_methods_result = mysqli_query($conn, $payment_methods_query) or die('QUERY FAILED: ' . mysqli_error($conn));

// Fetch payment history
$history_query = "SELECT ph.*, pm.payment_name 
                  FROM payment_history ph 
                  INNER JOIN payment_method pm ON ph.payment_id = pm.id 
                  WHERE ph.order_id = $order_id 
                  ORDER BY ph.payment_date DESC";
$history_result = mysqli_query($conn, $history_query) or die('QUERY FAILED: ' . mysqli_error($conn));

// Handle new payment submission

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment History</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
</head>
<body>

<div class="container-6" style="margin-top: 50px">
    <h2 style="text-align: center; " class="text-success">Payment History for Order #<?php echo $order_id; ?></h2>
    <div style="text-align: center;">
        <h4 class="text-primary" >Order Details</h4>
        <p>Customer: <?php echo htmlspecialchars($order['firstname']); ?></p>
        <p>Email: <?php echo htmlspecialchars($order['email']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($order['phone']); ?></p>
        <p>Total Amount: <?php echo htmlspecialchars($order['total_amount']); ?></p>
        <p>Total Down Payment: <?php echo htmlspecialchars($order['down_payment']); ?></p>
        <p>Balance: <?php echo htmlspecialchars($order['balance']); ?></p>
        <p>Status: <?php echo htmlspecialchars($order['payment_status']); ?></p>
    </div>
    <div style="width: 700px; margin-left:300px">
        <h4>Payment History</h4>
        <?php
        if (mysqli_num_rows($history_result) > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>Date</th><th>Amount</th><th>Method</th></tr></thead><tbody>";
            while ($history_row = mysqli_fetch_array($history_result)) {
                echo "<tr>
                    <td>" . date('F d, Y H:i', strtotime($history_row['payment_date'])) . "</td>
                    <td>{$history_row['payment_amount']}</td>
                    <td>{$history_row['payment_name']}</td>
                </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No payments recorded.</p>";
        }
        ?>
    </div>
   
</div>

</body>
</html>














<?php
include_once './layouts/scripts.php';
include_once './layouts/footer.php';




?>