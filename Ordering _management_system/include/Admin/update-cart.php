<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_key = $_POST['cart_key'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['quantity'] = $quantity;
    }

    header("Location: cart_view.php");
    exit();
}
?>
