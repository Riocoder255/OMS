<!-- products.php -->





<?php



include './layouts-c/header-c.php';
include './layouts-c/navbar-c.php';
include './admin_connect.php';




 /// fetch  procuct  in category//


 
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("
        SELECT 
            product_price.*, 
            pricing.*
        FROM 
            product_price
        INNER JOIN 
            pricing ON product_price.price_id = pricing.id
        WHERE 
            product_price.product_id = ?
    ");
    $stmt->bind_param("s", $product_id); // Assuming product_id is a string
    $stmt->execute();
    $all_product = $stmt->get_result();
} else {
    $sql = "
        SELECT 
            product_price.*, 
            pricing.*
        FROM 
            product_price
        INNER JOIN 
            pricing ON product_price.price_id = pricing.id
    ";
    $all_product = $conn->query($sql);
}
?>

<main>


    <?php while ($row = mysqli_fetch_assoc($all_product)) { 
          // print_r($row); ?>
     
        <div class="card-2">
            <div class="image">
                <img src="product_upload/<?php echo $row['cover']; ?>" width="70px" height="70px" alt="Image">
            </div>
            <div class="caption">
               
                <p class="product_name"><?php echo $row['product_name']; ?></p>
              
              
            </div>
            <a href="find-semelar.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-danger">Find more</a>
        </div>
    <?php } ?>
</main>

<?php include './layouts-c/footer-c.php'; ?>
