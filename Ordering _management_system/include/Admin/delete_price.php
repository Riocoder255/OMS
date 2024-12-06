<?php 
include_once './function.php';

include './admin_connect.php';

if(isset($_GET['delete'])){

    $id =$_GET['delete'];


    $sql="DELETE FROM product_price WHERE product_id ='$id'";
    $delete= mysqli_query($conn,$sql);
    

    $delete_sizes_query = "DELETE FROM product_size WHERE product_id = '$id'";
    mysqli_query($conn, $delete_sizes_query);

    $delete_cart_query = "DELETE FROM cart  WHERE product_id = '$id'";
    mysqli_query($conn, $delete_cart_query);


    if($delete){
        $_SESSION['success']="Delete product  price Is Successfully";
        header('Location: product_price.php');

    }else{
        
    }

}





?>