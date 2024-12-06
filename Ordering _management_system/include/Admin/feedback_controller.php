<?php
include './admin_connect.php'; // Connection to the databasese
session_start();
if (!isset($_SESSION['user_id'])) {
    die('User not logged in');
}

$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the rating and comment from the form
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Insert feedback into the database
    $query = "INSERT INTO feedback (user_id,rating, comment) VALUES ('$user_id ','$rating', '$comment')";
    if (mysqli_query($conn, $query)) {
        $feedback_id = mysqli_insert_id($conn); // Get the last inserted feedback ID

        // Process images if they are uploaded
        if (!empty($_FILES['images']['name'][0])) {
            $imagePaths = [];
            $imageCount = count($_FILES['images']['name']);
            for ($i = 0; $i < $imageCount; $i++) {
                $imageTmpName = $_FILES['images']['tmp_name'][$i];
                $imageName = basename($_FILES['images']['name'][$i]);
                $targetDir = "Uploads";
                $targetFile = $targetDir . $imageName;

                // Move the image to the server
                if (move_uploaded_file($imageTmpName, $targetFile)) {
                    $imagePaths[] = $targetFile;

                    // Insert image paths into the feedback_images table
                    $queryImage = "INSERT INTO feedback_images ( feedback_id, image_path) VALUES ('$feedback_id', '$targetFile')";
                    mysqli_query($conn, $queryImage);
                  
                }
                }
            }
        }

        // Return success response
        echo json_encode(['success' => true]);
    } else {
        // Return error if feedback insertion failed
        echo json_encode(['success' => false, 'message' => 'Error inserting feedback: ' . mysqli_error($conn)]);
    }

?>
