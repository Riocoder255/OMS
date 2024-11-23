<?php 
include_once './function.php';

include './admin_connect.php';

if(isset($_GET['delete'])){

    $id =$_GET['delete'];


    $sql="DELETE FROM product_price WHERE product_id ='$id'";
    $delete= mysqli_query($conn,$sql);
    
    if($delete){
        $_SESSION['success']="Delete product  price Is Successfully";
        header('Location: product_price.php');

    }else{
        
    }

}





?>