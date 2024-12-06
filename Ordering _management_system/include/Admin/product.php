<?php
include('./admin_connect.php');
include('./layouts/header.php');
include('./layouts/sidebar.php');

include('./layouts/topbar.php');



$query = "SELECT * FROM sizing";
$query_run = mysqli_query($conn, $query);

$sizes = [];
if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_array($query_run)) {
        $sizes[] = $row;
    }
}


?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<div class="container-md">
    <div class="cord-body">
    <?php
                    alertmessage();
                    alertme();
                    ?>
        <div class="card-header">
            <h3 class="text-dark">Add Product</h3>
        </div>
        <div class="card-body">
            <form action="./product_form.php" method="post"id="multiple_select_form" enctype="multipart/form-data">

                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Product" aria-label="First name" name="product_name">
                    </div>
                    
                    
                   
                </div>
                <br>
               
                
                <div class="row">
                    <div class="col">
                        <select class="form-select form-select-lg mb-3" aria-label="Large select example" name="cat_id">
                            <option selected>Select Sub Category</option>
                            <?php
                            $query = "SELECT * FROM pricing";
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
                    <div class="col">
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
                  

                </div>
                <br>
                <div class="row">
                    
                    <div class="col">
                        <label for="">Product_image</label>
                        <input type="file" class="form-control" placeholder="Price" aria-label="Last name" name="cover">
                    </div>

                  
                    <label for="">Product_Design</label>
                    <div class="col">
                        <input type="file" class="form-control" placeholder="Product_sales" aria-label="First name"name="image[]"multiple>
                    </div>

                </div>
        </div>
    </div>
    <div class="form-group float-end" style="margin-top: 50px;">
        <button type="submit" class=" btn btn-primary" name="product_btn">Add product</button>
        <a href="./product_price.php" class="btn btn-secondary">Back</a>
    </div>
    </form>

</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <script  src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','.remove-btn',function(){
            $(this).closest('.main-form').remove();
        });
        $(document).on('click','.add-more-form',function(){
            $('.paster-new-form').append(' <div class="main-form  mt-3 border-bottom">\
                        <div class="row">\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <label for="">Category Title</label>\
                                    <input type="text" class="form-control" name=[>\
                                </div>\ </div>\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <br>\
                                    <button class="remove-btn btn btn-danger ">Remove</button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>');

        });
    });
</script>
<?php
include('./layouts/scripts.php');
include('./layouts/footer.php');

?>