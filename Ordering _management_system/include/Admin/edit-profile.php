<?php
session_start();
include './admin_connect.php';

if (isset($_POST['update_profile'])) {
    $user_id = $_SESSION['auth_user']['user_id'];
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['image_old'];
    
    if ($new_image != '') {
        $image = $new_image;
        if (file_exists("Uploads/" . $new_image)) {
            $_SESSION['message'] = "Image already exists.";
            header('Location: admin_dashboard.php');
            exit(0);
        }
    } else {
        $image = $old_image;
    }

    $query = "UPDATE user_form SET fname='$fname', lname='$lname', email='$email', password='$password', image='$image' WHERE id='$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if ($new_image != '') {
            move_uploaded_file($_FILES['image']['tmp_name'], "Uploads/" . $new_image);
            if ($old_image != '') {
                unlink("Uploads/" . $old_image);
            }
        }
        $_SESSION['message'] = "Profile updated successfully.";
        header('Location: index.php');
    } else {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        header('Location: index.php');
    }
} else {
    $_SESSION['message'] = "Invalid request.";
    header('Location: index.php');
}
?>
