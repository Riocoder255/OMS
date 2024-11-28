<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';



require_once "admin_connect.php";



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    button { 
        width:20%;
        height: 20%;
        margin-top: 100px;
        margin-left: 20%;
      
    }
</style>
<body>
    
<div class="container">
    <button class=" btn btn-light" >Downpayment</button> <button class=" btn btn-light">Fullcash payment</button>
</div>
</body>
</html>
    



<?php

include("./layouts/footer.php");

include("./layouts/scripts.php");

?>