<?php
include './function.php';


if(isset($_SESSION['auth']))
{
    $_SESSION['message'] ="You are already logged In";
    header('Location: user-dash.php');
    exit(0);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="./Display/css/style-client-design.css" />
 <link rel="stylesheet" href="./Display/css/login.css">
<body>
<form action="./send _authontication-code.php" method="post" enctype="multipart/form-data">
        <input type="email" name="email" placeholder="Enter your email" required class="info">
        <button type="submit">Send Authentication Code</button>
        <a href="./login.php">Back to Login</a>

    </form>
</body>
</html>