



<?php

require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';

require_once "admin_connect.php";





// Check if order_id is provided in the URL
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    // Query to fetch item orders with product details
    $query = "SELECT io.quantity,io.date, p.price, io.quantity * p.price AS total, p.product_name,p.cover, p.price AS unit_price
              FROM  item_orders io
              INNER JOIN product_price p ON io.product_id = p.product_id
              WHERE io.order_id = $order_id";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<h2 class="text-success"style="text-align:center;margin-top:20px;">Item Orders for Order ID: ' . $order_id . '</h2>';
       echo'
    <a href="" class="btn btn-success "style="margin-left:400px;margin-top:20px;"><i class="fas fa-print"></i></a>
';  
        echo '<table class="table table-sm " style="width:50%; margin-left:300px;margin-top:100px;">';
        echo '<thead><tr><th>Design</th><th>Item</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th>Dated</th></tr></thead>';
        echo '<tbody>';

        $totalOrderAmount = 0; // Initialize total order amount

        while ($row = mysqli_fetch_assoc($result)) {
            $product_name = htmlspecialchars($row['product_name']);
            $quantity = intval($row['quantity']);
            $unit_price = floatval($row['unit_price']);
            $total_price = floatval($row['total']);
            $image_url = htmlspecialchars($row['cover']);
            $date = htmlspecialchars($row['date']);



            echo '<tr>';
            echo '<td><img src="product_upload/' . $image_url . '" style="max-width: 50px; max-height: 50px;"></td>';

            echo '<td>' . $product_name . '</td>';
            echo '<td>' . $quantity . '</td>';
            echo '<td>' . $unit_price . '</td>';
            echo '<td>' . $total_price . '</td>';
            echo '<td>' . $date . '</td>';


            
            echo '</tr>';

            // Accumulate total order amount
            $totalOrderAmount += $total_price;
        }

        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr><td colspan="3"><strong>Total Order Amount:</strong></td><td><strong>' . $totalOrderAmount . '</strong></td></tr>';
        echo '</tfoot>';
        echo '</table>';
    } else {
        echo '<p>No item orders found for this order.</p>';
    }
} else {
    echo '<p>Order ID parameter is missing.</p>';
}

mysqli_close($conn);
?>
<a href="orders.php" class="btn btn-secondary btn-sm"style="margin-left:400px;">Back </a>





<?php

include("./layouts/footer.php");

include("./layouts/scripts.php");

?>