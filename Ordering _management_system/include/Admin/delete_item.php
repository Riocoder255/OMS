<?php
// Assuming you have already connected to the database
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Prepare and execute the DELETE query
    $query = "DELETE FROM your_table_name WHERE id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $id); // 'i' for integer type
        if ($stmt->execute()) {
            echo 'success'; // Return success message
        } else {
            echo 'error'; // Return error message
        }
        $stmt->close();
    } else {
        echo 'error'; // Handle query preparation failure
    }
}
?>
