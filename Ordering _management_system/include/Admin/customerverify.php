
<?php
session_start();
include('./admin_connect.php');  // Make sure this includes your DB connection

// Check if OTP is entered
if (isset($_POST['otp'])) {
    $entered_otp = $_POST['otp'];
    $email = $_SESSION['email'];  // Email should be stored in session during registration

    // Fetch OTP from the database for the given email
    $sql = "SELECT otp, is_verified FROM customer WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_otp = $row['otp'];  // The OTP stored in the database
        $is_verified = $row['is_verified'];  // Whether the user is already verified

        // Check if the OTP entered by the user matches the stored OTP
        if ($entered_otp == $stored_otp) {
            // If OTP matches, mark the user as verified
            $sql_update = "UPDATE customer SET is_verified=1 WHERE email='$email'";
            if (mysqli_query($conn, $sql_update)) {
                // OTP verified successfully
                echo "<div class='alert alert-success'>OTP verified successfully! You can now login.</div>";
                // Redirect or display success message
                header("Location: sign-in.php");  // Redirect to login page
                exit();
            } else {
                echo "<div class='alert alert-danger'>An error occurred while verifying OTP.</div>";
            }
        } else {
            // If OTP doesn't match
            echo "<div class='alert alert-danger'>Invalid OTP. Please try again.</div>";
        }
    } else {
        // If the user doesn't exist
        echo "<div class='alert alert-danger'>No user found with this email address.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .box input{
       background: none;
       outline: none;
       border: none;

    }
    .box{
        border-bottom: 2px solid  silver;
    }
</style>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-3">Verify OTP</h3>
            <form action="" method="POST">
                <div class="mb-3 box">
                    
                    <input type="text" id="otp" name="otp" class="" placeholder="Enter OTP" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="">Verify</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




