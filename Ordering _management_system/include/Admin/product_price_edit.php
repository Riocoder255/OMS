<?php
include "./layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';
include './admin_connect.php';

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];

    // Prepare the SQL query
    $query = "SELECT * FROM product_price WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_array($result);
} else {
    echo "Product ID not provided.";
    exit;
}

$qry = mysqli_query($conn, "SELECT DISTINCT
        product_price.*, 
        pricing.*, 
        product_size.product_id, 

        product_size.images
        
       
    FROM 
        product_price
    INNER JOIN 
        pricing ON product_price.price_id = pricing.id
    INNER JOIN 
        product_size ON product_price.product_id = product_size.product_id
     

    WHERE 
        product_price.product_id = '$id';
  ");

  $image_unique = [];
$size= [];

  $product_details = [];
    while ($row = mysqli_fetch_assoc($qry)) {
        $image_unique [] = $row;
        $size [] = $row;
      // Process images and ensure uniqueness
     
      
  }


?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

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
                    </div>
                    <div class="col">
                        <label for="">Edit Category</label>
                        <select class="form-control" name="cat_id" required>
                            <option value="">------Select Category------</option>
                            <?php
                            $query = "SELECT * FROM  pricing";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_array($query_run)) {
                                    echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="">Edit product</label>
                <input type="text" value="<?php echo $res['product_name']; ?>" class="form-control" name="p_name">
            </div>

            
            <div class="form-group mb-4">
            
                    <select name="sizes[]" id="sizes" class="form-control selectpicker" data-live-search="true" multiple required>

                            <option disabled>Select_size</option>
                            <?php
                        // Fetch sizes from database and populate options
                        $query = "SELECT * FROM sizing";
                        $query_run = mysqli_query($conn, $query);
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_array($query_run)) {
                                echo "<option value='{$row['id']}'>{$row['Size']}</option>";
                            }
                        }
                        ?>
                        </select>
                    
            </div>
            <div class="form-group mb-4">
                <input type="date" value="<?php echo $res['created']; ?>" class="form-control" name="dated">
            </div>
           
                <div class="row">
 
                <div class="col">
               
                <img src="<?= "product_upload/" . $res['cover'] ?>" alt="Image" width="10%" style="border-radius:20%;">
                <input type="hidden" value="<?= $res['cover'] ?>" name="image_old">
                </div>
                <div class="col">
                <br><br><br>    
                <label for="images">Upload Images:</label>
                 
                <?php 
    foreach ($image_unique  as $product ) {
        // Split the images by commas if they are stored as comma-separated values
        $images = explode(',', $product['images']); // Example: "image1.jpg,image2.jpg,image3.jpg"
        
        // Display each image as a thumbnail
        foreach ($images as $image) {
            echo "<img src='design_upload/" . trim($image) . "' data-image='product_upload/" . trim($image) . "' style='width:15%'>";
        
          }
    }
    ?>
 <input type="file" name="images[]" multiple>
                </div>
              
                
            </div>
            <div class="form-group mb-4">
                <input type="file" name="cover">
            </div>
           


            <div class="form-group mb-4">
                <button type="submit" class="btn btn-success btn-sm" name="update_product" onclick="return confirm('Are you sure you want to Update this data?')">Update product</button>
                <a href="./product_price.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 5 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script  src="https://code.jquery.com/jquery-3.6.0.js"></script>
<?php
include "./layouts/footer.php";
include "./layouts/scripts.php";
?>
