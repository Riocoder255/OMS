<?php
include('./admin_connect.php');
include('./function.php');

if (isset($_POST['product_btn'])) {
    $cat_id = $_POST['cat_id'];
    $product_name = $_POST['product_name'];
    $sizes =$_POST['sizes'];

    

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
        $query = "INSERT INTO product_price(price_id ,product_name,  cover )
                  VALUES('$cat_id', '$product_name',  '$cover')";
        $sql_run = mysqli_query($conn, $query);

        if ($sql_run) {
            // Get the last inserted product ID
            $product_id = mysqli_insert_id($conn);

            // Insert sizes and colors
            foreach ($sizes as $size_id) {
              
                    foreach ($image_names as $image_name) {
                        $size_query = "INSERT INTO product_size (product_id, size_id,  images) VALUES ('$product_id', '$size_id',  '$image_name')";
                        mysqli_query($conn, $size_query);
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
    $product_id = $_POST['product_id'];
    $cat_id = $_POST['cat_id'];
    $p_name = $_POST['p_name'];
    $dated = $_POST['dated'];
    $old_image = $_POST['image_old'];

    // Handle cover image upload
    $new_image = $_FILES['cover']['name'];
    $upload_dir = "product_upload/";

    if ($new_image != "") {
        // Check if the file already exists
        if (file_exists($upload_dir . $new_image)) {
            echo "<script>alert('Image already exists in the folder. Please upload a different image.');</script>";
            echo "<script>window.location.href='./product_price.php';</script>";
            exit();
        } else {
            // Move the uploaded file to the target directory
            $image_path = $upload_dir . basename($new_image);
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $image_path)) {
                // If the upload is successful, delete the old image (optional)
                if (file_exists($upload_dir . $old_image)) {
                    unlink($upload_dir . $old_image);
                }
            } else {
                echo "<script>alert('Error uploading cover image.');</script>";
                echo "<script>window.location.href='./product_price.php';</script>";
                exit();
            }
        }
    } else {
        // If no new cover image is uploaded, keep the old image
        $new_image = $old_image;
    }

    // Handle design image upload (for additional images)
    $upload_dir_design = "design_upload/";

    // Check if images are uploaded and process each one
    if (!empty($_FILES['images']['name'][0])) { // Check if files are uploaded
        foreach ($_FILES['images']['name'] as $key => $design_image) {
            // Ensure the file name is not empty
            if ($design_image != "") {
                $design_image_path = $upload_dir_design . basename($design_image);
                // Check if the design image already exists
                if (file_exists($design_image_path)) {
                    echo "<script>alert('Design image already exists. Please upload a different image.');</script>";
                    echo "<script>window.location.href='./product_price.php';</script>";
                    exit();
                } else {
                    // Move the uploaded design image to the target directory
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $design_image_path)) {
                        // Optionally, you can delete the old image if required
                    } else {
                        echo "<script>alert('Error uploading design image.');</script>";
                        echo "<script>window.location.href='./product_price.php';</script>";
                        exit();
                    }
                }
            }
        }
    }

    // Update product in the product_price table
    $query = "UPDATE product_price SET 
                price_id = '$cat_id',
                product_name = '$p_name',
                created = '$dated',
                cover = '$new_image'
              WHERE product_id = '$product_id'";

    if (mysqli_query($conn, $query)) {
        // Update product sizes in the product_size table
        if (isset($_POST['sizes'])) {
            $sizes = $_POST['sizes']; // Assuming sizes are passed as an array

            // Delete existing sizes for this product
            $delete_sizes_query = "DELETE FROM product_size WHERE product_id = '$product_id'";
            mysqli_query($conn, $delete_sizes_query);

            // Insert the new sizes into the product_size table
            foreach ($sizes as $size_id) {
                // Insert each size with the product
                $insert_size_query = "INSERT INTO product_size (product_id, size_id, images) 
                                      VALUES ('$product_id', '$size_id', '$design_image')";
                mysqli_query($conn, $insert_size_query);
            }
        }

        echo "<script>alert('Product updated successfully.');</script>";
        echo "<script>window.location.href='./product_price.php';</script>";
    } else {
        echo "<script>alert('Error updating product.');</script>";
        echo "<script>window.location.href='./product_price.php';</script>";
    }
}
?>


