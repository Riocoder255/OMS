<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="Display/css/style-c.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<link rel="stylesheet" href="./Display/css/sign-in.css">
<body>
    <form action="loginform.php" method="post">
        
         <div class="header">
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
            <img src="./image/chantong.jpg" alt="">
            <p>Chantong Enterprise</p>
           
         </div>
         <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']?></p>
           <?php  }?>
        <input type="text" name="email" placeholder="Email address" class="info" >
        <input type="password"name="pass" placeholder="Password" class="info" >
         
        <button type="submit">Sign in</button>
        <a href="./signup.php">forgot<span> password</span></a><br>
        <a href="./signup.php">Don't have an Account?<span> Sign up</span></a>
      </form>
</body>
</html>
