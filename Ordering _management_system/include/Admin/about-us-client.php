<?php 
include ("./layouts-c/header-c.php");
include ("./layouts-c/navbar-c.php")
?>

<?php

$sql =" SELECT * FROM About_us  ";

$all_product = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    main{
        max-width:100vw;
     
        max-height: 100vh;
        margin-top: 200px;
        top:0;
        left:0;
        padding: 20px;
        
        text-align: center;
         
    }

    .container4 h4{
        color: green;
        width:100%;
        font-size: 2rem;
        letter-spacing: 0.1em;
     
    }
    
    .container4 .content{
        padding: 40px;
        margin: 5px;
         width:100%;
         line-height: 25px;
         font-weight: 400;
         font-size: 20px;
    }

    
</style>
<body>
    <main>

    <?php
          while($row = mysqli_fetch_assoc($all_product)){

          
          ?>
    <div class="container4">
        <h4 class="text-header">
      <?php echo $row ['Title']?>
        </h4>
         
         <div class="content">
            <?php echo $row['content'] ?>
         </div>
   
        
    </div>
    </main>
    <?php
          }

    ?>
</body>
</html>




