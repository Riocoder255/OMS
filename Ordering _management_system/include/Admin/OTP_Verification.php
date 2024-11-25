<?php
session_start();

// Check if the user has the OTP stored in the session
if (!isset($_SESSION['otp'])) {
    header('Location: forgot_password.php'); // Redirect to the form if no OTP is set
    exit(0);
}

// Handle OTP verification
if (isset($_POST['otp'])) {
    $userOtp = $_POST['otp'];

    // Check if the entered OTP matches the one stored in the session
    if ($userOtp == $_SESSION['otp']) {
        // OTP is correct, allow user to reset password
        header('Location: reset_password.php');
        exit(0);
    } else {
        $_SESSION['message'] = 'Invalid OTP. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="./Display/css/login.css">
<body>

<?php 
              if(isset($_SESSION['status'])){
                ?>
                <div class="alert alert-success" role="alert">
                  <?php echo $_SESSION['status'];?>

               </div>
                <?php
                
                unset($_SESSION['status']);
              }

              ?>
    <form action="otp_verification.php" method="post">

        <?php
        include ('./message.php');
        // Show any messages, if set
       
        ?>
        
        <p style="color: gray;">Enter the OTP sent to your email address:</p>
        <input type="text" name="otp" placeholder="Enter OTP" class="info" required>
        <button type="submit">Verify OTP</button>

        <a href="./login.php">Back to Login</a>

    </form>
</body>
</html>
