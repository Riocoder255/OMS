<?php
// Include database connection
require_once 'admin_connect.php'; // Adjust the path as needed

// Check if the form data is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from POST request
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Sanitize the data to prevent SQL injection (optional but recommended)
    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);
    $start_date = mysqli_real_escape_string($conn, $start_date);
    $end_date = mysqli_real_escape_string($conn, $end_date);

    // Check if any of the fields are empty (optional validation)
    if (empty($title) || empty($description) || empty($start_date) || empty($end_date)) {
        echo "All fields are required!";
        exit;
    }

    // Prepare SQL query to insert the event data into the database
    $query = "INSERT INTO events (title, description, start_date, end_date) VALUES ('$title', '$description', '$start_date', '$end_date')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect to a success page or show a success message
        echo "Event added successfully!";
        // Optionally redirect to another page after success (e.g., event list page)
        header('Location: calendar_event.php');
        exit;
    } else {
        // Display an error message if the query fails
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
