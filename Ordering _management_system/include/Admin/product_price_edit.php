<?php
include "./layouts/header.php";

require 'layouts/sidebar.php';
require 'layouts/topbar.php';

include './admin_connect.php';
?>
<?php

    $id = $_GET['product_id'];
    $qry = mysqli_query($conn, "SELECT * FROM   product_price  WHERE product_id ='$id'");
    $res=mysqli_fetch_array($qry);




?>
            <div class="container" style="margin-top: 20px;">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary"> Edit product_price</h6>
                </div>
                <div class="card-body">
                    <form action="./product_form.php" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-4">
                            <div class="row">
                                <div class="col">
                                <input type="hidden" value="<?= $res['product_id'] ?>" name="product_id">
                            <label for="">Edit Category</label>
                           
<Select class="form-control" name="cat_id"    required>

<option value="">------Select Category------</option>
<?php
$query = "SELECT * FROM  Sub_category";

$quert_run = mysqli_query($conn,$query);
if(mysqli_num_rows($quert_run)>0){
    while($row = mysqli_fetch_array($quert_run)){
        echo "<option value='{$row['id']}'>{$row['cat_name']}
        </option>";
    }
}
?>




                            </select>
                                </div>
                                <div class="col">
                                    <label for="">Edit product</label>
                                <input type="text" value="<?php echo $res['product_name']; ?>" class="form-control" name="p_name">
                                </div>
                            </div>
                        </div>


                       
                          
                      

                        

                       <div class="row">
                        <div class="col">
                            
                        <select name="size_id" id="" class="form-select">

<?php
 $sql = "SELECT * FROM sizing"; // Assume you have a `categories` table
 $result = mysqli_query($conn,$sql);

 if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         echo '<option value="' . $row['id'] . '">' . $row['Size'] . '</option>';
     }
 } else {
     echo '<option>No categories available</option>';
 }

    
    



?>  



</select>
                        </div>

                        <div class="col">
                        <input type="date" value="<?php echo $res['created']; ?>" class="form-control" name="dated">
                        
                        </div>
                       </div>
                            <br>
                            
                           
                        
                        
                           
      
                        

                        <div class="form-group mb-4">
                        <img src="<?=   "product_upload/".$res['cover']?>" alt=""width="10%" alt="image"style="border-radius:20%;">
                              <input type="hidden" value="<?=  $res['cover']?>" name="image_old">
                        </div>
                        <div class="form-group mb-4">
                            <input type="file" class=" fas fa-image" name="cover">

                        </div>
                        <div class="form-group mb-4">

                        </div>
                        <div class="form-group mb-4">
                        <button type="submit" class="btn btn-success btn-sm " name="update_product"onclick="return confirm('Are you sure you want to Update this data?')" >Update product</button>
                         
                          <a href="./product_price.php" class="btn btn-secondary" >back</a>
                        </div>

                   
                     


                    </form>
                </div>
            </div>



<?php


include "./layouts/footer.php";
include "./layouts/scripts.php";

?>