
<?php
session_start();
if(isset($_GET['product_id'])){

    if(isset($_GET['quantity'])){
        $quantity =$_GET['quantity'];
        $size_id =$_GET['size_id'];


       


    }else{
        $quantity =1;

    }
    $product_id =$_GET['product_id'];

    $_SESSION['cart'][$product_id] =  array('quantity' => $quantity,'size_id'=>$size_id);
    header('location:home-client.php');
   // echo '<pre>'

   // print_r($_SESSION['cart']);
   // echo '</pre>';

}

?>











