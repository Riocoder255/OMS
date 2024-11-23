<!-- products.php -->
<?php



include './layouts-c/header-c.php';
include './layouts-c/navbar-c.php';
include './admin_connect.php';

$sql = "SELECT * FROM product_price";
if (isset($_GET['id'])) {
    $cat_ID = $_GET['id'];
    $sql .= " WHERE category_id ='$cat_ID'";
}
$all_product = mysqli_query($conn, $sql);
?>

<main>


    <?php while ($row = mysqli_fetch_assoc($all_product)) { ?>
        <div class="card-2">
            <div class="image">
                <img src="product_upload/<?php echo $row['cover']; ?>" width="70px" height="70px" alt="Image">
            </div>
            <div class="caption">
                <p class="rate">
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </p>
                <p class="product_name"><?php echo $row['product_name']; ?></p>
              
              
            </div>
            <a href="./find-semelar.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-danger">Find Similar</a>
        </div>
    <?php } ?>
</main>

<?php include './layouts-c/footer-c.php'; ?>
