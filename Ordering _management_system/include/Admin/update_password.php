<?php
session_start();
include './function.php'; // Include database connection file

// Check if password fields are submitted
if (isset($_POST['password'], $_POST['confirm_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['message'] = 'Passwords do not match.';
        header('Location: Reset_password.php');
        exit(0);
    }

    // Hash the new password using password_hash
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Assume the email is stored in the session during OTP verification
    $email = $_SESSION['email'];

    // Update the password in the database
    $query = "UPDATE user_form SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Password updated successfully. Please log in.';
        unset($_SESSION['otp']); // Clear OTP from session
        unset($_SESSION['email']); // Clear email from session
        header('Location: login.php'); // Redirect to login page
    } else {
        $_SESSION['message'] = 'Failed to update password. Please try again.';
        header('Location: Reset_password.php');
    }
}
?>
