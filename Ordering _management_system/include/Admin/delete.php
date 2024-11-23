<?php

require_once "admin_connect.php";

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Include database connection
   ;  // Replace with your actual connection file

    // Prepare the delete query
    $query = "DELETE FROM Pricing WHERE id = '$id'";  // Replace with your actual table name
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo "Record deleted successfully!";
        header("Location: Pricing.php");  // Redirect back to the page with the table
    } else {
        echo "Failed to delete record!";
    }
}
?>
