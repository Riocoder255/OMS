<?php
session_start();
require './admin_connect.php';

if (isset($_GET['product_id']) && isset($_GET['size_id']) && isset($_GET['quantity'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);
    $size_id = mysqli_real_escape_string($conn, $_GET['size_id']);
    $quantity = mysqli_real_escape_string($conn, $_GET['quantity']);

    // Fetch product details
    $qry = mysqli_query($conn, "SELECT * FROM product_price WHERE product_id ='$product_id'");
    $product = mysqli_fetch_array($qry);

    // Fetch size details
    $size_qry = mysqli_query($conn, "SELECT * FROM sizing WHERE id ='$size_id'");
    $size = mysqli_fetch_array($size_qry);

    // Display product details and payment form
    echo "<h1>Checkout</h1>";
    echo "<p>Product Name: " . $product['product_name'] . "</p>";
    echo "<p>Size: " . $size['Size'] . "</p>";
    echo "<p>Quantity: " . $quantity . "</p>";
    echo "<p>Price: ₱" . $product['price'] . "</p>";

    // Add your payment form here
    // ...
}
?>
