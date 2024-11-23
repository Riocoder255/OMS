<?php
session_start();
include ('./admin_connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['total_amount'] = floatval($_POST['total_amount']);
    $_SESSION['down_payment'] = floatval($_POST['down_payment']);
    $_SESSION['payment_method'] = $_POST['payment_method'];
    $_SESSION['cart_items'] = $_POST['cart_items'];
    $_SESSION['product_id'] = $_POST['product_id'];

    


    

    $_SESSION['balance'] = $_SESSION['total_amount'] - $_SESSION['down_payment'];

    header("Location:customer-info.php");
    exit();
  
}
?>
