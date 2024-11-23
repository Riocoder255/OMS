<?php 
include ('./admin_connect.php');
include ('./layouts-c/header-c.php');
include ('./layouts-c/navbar-c.php');



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .container-6{
        width:50%;
        padding: 20px;
        font-size:12px;
        margin: 10px auto;
        border-radius: 10px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;     }
     p{
        color: #050C9C;
        padding: 1px;
      
        
     }
</style>
<body>
    <div class="container-6 m-4">
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
              if(isset($_SESSION['success'])){
                ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $_SESSION['success'];?>

               </div>
                <?php
                
                unset($_SESSION['success']);
              }

              ?>
    <form action="./step-form.php" method="post" enctype="multipart/form-data">

          <div class="image" style="margin-left:800px;">
          <p style="width: 100px;">Upload Reciep</p>
          <input type="hidden" name="order_id">

        <input type="file" name='Uploaded'id="">

<br><br>
<button type="submit" class=" btn btn-success" name="btn-upload">Upload</button>
        </form>
         
          </div>
        <div class="wrapper">
    <h4>GCASH PAYMENT INSTRUCTIONS</h4>
     <p>1. <span>Open your GCash apps</span></p>
     <p>2. <span>Click on the 'Send Money" icon</span></p>
     <p>3. <span>Enter the Account Number 090900292</span></p>
     <p>4. <span>Enter the amount</span></p>
     <p>5. <span>Click"Next".</span></p>
     <p>6. <span>Review the details and click "Confirm"</span></p>
     <p>7. <span>Enter the One Time PIN(OTP)sent to your GCASH registered mobile number</span></p>
     <p>8. <span>Click Confirm</span></p>
     <p>9. <span>Take  a screenshot of the transaction and upload in the "Upload Reciep" section of the website</span></p>

     </div>

    </div>
</body>
</html>
<?php include ('./layouts-c/footer-c.php') ?>