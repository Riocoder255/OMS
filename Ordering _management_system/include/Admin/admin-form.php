<?php
include_once "./admin_connect.php";
include_once "./function.php";

if (isset($_POST['save_data'])) {
    $name =   validated($_POST['fname']);
    $lname = validated($_POST['lname']);
    $phone = validated($_POST['phone']);
    $branch_id = validated($_POST['branch_id']);
    $uname = validated($_POST['uname']);
    $pass = validated($_POST['password']);
    $roles_as = validated($_POST['roles_as']);
    $image = validated($_FILES['image']['name']);
    $is_ban = validated($_POST['is_ban']) == true ? 1 : 0;



    if (empty($name)) {
        direct('insert_admin.php', "firstname can't be blank");
    } else if (empty($lname)) {
        direct('insert_admin.php', "lastname can't be blank");
    } else if (empty($uname)) {
        direct('insert_admin.php', "Username can't be blank");
    } else if (empty($pass)) {
        direct('insert_admin.php', "Password can't be blank");
    } else if (empty($roles_as)) {
        direct('insert_admin.php', "select role can't be blank");
    } else if (empty($image)) {
        direct('insert_admin.phpp', "image can't be blank");
    } else if (file_exists("Uploads/" . $_FILES["image"]["name"])) {
        $store = $_FILES["image"]["name"];

        redirect('insert_admin.php', "Image already exists. '.$store.'");
    } else
        $pass = md5($pass);
    $sql = "SELECT * FROM user_form where uname ='$uname'";
    $sql_run = mysqli_query($conn, $sql);
    if (mysqli_num_rows($sql_run) > 0) {
        redirect('insert_admin.php', "admin/user is already taken try another");
    } else {

        $query = "INSERT INTO user_form( fname, lname , phone ,branch_id,uname , password, roles_as ,image,is_ban)VALUES('$name','$lname','$phone','$branch_id','$uname','$pass','$roles_as','$image','$is_ban')";

        $sql_run = mysqli_query($conn, $query);
        if ($sql_run) {
            move_uploaded_file($_FILES["image"]["tmp_name"], "Uploads/" . $_FILES["image"]["name"]);
            redirect('insert_admin.php', "admin/user Addedd successfully");
        } else {
            redirect("admin.php", '');
        }
    }
}




if (isset($_POST['update_data'])) {

    $name = validated($_POST['fname']);
    $lname = validated($_POST['lname']);
    $uname = validated($_POST['uname']);
    $phone = validated($_POST['phone']);
    $branch = validated($_POST['branch_id']);
    $pass = validated($_POST['password']);
    $roles_as = validated($_POST['roles_as']);
    $dated = validated($_POST['dated']);
    $is_ban = validated($_POST['is_ban']) == 'banned' ? 1 : 0;
    $new_image = $_FILES['image']['name'];
    $old_image = validated($_POST['image_old']);

    if ($new_image != '') {
        $update_filename = $new_image;
        if (file_exists("Uploads/" . $_FILES["image"]["name"])) {
            $store = $_FILES["image"]["name"];
            redirect('admin.php', "Image already exists. '.$store.'");
        }
    } else {
        $update_filename = $old_image;
    }

    $user_id = validated($_POST['user_id']);
    $user = getById('user_form', $user_id);

    if ($user['status'] != 200) {
        redirect('edit_admin.php?id=' . $user_id, 'No such id found');
    }

    if ($name != '' || $lname != '' || $pass != '' || $roles_as != '' || $dated != '') {
        $query = "UPDATE user_form SET 
            fname = '$name',
            lname = '$lname',
            uname = '$uname',
            phone = '$phone',
            branch_id = '$branch',
            password = '$pass',
            roles_as = '$roles_as',
            image = '$update_filename',
            is_ban = '$is_ban',
            created = '$dated'
            WHERE id = '$user_id'
        ";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if ($_FILES['image']['name']) {
                move_uploaded_file($_FILES["image"]["tmp_name"], "Uploads/" . $_FILES["image"]["name"]);
                unlink("Uploads/" . $old_image);
            }

            if ($_SESSION['auth_user']['user_id'] == $user_id && $is_ban == 1) {
                // Log out the user and redirect to login page
                $_SESSION['status'] = "Your account has been banned. Please contact the administrator.";
                unset($_SESSION['auth']);
                unset($_SESSION['auth_role']);
                unset($_SESSION['auth_user']);
                header('Location: login.php');
                exit(0);
            }

            redirect('admin.php', 'Update admin/user successfully');
        } else {
            redirect('edit_admin.php', 'Something went wrong');
        }
    } else {
        redirect('edit_admin.php', 'Please fill out the data');
    }
}


