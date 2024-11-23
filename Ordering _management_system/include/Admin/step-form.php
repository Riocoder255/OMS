<?php 

include ('./admin_connect.php');
include './function-c.php';
session_start();

if (isset($_POST['btn-upload'])) {

    // Ensure the file is uploaded
    if (isset($_FILES['Uploaded']) && $_FILES['Uploaded']['error'] == 0) {
        $image = $_FILES['Uploaded']['name'];
        $image_tmp = $_FILES['Uploaded']['tmp_name'];
        $upload_dir = "Uploads/";

        // Validate file type and size (optional but recommended for security)
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = pathinfo($image, PATHINFO_EXTENSION);

        if (in_array($file_ext, $allowed_types) && $_FILES['Uploaded']['size'] <= 2000000) {
            // Capture the Order ID from the form or session
            $order_id = $_POST['order_id']; // assuming you are passing order_id in the form

            // Prepare the SQL statement
            $query = "INSERT INTO upload_reciep (uplaod, order_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("si", $image, $order_id);
                
                if ($stmt->execute()) {
                    // Move the uploaded file to the desired directory
                    if (move_uploaded_file($image_tmp, $upload_dir . $image)) {
                        $_SESSION['status'] = "Upload Image Is well be successfully";
                        header('Location: view-orders.php');
                        // File upload and database insertion successful
                        exit();
                    } else {    
                        // File upload failed
                        echo "Failed to move uploaded file.";
                    }
                } else {
                    // Database insertion failed
                    echo "Database error: " . $stmt->error;
                }
                
                $stmt->close();
            } else {
                echo "Failed to prepare the SQL statement.";
            }
        } else {
            echo "Invalid file type or size. Only images under 2MB are allowed.";
        }
    } else {
        $_SESSION['success'] = "Image is not uploaded";
        header('Location: set-payment.php');
    }
} else {
    echo "Upload button not clicked.";
}

?>
