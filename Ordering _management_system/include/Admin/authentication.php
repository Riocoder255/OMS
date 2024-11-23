<?php
 // Start the session
 require_once './function.php';
include './admin_connect.php'; // Include the database connection file

// Check if the user is authenticated
if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Login to Access Dashboard";
    header('Location: login.php');
    exit(0);
} else {
    // Check if the authenticated user is an admin
    if ($_SESSION['auth_role'] != 'admin') {
        $_SESSION['message'] = "You are not Authorized as ADMIN";
        redirect(' login.php','');
        exit(0);
    }
}

// If the user is an admin, allow access to the dashboard code below
?>
