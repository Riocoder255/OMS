<?php
include 'admin_connect.php';
$username = $_SESSION['name'];

// Initialize cart count
$cart_count = 0;

// Check if cart exists in session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$cart_count = 0;
if ($user_id) {
    // Query to count the number of items in the cart
    $query = "SELECT COUNT(*) AS total_items FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $cart_count = $row['total_items'] ? $row['total_items'] : 0; // Default to 0 if null
    }

    $stmt->close();
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
            
              <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
               
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
$sql = "SELECT * FROM pricing";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
?>
    <a class="dropdown-item" href="home-client.php?id=<?php echo $row['id']; ?>" style="text-decoration: none;">
        <?php echo htmlspecialchars($row["category_name"]); ?>
    </a>
<?php
}
?>

</div>
                
               


                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="feed_back.php"><i class="fas fa-feedback"></i>Feed back</a>
                </li> 
                <li class="nav-item nav-items">
                  <a class="nav-link nav-link-s" href="orders_history.php"><i class="fas fa-bell"></i>My orders</a>
                </li>
              
           
              </ul>
               
            
             
           


              <div>
               
              <a href="./cart_view.php?product_id=$product_id" class="text-decoration-none text-dark nav-icon "><i class="fa-solid fa-cart-shopping"></i>
               <span class="btn btn-danger btn-sm"> <?php echo $cart_count; ?>
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

