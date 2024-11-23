<?php
session_start();
require './admin_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_key = $_POST['cart_key'];

    // Get product_id, size_id, and color_id from the cart key
    list($product_part, $color_id) = explode('-', $cart_key);
    list($product_id, $size_id) = explode('_', $product_part);

    // Remove the item from the session cart
    unset($_SESSION['cart'][$cart_key]);

    // Delete the item from the database
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ? AND size_id = ? AND color_id = ?");
    $stmt->bind_param('iiii', $_SESSION['user_id'], $product_id, $size_id, $color_id);
    $stmt->execute();

    $_SESSION['status'] = "Item removed from cart successfully";
    header("Location: cart_view.php");
    exit();
}
?>
