<?php
session_start();

include('./admin_connect.php');
include('./layouts-c/header-c.php');
include('./layouts-c/navbar-c.php');

function redirectTo($url) {
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit();
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (!isset($_SESSION['auth_customer'])) {
        header("Location: sign-in.php");
        exit();
    }
    // Collect customer information
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $branch_id = isset($_POST['branch_id']) ? $_POST['branch_id'] : null;
    $payment_method_selection = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;
    $user_id = $_SESSION['user_id']; // Make sure user_id is set in the session during login

    if ($name && $email && $phone && $branch_id && $payment_method_selection) {
        // Insert customer information into the database
        $query_customer = "INSERT INTO customer_info(firstname, email, phone, branch_id) VALUES (?, ?, ?, ?)";
        $stmt_customer = $conn->prepare($query_customer);
        if ($stmt_customer) {
            $stmt_customer->bind_param("sssi", $name, $email, $phone, $branch_id);
            if ($stmt_customer->execute()) {
                $customer_id = $stmt_customer->insert_id;
                $_SESSION['customer_id'] = $customer_id;
            } else {
                die("Error executing customer query: " . $stmt_customer->error);
            }
            $stmt_customer->close();
        } else {
            die("Error preparing customer statement: " . $conn->error);
        }
    } else {
        die("Error: Missing required customer information.");
    }

    // Debugging statements to check if data is received
    echo '<pre>';
    var_dump($_POST);
    var_dump($_SESSION);
    echo '</pre>';

    $total_amount = isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : null;
    $down_payment = isset($_SESSION['down_payment']) ? $_SESSION['down_payment'] : null;
    $payment_method = $payment_method_selection;
    $customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : null;

    if ($total_amount === null || $down_payment === null || $payment_method === null || $customer_id === null) {
        die("Error: Missing required information.");
    }

    // Calculate balance and determine payment status
    $balance = $total_amount - $down_payment;
    $payment_status = $balance == 0 ? 'complete' : 'not fully paid';
    $order_status = 'pending';
    $dated = date('Y-m-d H:i:s');

    // Insert order details into the orders table
    $query_order = "INSERT INTO orders (total_amount, down_payment, balance, payment_id, payment_status, order_status, date, customer_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($query_order);

    if ($stmt_order) {
        $stmt_order->bind_param("dddssssss", $total_amount, $down_payment, $balance, $payment_method, $payment_status, $order_status, $dated, $customer_id, $user_id);
        if ($stmt_order->execute()) {
            $order_id = $stmt_order->insert_id;

            // Insert each item from session cart into item_orders table
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $product_id = $item['product_id'];
                    $quantity = $item['quantity'];
                    $size_id = $item['size_id'];

                    $query_item = "INSERT INTO item_orders (order_id, product_id, quantity) VALUES (?, ?, ?)";
                    $stmt_item = $conn->prepare($query_item);
                    if ($stmt_item) {
                        $stmt_item->bind_param("iii", $order_id, $product_id, $quantity);
                        $stmt_item->execute();
                        $stmt_item->close();
                    } else {
                        echo "Error preparing item order statement: " . $conn->error;
                    }
                }
            }

            // Clear session data
            unset($_SESSION['cart']);

            if ($payment_method_selection == '1') { // Assuming 1 represents 'online' in your database
                redirectTo("set-payment.php");
            } elseif ($payment_method_selection == '2') { // Assuming 2 represents 'over-the-counter' in your database
                redirectTo("view-orders.php");
            }
            exit();
        } else {
            echo "Error executing order query: " . $stmt_order->error;
        }
    } else {
        echo "Error preparing order statement: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .container-5 {
            box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;
            width: 40%;
            margin: auto 0;
            padding: 20px;
            border-radius: 10px;
            margin-left: 420px;
            margin-top: 50px;
        }
        label {
            color: black;
            font-size: 15px;
            font-weight: 300;
            letter-spacing: .1em;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
</head>
<body>
    <div class="container-5">
        <h5 class="text-primary text-bold">New Details</h5>
        <form action="./customer-info.php" method="POST" enctype="multipart/form-data">
            <div class="form-group m-3">
                <label for="">Full name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group m-3">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group m-3">
                <label for="">Phone</label>
                <input type="number" name="phone" class="form-control" required>
            </div>
            <div class="form-group m-3">
                <label for="">Select Branch</label>
                <select name="branch_id" id="" class="form-control" required>
                    <option value=""></option>
                    <?php
                    $query = "SELECT * FROM branch";
                    $query_run = mysqli_query($conn, $query);
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_array($query_run)) {
                            echo "<option value='{$row['id']}'>{$row['Branch_name']}</option>";
                        }
                    }
                    ?>
                </select>

                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" style="width: 200px;" required>
                    <option value=""></option>
                    <?php
                    $query = "SELECT * FROM payment_method";
                    $query_run = mysqli_query($conn, $query);
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_array($query_run)) {
                            echo "<option value='{$row['id']}'>{$row['payment_name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </form>
    </div>
</body>
</html>
