<?php
require_once "./admin_connect.php";
require_once "./function-c.php";
require './layouts-c/header-c.php';
require './layouts-c/navbar-c.php';

// Ensure order_id is set and valid
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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_amount']) && isset($_POST['payment_method'])) {
    $payment_amount = floatval($_POST['payment_amount']);
    $payment_method_id = intval($_POST['payment_method']);

    // Insert the payment into the payment_history table
    $insert_payment_sql = "INSERT INTO payment_history (order_id, payment_amount, payment_id) VALUES ($order_id, $payment_amount, $payment_method_id)";
    if ($conn->query($insert_payment_sql) === TRUE) {
        // Update the total_down_payment and balance in the orders table
        $new_down_payment = $order['down_payment'] + $payment_amount;
        $new_balance = $order['total_amount'] - $new_down_payment;
        $new_status = $new_balance <= 0 ? 'Complete' : 'Incomplete';

        $update_order_sql = "UPDATE orders SET down_payment = $new_down_payment, balance = $new_balance,payment_status = '$new_status' WHERE id = $order_id";
        if ($conn->query($update_order_sql) === TRUE) {
            echo "<script>alert('Payment added successfully'); window.location.href='payment-history.php?order_id=$order_id';</script>";
        } else {
            echo "Error updating order: " . $conn->error;
        }
    } else {
        echo "Error inserting payment: " . $conn->error;
    }
}
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
    <div style="margin-left:300px">
        <h4>Add New Down Payment</h4>
        <form action="payment-history.php?order_id=<?php echo $order_id; ?>" method="POST">
            <div class="form-group">
                <label for="payment_amount">Payment Amount:</label>
                <input type="text" class="form-control" id="payment_amount" name="payment_amount" required style="width: 300px;" required style="width: 300px;" step="0.01" min="0" max="<?php  $order['total_amount'] ?>">
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select class="form-control" id="payment_method" name="payment_method"  style="width: 300px;">
                    <?php
                    while ($payment_method = mysqli_fetch_array($payment_methods_result)) {
                        echo "<option value='{$payment_method['id']}'>{$payment_method['payment_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Add Payment</button>
        </form>
    </div>
</div>

</body>
</html>
