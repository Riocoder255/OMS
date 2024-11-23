<?php


include './layouts-client/header.php';
include_once './layouts-client/navbar.php';
include './connect.php';

$sql =" SELECT * FROM product_price  ";
$all_product = mysqli_query($conn,$sql);

?>

<form class="d-flex search">
        <input class="form-control me-4 " type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success " type="submit">Search</button>
      </form>
     </div>

          <!----mean-end-->
        <div>
            <img src="./image/koronadal_branch.jpg" alt=""class="header-image">
        </div >
         <div class="bottom">
          <h5>
          
          </h5>
         </div>
        <main>
          <?php
          while($row = mysqli_fetch_assoc($all_product)){

          
          ?>
                 <div class="card-2" >
       <a href="#" style="text-decoration: none;">
        <div class="image ">
          <img src="./image/download.jpg" alt="">


        </div>
        <div class="caption">
          <p class="rate">
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
            <i class="fa-regular fa-star"></i>
          </p>
          <p class="product_name"><?php echo $row["product_name"]?></p>
          <P class="price"><b>$ 300</b></P>
          <div class="discount"><b><del>$100</del></b></div>

        </div>
       </a>
        
       </div>
       <?php 

          }
?>
</main>

 
        
       
       
    
  <?php
include './layouts-client/footer.php';
  ?>