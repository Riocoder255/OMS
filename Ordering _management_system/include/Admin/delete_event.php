<?php
// Include database connection
include 'admin_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the event ID from the AJAX request
    $eventId = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Ensure the ID is valid
    if ($eventId > 0) {
        // SQL query to delete the event
        $sql = "DELETE FROM events WHERE id = ?";
        
        // Prepare and execute the statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $eventId);
            if ($stmt->execute()) {
                echo "Event deleted successfully.";
            } else {
                echo "Error: Could not delete the event.";
            }
            $stmt->close();
        } else {
            echo "Error: Failed to prepare the SQL statement.";
        }
    } else {
        echo "Invalid event ID.";
    }
} else {
    echo "Invalid request method.";
}
?>
