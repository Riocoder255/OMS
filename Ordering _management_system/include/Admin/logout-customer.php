<?php
session_start();

if(isset($_POST['logout_btn']))
session_destroy();
$_SESSION['status']="Logged Out Successfully";
header('Location: sign-in.php');
exit(0);
?>
