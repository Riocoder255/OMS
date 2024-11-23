    <?php
    include "./layouts/header.php";

    require 'layouts/sidebar.php';
    require 'layouts/topbar.php';
    require './admin_connect.php';





$query = "SELECT * FROM sizing";
$query_run = mysqli_query($conn, $query);

$sizes = [];
if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_array($query_run)) {
        $sizes[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./Display/css/virtual-select.min.css">
    <style>
        #multipleSelect {
            max-width: 100%;
            width: 350px;
        }
        .vscomp-toggle-button {
            padding: 10px 30px 10px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="modal fade" id="Insertproduct" tabindex="-1" aria-labelledby="InsertproductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 primary" id="InsertproductLabel">Add product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./product_form.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-2">
                        <select class="form-select" name="cat_id" style="width: 200px;" required>
                            <option value="">------Select Category------</option>
                            <?php
                            $query = "SELECT * FROM Sub_category";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_array($query_run)) {
                                    echo "<option value='{$row['id']}'>{$row['cat_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-4 float-end" style="margin-top:-70px;">
                        <input type="text" required class="form-control" name="product_name" style="width:220px;" placeholder="Product name">
                    </div>
                    <div class="form-group mb-2">
                        <select  name="sizes" placeholder="Select Sizes" class="form-control">
                            <?php
                            foreach ($sizes as $size) {
                                echo "<option value='{$size['id']}'>{$size['Size']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-2 float-end" style="margin-top: -70px;">
                        <select name="age_id" class="form-select" style="width: 200px;">
                            <option value="">------Select Age Type-----</option>
                            <?php
                            $query = "SELECT * FROM category";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_array($query_run)) {
                                    echo "<option value='{$row['id']}'>{$row['age_type']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" name="price" class="form-control" style="width: 100px;" placeholder="Price">
                    </div>
                    <div class="form-group mb-2" style="margin-left:120px;margin-top:-65px;">
                        <label>Product Sale</label>
                        <input type="text" name="dprice" class="form-control" style="width: 100px;">
                    </div>
                    <div class="form-group mb-2">
                        <label>Cover Image</label>
                        <input type="file" name="cover" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Upload Image 1</label>
                        <input type="file" name="image1">
                    </div>
                    <div class="form-group mb-2">
                        <label>Upload Image 2</label>
                        <input type="file" name="image2">
                    </div>
                    <div class="form-group mb-2">
                        <label>Upload Image 3</label>
                        <input type="file" name="image3">
                    </div>
                    <div class="form-group mb-2">
                        <label>Upload Image 4</label>
                        <input type="file" name="image4">
                    </div>
                    <div class="form-group mb-2">
                        <label>Upload Image 5</label>
                        <input type="file" name="image5">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="product_btn" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container" style="margin-top:100px;">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 weight-bold text-primary">Product/Price</h6>
                   <a href="./product.php" class=" btn btn-primary float-end">Add new</a>
                    <br>
                    <a href="" class=" fas fa-print btn btn-outline-success"></a>
                </div>
                <div class="card-body">
                    <?php
                    alertmessage();
                    alertme();
                    ?>
                    <div class="c">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  
                                    <th>Design</th>
                                    <th>Product</th>
                                    <th>Category</th>

                                    <th>Dated</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT 
    product_price.*, 
    Sub_category.cat_name 
FROM 
    product_price
INNER JOIN 
    Sub_category 
ON 
    product_price.category_id = Sub_category.id ;
                                       ";
                                $result = mysqli_query($conn, $query) or die('QUERY IS FAILED' . mysqli_error($conn));

                                if (mysqli_num_rows($result) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                ?>
                                        <tr>
                                         
                                            <td><img src="product_upload/<?php echo $row['cover']; ?>" width="70px" height="70px" alt="Image"></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['cat_name']; ?></td>
                                            
                                            <td><?php echo $row['created']; ?></td>
                                            <td>
                                                <a href="./product_price_edit.php?product_id=<?= $row['product_id'] ?>" class="btn btn-outline-success fas fa-edit btn-sm" onclick="return confirm('Are you sure you want to Edit this data?')"></a>
                                            </td>
                                            <td>
                                                <a href="./delete_price.php?delete=<?= $row['product_id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')" class="btn btn-outline-warning fas fa-trash btn-sm"></a>
                                            </td>
                                        </tr>
                                    <?php
                                          
                                        }
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

<script src="./Display/Js/virtual-select.js"></script>
</body>
</html>

<?php
include "./layouts/footer.php";
include "./layouts/scripts.php";
?>
