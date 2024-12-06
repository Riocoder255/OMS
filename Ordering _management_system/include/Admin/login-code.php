<?php
include './admin_connect.php';
session_start();

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Fetch user details from the database
    $login_query = "SELECT * FROM user_form WHERE email='$email'";
    $run_login = mysqli_query($conn, $login_query);

    if (mysqli_num_rows($run_login) > 0) {
        $userdata = mysqli_fetch_array($run_login);

        // Check if password is correct using password_verify
        if (password_verify($pass, $userdata['password'])) {

            // Check if the user is banned
            if ($userdata['is_ban']) {
                $_SESSION['status'] = "Your account has been banned. Please contact the administrator.";
                header('Location: login.php');
                exit(0);
            }

            // Set session variables based on user role
            $_SESSION['auth'] = true; // For admin and user session
            $_SESSION['auth_role'] = $userdata['roles_as'];

            $_SESSION['auth_user'] = [
                'user_id' => $userdata['id'],
                'user_name' => $userdata['fname'] . ' ' . $userdata['lname'],
                'user_email' => $userdata['email'], // Updated to 'email' to match column name
                'user_image' => $userdata['image'],
            ];

            // Redirect based on user role
            if ($_SESSION['auth_role'] == 'admin') {
                $_SESSION['message'] = "Welcome to the dashboard";
                header('Location: index.php');
                exit(0);
            } elseif ($_SESSION['auth_role'] == 'user') {
                $_SESSION['message'] = "You are logged in";
                header('Location: user-dash.php');
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Invalid email or password";
            header('Location: login.php');
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid email or password";
        header('Location: login.php');
        exit(0);
    }
} else {
    $_SESSION['message'] = "You are not allowed to access this file";
    header('Location: login.php');
    exit(0);
}

?>
