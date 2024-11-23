<?php

$server= 'localhost';
$user ='root';
$password= '';
$db='ordering_ms';

$conn = mysqli_connect($server,$user,$password,$db);
if(!$conn){
    echo"Connection failed!";
}



?>