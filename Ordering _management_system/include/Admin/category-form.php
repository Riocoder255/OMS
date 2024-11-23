<?php
include './function.php';
include_once './admin_connect.php';

if(isset($_POST['cate_btn'])){
    $cat_titles = $_POST['cat_name'];

    foreach ($cat_titles as $cat_title) {
        $cat_title = validated($cat_title);

        if (empty($cat_title)) {
            redirect('category.php', "Category title can't be blank");
            exit();
        }

        $query1 = "SELECT * FROM sub_category WHERE cat_name = '$cat_title'";
        $result1 = mysqli_query($conn, $query1);

        if (mysqli_num_rows($result1) > 0) {
            redirect('category.php', "Category '$cat_title' already exists. Try another.");
            exit();
        } else {
            $query = "INSERT INTO sub_category (cat_name) VALUES ('$cat_title')";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                redirect('category.php', "Error adding category '$cat_title'.");
                exit();
            }
        }
    }

    redirect('category.php', "Categories added successfully");
}


if (isset($_POST['update_cat'])) {
    $cat_id = $_POST['cat_id'];
    $cat_name = validated($_POST['cat_name']);

    if (empty($cat_name)) {
        redirect('category.php', "Category title can't be blank");
        exit();
    }

    $query1 = "SELECT * FROM sub_category WHERE cat_name = '$cat_name' AND id != '$cat_id'";
    $result1 = mysqli_query($conn, $query1);

    if (mysqli_num_rows($result1) > 0) {
        redirect('category.php', "Category '$cat_name' already exists. Try another.");
        exit();
    } else {
        $query = "UPDATE sub_category SET cat_name='$cat_name' WHERE id='$cat_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            redirect('category.php', "Category updated successfully");
        } else {
            redirect('category.php', "Error updating category");
        }
    }
}



?>