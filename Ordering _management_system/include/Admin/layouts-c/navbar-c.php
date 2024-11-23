

<?php

$username = $_SESSION['name'];

// Initialize cart count
$cart_count = 0;

// Check if cart exists in session
if (isset($_SESSION['cart'])) {
    // Count unique product IDs in the cart
    $cart_count = count($_SESSION['cart']);
}
?>

<div  class="w-100 d-flex  justify-content-between">
      <div style="margin-left: 50px;">
        <i class="fa-solid fa-envelope text-light info-contact"></i>
        <a href=""class="navbar-sm-brand text-light text-decoration-none info-contact">chantongEnterprise@company.com</a>
        <i class="fa-solid fa-phone text-light info-contact"></i>
        <a href=""class="navbar-sm-brand text-light text-decoration-none info-contact">00299209</a>
      
      </div>
     <div>
      <a href=""><i class="fa-brands fa-facebook text-light me-2"></i></a>
      <a href=""><i class="fa-brands fa-instagram text-light  me-2"></i></a>
     </div>

    </div>
   </div>
     
      </div>
    </div>
  </nav>
</div>
  
    <!--------end nav-->

     <!----mean-nav-->
     <div>
      <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-5 d-flex justify-content-between">
        <div class="navba-container-logo">
      
      
          </p>
         </div>
        </div>
        <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
            
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="./home-client.php"><i class="fa-solid fa-house"></i>Home</a>
                </li>
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="./customize.php">Costumize</a>
                </li>
               
                <div class="dropdown mb-2 nav-items">
  <a class=" nav-link nav-link-s dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
   Category
  </a>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">

  <?php
  include ('./admin_connect.php');

    $query = "SELECT * FROM   sub_category ";

    $quert_run = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($quert_run)){
          ?>
              <li><a class="dropdown-item" href="home-client.php?id=<?php echo $row["id"]?>"><?php echo $row["cat_name"]?></a></li>


          <?php
           
        }
    
    ?>
    
</div>
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="about-us-client.php">About</a>
                </li>
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="#">Contact </a>
                </li>



                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="view-orders.php"><i class="fas fa-bell"></i></a>
                </li>
              
           
              </ul>
               
            
             
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
              <div>
               
              <a href="./cart_view.php?product_id=$product_id" class="text-decoration-none text-dark nav-icon "><i class="fa-solid fa-cart-shopping"></i>
               <span class="btn btn-danger btn-sm"><?php  echo  $cart_count;?>
             </span>
           
            </a>
               
              




 <div class="btn-group con">
  

  <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
  
  <a href="" class="text-decoration-none text-dark nav-icon "><i class="fa-solid fa-user " >

  </i>
  <?php 
              if(isset($_SESSION['stat'])){
                ?>
                <div class="alert alert-success" role="alert">
                  <?php echo $_SESSION['stat'];?>

               </div>
                <?php
                
                unset($_SESSION['stat']);
              }

              ?>
</a>

  <?php echo htmlspecialchars($username); ?>
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="#">Setting</a></li>
   <form action="logout-customer.php" method="post" enctype="multipart/form-data">
    <button type="submit" name="logout_btn" class=" btn btn-success btn-sm"><i class="fa-solid fa-power-off"></i>Log Out</button>
   </form>

    
  </ul>
  
</div>

              </div>
            </div>
           
          </div>
        </nav>
      </div>
     </div>
     <div>
      
     </div>