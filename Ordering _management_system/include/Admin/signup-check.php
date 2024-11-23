<?php
session_start();
include('./admin_connect.php');

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';  // Ensure this path is correct

if (isset($_POST['email'], $_POST['password'], $_POST['name'], $_POST['lname'], $_POST['confirmpass'])) {
    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $name = validate($_POST['name']);
    $lname = validate($_POST['lname']);
    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);
    $confirmpass = validate($_POST['confirmpass']);
    $user_data = "name=$name&lname=$lname&email=$email";

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=Invalid email address&$user_data");
        exit();
    }

    // Check if passwords match
    if ($pass !== $confirmpass) {
        header("Location: signup.php?error=Passwords do not match&$user_data");
        exit();
    }

    // Hash the password before saving it to the database
    $pass = md5($pass);

    // Check if email already exists in the database
    $sql = "SELECT * FROM customer WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        header("Location: signup.php?error=Email already exists&$user_data");
        exit();
    }

    // Insert user data into the database
    $otp = random_int(100000, 999999);  // Generate OTP
    $sql2 = "INSERT INTO customer (name, lname, email, password, otp, is_verified) 
             VALUES ('$name', '$lname', '$email', '$pass', '$otp', '0')";
    if (mysqli_query($conn, $sql2)) {
        // Email sending logic
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->SMTPDebug = 2;  // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'romelbialaromeltbiala@gmail.com';  // Your Gmail
            $mail->Password = 'jbwh ogiv ymql bwii';  // Your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and recipient
            $mail->setFrom('romelbialaromeltbiala@gmail.com', 'Chantong-Enterprise.com');
            $mail->addAddress($email, $name);  // Recipient's email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body = "<p>Your verification code is: <b style='font-size:30px'>$otp</b></p>";

            // Send email
            $mail->send();

            // Redirect to OTP verification page
            $_SESSION['email'] = $email;
            header("Location: customerverify.php");
            exit();

        } catch (Exception $e) {
            // In case of error
            header("Location: signup.php?error=Failed to send OTP: {$mail->ErrorInfo}&$user_data");
            exit();
        }
    } else {
        // Database insertion failed
        header("Location: signup.php?error=Failed to register user&$user_data");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
