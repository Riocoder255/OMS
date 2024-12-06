    <?php
    include "./layouts/header.php";

    require 'layouts/sidebar.php';
    require 'layouts/topbar.php';
    require './admin_connect.php';






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

<div class="container" style="margin-top:100px; width: 90%; ">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 weight-bold text-primary">Product/Price</h6>
                   <a href="./product.php" class=" btn btn-primary float-end">Add new</a>
                    <br>
                    <a href="" class=" fas fa-print btn btn-outline-success"></a>
                </div>
                <div class="card-body" >
                    <?php
                    alertmessage();
                    alertme();
                    ?>
                    <div class="c">
                        <?php
                    $records_per_page = 2; // You can change this number as needed

// Get the current page number from the URL, default is page 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record based on the current page
$start_from = ($current_page - 1) * $records_per_page;

// Query to fetch records for the current page
$query = "SELECT * FROM product_price LIMIT $start_from, $records_per_page";
$result = mysqli_query($conn, $query) or die('QUERY IS FAILED' . mysqli_error($conn));

// Query to get total records in the database
$total_query = "SELECT COUNT(*) FROM product_price";
$total_result = mysqli_query($conn, $total_query);
$total_rows = mysqli_fetch_row($total_result)[0];

// Calculate total pages
$total_pages = ceil($total_rows / $records_per_page);
?>

<!-- HTML Table for displaying records -->
<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Design</th>
            <th>Product</th>
            <th>Dated</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><img src="product_upload/<?= $row['cover'] ?>" alt="Product Image" width="100"></td>
                    <td><?= $row['product_name'] ?></td>
                    <td><?= $row['created'] ?></td>
                    <td><a href="product_price_edit.php?product_id=<?= $row['product_id'] ?>" class="btn btn-outline-success fas fa-edit btn-sm" onclick="return confirm('Are you sure you want to Edit this data?')"></a></td>
                    <td><a href="./delete_price.php?delete=<?= $row['product_id'] ?>" class="btn btn-outline-warning fas fa-trash btn-sm" onclick="return confirm('Are you sure you want to delete this data?')"></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>

<!-- Pagination Links -->
<div class="pagination">
    <?php
    // Previous button
    if ($current_page > 1) {
        echo '<a href="?page=' . ($current_page - 1) . '" class="btn btn-outline-primary">Previous</a>';
    }

    // Loop through and display page numbers
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            echo '<a href="?page=' . $i . '" class="btn btn-primary">' . $i . '</a>';
        } else {
            echo '<a href="?page=' . $i . '" class="btn btn-outline-primary">' . $i . '</a>';
        }
    }

    // Next button
    if ($current_page < $total_pages) {
        echo '<a href="?page=' . ($current_page + 1) . '" class="btn btn-outline-primary">Next</a>';
    }
    ?>
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
