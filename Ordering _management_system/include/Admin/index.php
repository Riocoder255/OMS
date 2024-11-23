<?php
include("./layouts/header.php");
include("./layouts/sidebar.php");
include ("./layouts/topbar.php");
include './admin_connect.php';
include ('./authentication.php'); 

?>

  <!-- Sidebar -->

        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
      

            <div class="container-fluid px-4">
           
          <?php  
                     include './message.php' ;  
                     
                     


// Query to count users
$query = "SELECT COUNT(*) AS uname FROM user_form";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    $user_count = $data['uname'];
} else {
    echo "Error: " . mysqli_error($conn);
    $user_count = 0; // Fallback in case of error


}


// Query to count users
$query = "SELECT COUNT(*) AS user_name  FROM customer";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    $user_name = $data['user_name'];
} else {
    echo "Error: " . mysqli_error($conn);
    $user_count = 0; // Fallback in case of error
}


// Query to count users
$query = "SELECT COUNT(*) AS   total_amount FROM orders";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    $total_amount = $data['total_amount'];
} else {
    echo "Error: " . mysqli_error($conn);
    $user_count = 0; // Fallback in case of error


}
//query of pending
$query = "SELECT COUNT(*) AS   pending FROM orders";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    $pending = $data['pending'];
} else {
    echo "Error: " . mysqli_error($conn);
    $user_count = 0; // Fallback in case of error


}
//query of approve
function getOrderCountByStatus($conn, $status) {
    $query = "SELECT COUNT(*) as count FROM orders WHERE order_status = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Get counts for approved and pending orders
$approvedCount = getOrderCountByStatus($conn, 'approved');
$pendingCount = getOrderCountByStatus($conn, 'pending');

function getCompletePaymentCount($conn) {
    $query = "SELECT COUNT(*) as count FROM orders WHERE payment_status = 'complete'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Get count of completed payments
$completePaymentCount = getCompletePaymentCount($conn);







?>
                
                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $user_count; ?></h3>
                                <p class="fs-5">Total Of Users</p>
                                <a href="./admin.php" class="text-decoration-none">Details</a>

                            </div>
                            <i class="fas fa-user fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php  echo $user_name?></h3>
                                <p class="fs-5"> Customer</p>
                                <a href="./view-customer.php" class="text-decoration-none">Details</a>

                            </div>
                            <i
                                class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php  echo  $total_amount?></h3>
                                <p class="fs-5">Orders</p>
                                <a href="./orders.php" class="text-decoration-none">Details</a>

                            </div>
                            <i
                                class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php  echo $pendingCount?></h3>
                                <p class="fs-5 text-danger">Pending</p>
                                <a href="./admin.php" class="text-decoration-none">Details</a>

                            </div>
                            <i class="fas fa-truck fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                        
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php  echo $approvedCount ?></h3>
                                <p class="fs-5 text-success">Approve</p>
                                <a href="./admin.php" class="text-decoration-none">Details</a>

                            </div>
                            <i class="fas fa-truck fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php  echo $completePaymentCount ?></h3>
                                <p class="fs-5 text-success">Paid</p>
                                <a href="./admin.php" class="text-decoration-none">Details</a>

                            </div>
                            <i class="fas fa-truck fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                        
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <?php 

                            
    $sales_query = "SELECT SUM(total_amount) AS total_amount FROM orders WHERE payment_status = 'complete'";
    $sales_result = mysqli_query($conn, $sales_query);
    $total_sales = $sales_result ? mysqli_fetch_assoc($sales_result)['total_amount'] : 0.00;

    

                            ?>
                            
                            <div>
                                <h3 class="fs-2"><?php echo $total_sales?></h3>
                                <p class="fs-5">Sales </p>
                                <a href="./Sales.php" class="text-decoration-none">Details</a>

                                
                            </div>
                            <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                        
                    </div>
                </div>
               
                


                <?php


// Function to get completed orders with items
function getCompletedOrdersWithItems($conn) {
    $query = "
        SELECT 
            orders.id, 
            orders.date AS order_date, 
            customer_info.firstname, 
            customer_info.email, 
            orders.total_amount, 
            product_price.product_name, 
            item_orders.quantity
        FROM 
            orders
        JOIN 
            customer_info ON orders.customer_id = customer_info.id
        JOIN 
            item_orders ON orders.id = item_orders.id
        JOIN 
            product_price ON item_orders.product_id = product_price.product_id
        WHERE 
            orders.payment_status = 'paid';
    ";
    return mysqli_query($conn, $query);
}

// Fetch the completed orders
$completedOrders = getCompletedOrdersWithItems($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Completed Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Total Amount</th>
                <th>Product Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($completedOrders) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($completedOrders)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo '₱' . number_format($row['total_amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No completed orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>


<div class="row">
                            <div >
                                <thead>
                                   
                                </tbody>
                            </div>
                            </tbody>


                        </table>

                        <!-- Modal -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>          


    <!-- /#page-content-wrapper -->
    
<?php


include("./layouts/footer.php");
include("./layouts/scripts.php");

?>