<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Path to Composer autoload file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);
    
    // Store OTP in session for verification
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Example: Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'romelbialaromeltbiala@gmail.com'; // Your email address
        $mail->Password = 'jbwh ogiv ymql bwii'; // Your email password (use app-specific password for Gmail)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('romelbialaromeltbiala@gmail.com', 'Chantong Enterprise');
        $mail->addAddress($email); // Add recipient email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: <strong>$otp</strong>";
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        

        // Send the email
        $mail->send();
        echo 'Hi your OTP has been sent. Check your  email';?>

        <br/>
        <a href="OTP_Verification.php">Enter your OTP to reset your password</a>


<?php
        // Redirect to OTP verification page
      
        exit(0);
    } catch (Exception $e) {
        $_SESSION['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header('Location: Send_email.php');
        exit(0);
    }
}
?>
