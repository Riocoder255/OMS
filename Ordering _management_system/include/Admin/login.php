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
    <form action="./login-code.php" method="POST" enctype="multipart/form-data">
        
         <div class="header">

        
            <img src="./image/chan.jpg" alt="">
            <p>Chantong Enterprise</p>
           
         </div>

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
          <?php  
            include './message.php';
          ?>
         
        <input type="email" name="email" placeholder="Email " class="info" >
        <input type="password"name="pass" placeholder="Password" class="info" >
            
        <button type="submit"  name="login_btn">Login </button>
        <a href="Send_email.php">Forgot <span>Password</span></a>

      </form>
</body>
</html>