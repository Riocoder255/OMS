<?php
session_start();
include './message.php';
include './function-c.php';
      // Assuming this file sets session messages

if (isset($_POST['logout_btn'])) {
    session_destroy();
    $_SESSION['message'] = "Logged Out Successfully";
    header('Location: sign-in.php?logout=success');
    exit(0);
}
?>

