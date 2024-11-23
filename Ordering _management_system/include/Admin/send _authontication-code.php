<?php
include ('./admin_connect.php');

if(isset($_POST['email'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = bin2hex(random_bytes(5)); // Generate a random 5 byte token
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expiry time

    // Check if the user exists
    $check_user_query = "SELECT * FROM user_form WHERE uname='$email' LIMIT 1";
    $check_user_result = mysqli_query($conn, $check_user_query);

    if(mysqli_num_rows($check_user_result) > 0){
        // Update reset token and expiry
        $query = "UPDATE user_form SET reset_token='$token', reset_token_expiry='$expiry' WHERE uname='$email'";
        if(mysqli_query($conn, $query)){
            // Send email
            $to = $email;
            $subject = "Password Reset Authentication Code";
            $message = "Your Authentication Code is: $token";
            $headers = "From: no-reply@yourdomain.com\r\n";
            $headers .= "Reply-To: no-reply@yourdomain.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            if(mail($to, $subject, $message, $headers)){
                echo "Authentication code has been sent to your email.";
            } else {
                echo "Failed to send email.";
            }
        } else {
            echo "Failed to update reset token.";
        }
    } else {
        echo "No user found with this email address.";
    }
}
?>
