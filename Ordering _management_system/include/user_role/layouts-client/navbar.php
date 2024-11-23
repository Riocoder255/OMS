<?php 
session_start();
?>

<div  class="w-100 d-flex  justify-content-between">
      <div style="margin-left: -600px;">
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
      <div class="container d-flex justify-content-between">
        <div class="navba-container-logo">
          <div class="logo-container">
            <img src="./image/norala.jpg" alt="" class="logo-nav">
          </div>
         <div class="brand-name-container">
          <p class="brand-name">
            Chantong <br>
            <span class="brand-sub-name">
              Enterprise
            </span>
          </p>
         </div>
        </div>
        <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
            
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="#"><i class="fa-solid fa-house"></i>Home</a>
                </li>
                
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="#">Product</a>
                </li>
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="#">About</a>
                </li>
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="#">Contact </a>
                </li>
              
           
              </ul>
              <div>
                  <a href="" class="text-decoration-none text-dark nav-icon "><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="" class="text-decoration-none text-dark nav-icon"><i class="fa-solid fa-user">

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

                </i></a>

            
              </div>
            </div>
           
          </div>
        </nav>
      </div>
     </div>
     <div>
      
     </div>