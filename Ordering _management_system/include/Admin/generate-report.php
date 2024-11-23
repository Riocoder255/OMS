<?php
require_once "./admin_connect.php";  // Ensure connection to the database

// Check if start_date and end_date are provided via GET method
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];

    // SQL query to fetch sales data within the specified date range
    $query = "SELECT 
                o.id AS order_id, 
                o.date AS order_date, 
                o.total_amount, 
                c.firstname, 
            
                c.email 
              FROM orders o
              INNER JOIN customer_info c ON o.customer_id = c.id
              WHERE DATE(o.date) BETWEEN '$startDate' AND '$endDate'
              ORDER BY DATE(o.date)";

    $result = mysqli_query($conn, $query);

    // Fetch all rows into an array
    $salesData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $salesData[] = $row;
    }

    // Close database connection
    mysqli_close($conn);

    // Display the sales report
    include './print-sales.php';  // Create a separate file for displaying the report
} else {
    // If start_date or end_date is missing, redirect back to the form
    header('Location: index.php');  // Replace with the URL of your form page
    exit();
}
?>
