<?php
require 'admin_connect.php'; include('./function.php'); // Database connection

if (isset($_GET['id'])) {
    $cat_id = $_GET['id'];

    // Ensure cat_id is numeric to prevent SQL injection
    if (is_numeric($cat_id)) {
        $query = "DELETE FROM sub_category WHERE id = $cat_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Success message
            redirect(" category.php","Category deleted successfully");
        } else {
            // Error message
            header("Location: category.php?message=Failed to delete category");
        }
    } else {
        header("Location: category.php?message=Invalid category ID");
    }
} else {
    header("Location: category.php?message=Category ID not provided");
}
?>
