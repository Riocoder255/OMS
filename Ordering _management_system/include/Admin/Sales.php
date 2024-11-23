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
    <meta name="viewport" content="width=device-width, 

initial-scale=1.0">
    <title>Generate Sales Report</title>
    <link rel="stylesheet" href="path/to/your/css/file.css"> <!-- Add your CSS file here -->
</head>
<body>
   <div class="container" style="text-align: center;">
   <h2>Generate Sales Report</h2>
    <form action="./generate-report.php" method="GET">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <button type="submit" class="btn btn-outline-success">Generate Report</button>
    </form>
   </div>
</body>
</html>


   
    </div>
</body>
</html>

<?php
// Function to convert array to CSV format




include("./layouts/footer.php");

include("./layouts/scripts.php");

?>