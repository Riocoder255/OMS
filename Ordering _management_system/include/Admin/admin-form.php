<?php
include_once "./admin_connect.php";
include_once "./function.php";

if (isset($_POST['save_data'])) {
    $name = validated($_POST['fname']);
    $lname = validated($_POST['lname']);
    $phone = validated($_POST['phone']);
    $branch_id = validated($_POST['branch_id']);
    $uname = validated($_POST['uname']);
    $pass = validated($_POST['password']);
    $roles_as = validated($_POST['roles_as']);
    $image = $_FILES['image']['name'];
    $is_ban = isset($_POST['is_ban']) && $_POST['is_ban'] == "true" ? 1 : 0;

    // Validate input fields
    if (empty($name)) {
        redirect('insert_admin.php', "First name can't be blank");
    } else if (empty($lname)) {
        redirect('insert_admin.php', "Last name can't be blank");
    } else if (empty($uname)) {
        redirect('insert_admin.php', "Username can't be blank");
    } else if (empty($pass)) {
        redirect('insert_admin.php', "Password can't be blank");
    } else if (empty($roles_as)) {
        redirect('insert_admin.php', "Select role can't be blank");
    } else if (empty($image)) {
        redirect('insert_admin.php', "Image can't be blank");
    } else if (file_exists("Uploads/" . $image)) {
        redirect('insert_admin.php', "Image already exists: $image");
    }

    // Hash password
    $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

    // Check if username/email already exists
    $sql = "SELECT * FROM user_form WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        redirect('insert_admin.php', "Admin/user is already taken. Try another.");
    } else {
        // Insert user into the database
        $query = "INSERT INTO user_form (fname, lname, phone, branch_id, email, password, roles_as, image, is_ban) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssssi", $name, $lname, $phone, $branch_id, $uname, $hashed_password, $roles_as, $image, $is_ban);

        if ($stmt->execute()) {
            // Move uploaded file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], "Uploads/" . $image)) {
                redirect('insert_admin.php', "Admin/user added successfully.");
            } else {
                redirect('insert_admin.php', "Failed to upload image.");
            }
        } else {
            redirect('insert_admin.php', "Database error. Please try again.");
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
            email = '$uname',
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

?>


