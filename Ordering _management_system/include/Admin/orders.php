\<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';
require_once "./admin_connect.php";
require_once "./function-c.php";

// Handle status change
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] == 'approve') {
        $sql = "UPDATE orders SET order_status='Approved' WHERE id=$id";
        $_SESSION = "Approved successfully";
    } elseif ($_GET['action'] == 'pending') {
        $sql = "UPDATE orders SET order_status='Pending' WHERE id=$id";
         $_SESSION = "Pending successfully";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert(' $_SESSION'); window.location.href='orders.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }   
}


// Handle pickup date change
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pickup_date']) && isset($_POST['order_id'])) {
    $pickup_date = $_POST['pickup_date'] . "-01";  // Append day to form a valid date
    $order_id = intval($_POST['order_id']);
    $sql = "UPDATE orders SET pickup_date='$pickup_date' WHERE id=$order_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pickup date set successfully'); window.location.href='orders.php';</script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


// Fetch orders
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
    
  ORDER BY 
    o.id DESC";

$result = mysqli_query($conn, $query) or die('QUERY IS FAILED' . mysqli_error($conn));
?>

<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
  
                <div class="card-header">
                    <h6 class="mb-0 font-weight-bold text-primary">View Orders</h6>
                </div>
                <div class="card-body">
 

<!-- Modal -->

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
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    $statusClass = $row['order_status'] == 'Approved' ? 'approved' : 'pending';
                                    $statusText = $row['order_status'] == 'Approved' ? 'Approved' : 'Pending';
                                    $btnClass = $row['order_status'] == 'Approved' ? 'btn-success' : 'btn-danger';
                                    $action = $row['order_status'] == 'Approved' ? 'pending' : 'approve';
                                   
                                    echo "<tr>
                                        <td>{$count}</td>
                                        <td>{$row['firstname']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['phone']}</td>
                                        <td>{$row['payment_name']}</td>
                                        <td>{$row['payment_status']}</td>
                                        <td>
                                            <a href='?action={$action}&id={$row['id']}' class='btn {$btnClass}'>
                                                {$statusText}
                                            </a>
                                        </td>
                                       <td>

                   <!-- Button trigger modal -->
<button type='button'class='btn-sm btn btn-outline-primary'data-bs-toggle='modal'data-bs-target='#staticBackdrop' >
Pickup_Date
</button>
<!--modal-->
<div class='modal fade' id='staticBackdrop' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='staticBackdropLabel'>Set Pick_date</h5>
        <button type='button' class='btn-close'data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
     <div class='card'>
     <form action='' method='POST'>
     <input type='month' name='pickup_date' value='{$row['pickup_date']}' required class='form-control'>
        <input type='hidden' name='order_id' value='{$row['id']}'>
                                            
                                            
     </div>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
        <button type='submit' class='btn btn-primary 'style='margin-left:20px'>Set Pickup Date</button>
 </form>
      </div>
    </div>
  </div>
</div>
<!--modal-end-->

                                      
                                       </td>
                                       <td>
                                        <a href='view_orders_admin.php?order_id={$row['id']}' class='btn btn-outline-secondary btn-sm'>View orders</a>
                                       </td>
                                       <td><a href='payment-admin.php?order_id={$row['id']}' class='btn btn-outline-warning btn-sm'> Payment history </a> <td>  
                                    </tr>";

                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>No records found</td></tr>";
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
</style>
