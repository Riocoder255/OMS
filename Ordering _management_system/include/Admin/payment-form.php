<?php
require './admin_connect.php';

if (isset($_POST['product_btn'])) {
    $category_id = $_POST['cat_id'];
    $product_name = $_POST['product_name'];
    $age_id = $_POST['age_id'];
    $price = $_POST['price'];
    $dprice = $_POST['dprice'];
    $cover = $_FILES['cover']['name'];
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $image4 = $_FILES['image4']['name'];
    $image5 = $_FILES['image5']['name'];
    $sizes = $_POST['sizes']; // This is an array

    // Folder where images will be uploaded
    $target_dir = "product_upload/";

    // Move uploaded images to the target directory
    move_uploaded_file($_FILES['cover']['tmp_name'], $target_dir . $cover);
    move_uploaded_file($_FILES['image1']['tmp_name'], $target_dir . $image1);
    move_uploaded_file($_FILES['image2']['tmp_name'], $target_dir . $image2);
    move_uploaded_file($_FILES['image3']['tmp_name'], $target_dir . $image3);
    move_uploaded_file($_FILES['image4']['tmp_name'], $target_dir . $image4);
    move_uploaded_file($_FILES['image5']['tmp_name'], $target_dir . $image5);

    // Insert data into product_price table for each selected size
    foreach ($sizes as $size_id) {
        $query = "INSERT INTO product_price (category_id, product_name, age_id, price, dprice, cover, image1, image2, image3, image4, image5, size_id) 
                  VALUES ('$category_id', '$product_name', '$age_id', '$price', '$dprice', '$cover', '$image1', '$image2', '$image3', '$image4', '$image5', '$size_id')";

        if (mysqli_query($conn, $query)) {
            echo "New record created successfully for size ID: $size_id<br>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
