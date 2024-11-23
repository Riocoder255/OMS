<?php
include('./admin_connect.php');
include('./function.php');

if (isset($_POST['product_btn'])) {
    $cat_id = $_POST['cat_id'];
    $product_name = $_POST['product_name'];
    

    // Handle file uploads
    $cover = $_FILES['cover']['name'];
    $image_names = [];

    foreach ($_FILES['image']['name'] as $key => $image_name) {
        $temp_name = $_FILES['image']['tmp_name'][$key];
        $new_image_name = time() . '-' . $image_name;
        if (move_uploaded_file($temp_name, "design_upload/$new_image_name")) {
            $image_names[] = $new_image_name;
        }
    }

    if (empty($cat_id) || empty($product_name) ||  empty($cover)) {
        redirect('product_price.php', "All fields must be filled out.");
    } else if (file_exists("product_upload/" . $cover)) {
        redirect('product_price.php', "Image already exists. '$cover'");
    } else {
        // Move cover image to the upload directory
        move_uploaded_file($_FILES['cover']['tmp_name'], "product_upload/$cover");

        // Insert product into product_price table
        $query = "INSERT INTO product_price(category_id, product_name,  cover)
                  VALUES('$cat_id', '$product_name',  '$cover')";
        $sql_run = mysqli_query($conn, $query);

        if ($sql_run) {
            // Get the last inserted product ID
            $product_id = mysqli_insert_id($conn);

            // Insert sizes and colors
            foreach ($sizes as $size_id) {
                foreach ($colors as $color_id) {
                    foreach ($image_names as $image_name) {
                        $size_query = "INSERT INTO product_size (product_id, size_id, color_id, images) VALUES ('$product_id', '$size_id', '$color_id', '$image_name')";
                        mysqli_query($conn, $size_query);
                    }
                }
            }

            redirect('product_price.php', "Product and sizes added successfully");
        } else {
            redirect("product_price.php", "Error adding product");
        }
    }
}




// Include your database connection

if (isset($_POST['update_product'])) {
    // Fetch form data
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $category_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $size_id = mysqli_real_escape_string($conn, $_POST['size_id']);
    $dated = mysqli_real_escape_string($conn, $_POST['dated']);
    $image_old = mysqli_real_escape_string($conn, $_POST['image_old']);

    // Handle image upload
    $image_new = $_FILES['cover']['name'];
    $image_temp = $_FILES['cover']['tmp_name'];

    // If a new image is uploaded, use it; otherwise, keep the old image
    if (!empty($image_new)) {
        $image_path = "product_upload/" . $image_new;
        move_uploaded_file($image_temp, $image_path);
    } else {
        $image_path = $image_old;
    }

    // Update query
    $query = "
        UPDATE product_price 
        SET 
            category_id = '$category_id',
            product_name = '$product_name',
            size_id = '$size_id',
            created = '$dated',
            cover = '$image_path'
        WHERE 
            product_id = '$product_id'
    ";

    if (mysqli_query($conn, $query)) {
        // Redirect or display a success message
        echo "<script>alert('Product updated successfully!');</script>";
        echo "<script>window.location.href='./product_price.php';</script>";
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

?>
