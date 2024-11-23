<?php
include "./layouts/header.php";

require 'user_layouts/sidebar.php';
require 'user_layouts/topbar.php';
require './admin_connect.php';


?>


<div class="container " style="margin-top:100px;">

    <div class="row justify-content-center">
        <div class="col-md-14">


            <div class="card">
                       
                <div class="card-header">
                    <h6 class="mb-0 weght-bold text-primary">Product/Price</h6>
                    
                    <br>
                    <a href="" class=" fas fa-print btn btn-outline-success"></a>

                </div>
                <div class="card-body">
                    
                    <?php
                    alertmessage();
                    alertme();
                    ?>

                    <div class="responsive-table">




                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                           
          <?php
            $query = "SELECT product_price.*, 
            category.*, 
            sizing.*
         
     FROM product_price
     INNER JOIN category ON product_price.category_id = category.id
     INNER JOIN sizing ON product_price.size_id = sizing.id ";
            $result = mysqli_query($conn, $query)or die('QUERY   IS  FAILED'.mysqli_error($conn));


            if(mysqli_num_rows($result)>0){
            ?>
            <tr>
              <th>#</th>
              <th>Design</th>
              <th>Product</th>
              <th>Category</th>
            
              <th>age_type</th>
              <th>Size</th>
              <th>Metric number</th>
              <th>Price</th>
              <th>  Min_Pcs</th>
              <th>Freebie</th>

              <th>Dated</th>



             


              
             


            </tr>
    
         

          <?php
          $count=1;
        
           while($row = mysqli_fetch_array($result))
           {
            ?>
             
           <tr> 
            <td>
               <?php echo $count;?>
            </td>
            <td><?='  <img src="product_upload/' . $row['cover'] . '"width="70px;"height="70px;"alt="Image"' ?></td>

            <td>
               <?php echo $row['product_name'];?>

            </td>
            <td>
               <?php echo $row['cat_name'];?>
            </td>
            
            <td>
               <?php echo $row['age_type'];?>
            </td>
            <td>
               <?php echo $row['Size'];?>
            </td>
            <td>
               <?php echo $row['matric'];?>
            </td>
            <td ><i class=" btn-success">  <?php echo $row['price'];?> </i>
              
            </td>
            <td>
               <?php echo $row['pcs'];?>
            </td>
            <td>
               <?php echo $row['Freebie'];?>
            </td>
            
            
            <td>
               <?php echo $row['created'];?>
            </td>
           

            
            
          
           
            

           
            
        
           </tr>

<?php        
          
          $count++;  
              
           }

            
           }
       
           else

           {
            ?>
            <td>NO record</td>
            <?php

           }
       
          

?>


                            </tbody>
                        </table>





                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<?php
include "./user_layouts/footer.php";
include "./user_layouts/scripts.php";

?>