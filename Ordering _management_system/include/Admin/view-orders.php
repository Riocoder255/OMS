<?php

require './layouts-c/header-c.php';
require './layouts-c/navbar-c.php';
require_once "./admin_connect.php";
require_once "./function-c.php";

if (!isset($_SESSION['auth_customer'])) {
    header("Location: sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$query = "SELECT 
    o.id, 
    o.total_amount, 
    o.down_payment,
    o.balance,
    o.order_status,
    o.payment_status,
    o.date,
    o.pickup_date,
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
    o.user_id = ?
ORDER BY 
    o.id DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">
                    <?php alertmessages(); ?>
                    <h6 class="mb-0 font-weight-bold text-primary">View Billing Orders</h6>
                </div>
                <div class="card-body">
                    <div class="responsive-table">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Pickup Date</th>
                                    <th>Payment History</th>
                                    <th>Item Order</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $count = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $statusClass = $row['order_status'] == 'Approved' ? 'btn-success' : 'btn-danger';
                                    $statusText = $row['order_status'] == 'Approved' ? 'Approved' : 'Pending';

                                    $pickup_date = $row['pickup_date'] ? date('F d, Y', strtotime($row['pickup_date'])) : 'N/A';
                                    echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$row['firstname']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['phone']}</td>
                                        <td>{$row['payment_name']}</td>
                                        <td>{$row['payment_status']}</td>
                                        <td><p class='btn {$statusClass}'>{$statusText}</p></td>
                                        <td>{$pickup_date}</td>
                                        <td><a href='payment-history.php?order_id={$row['id']}' class='btn btn-info btn-sm'> Payment History</a></td>
                                        <td><a href='item_orders.php?order_id={$row['id']}' class='btn btn-primary btn-sm'>View Item Order</a></td>
                                    </tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='10'>No records found</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>

                        <!-- Fetch total amounts for the logged-in user -->
                        <?php
                        $amountQuery = "SELECT 
                            SUM(total_amount) as total_amount, 
                            SUM(down_payment) as down_payment, 
                            SUM(balance) as balance 
                            FROM orders 
                            WHERE user_id = ?";
                        
                        $stmt = $conn->prepare($amountQuery);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $amountResult = $stmt->get_result();
                        $totals = $amountResult->fetch_assoc();
                        ?>
                        
                        <div class="row">
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Total Amount</th>
                                            <th>Down Payment</th>
                                            <th>Total Due</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($totals) {
                                            echo "<tr>
                                                <td>{$totals['total_amount']}</td>
                                                <td>{$totals['down_payment']}</td>
                                                <td>{$totals['balance']}</td>
                                            </tr>";
                                        } else {
                                            echo "<tr><td colspan='3'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("./layouts/footer.php");
include("./layouts/scripts.php");
?>

<style>
    .btn-success {
        color: white;
        background-color: green;
        border-color: green;
    }
    .btn-danger {
        color: white;
        background-color: red;
        border-color: red;
    }
    table, th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
</style>
