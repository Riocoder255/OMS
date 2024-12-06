<?php
session_start();
include("./admin_connect.php");

if (isset($_POST['email']) && isset($_POST['pass'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['pass']);

    if (empty($email)) {
        header("Location: sign-in.php?error=Email address is required");
        exit();
    } else if (empty($pass)) {
        header("Location: sign-in.php?error=Password is required");
        exit();
    } else {
        $pass = md5($pass);
        $sql = "SELECT * FROM customer WHERE email='$email' AND password='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $email && $row['password'] === $pass) {
                $_SESSION['auth_customer'] = true;
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['stat'] = "Login is successful";

                $stmt = $conn->prepare("SELECT* FROM  orders WHERE user_id = ?");
                $stmt->bind_param('i', $row['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                // Retrieve cart data from the database
                $stmt = $conn->prepare("SELECT product_id, cartsize,  quantity FROM cart WHERE user_id = ?");
                $stmt->bind_param('i', $row['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                $_SESSION['cart'] = [];
                while ($cart_row = $result->fetch_assoc()) {
                    $cart_item_key = $cart_row['product_id'] . '_' . $cart_row['cartsize'] ;
                    $_SESSION['cart'][$cart_item_key] = [
                        'product_id' => $cart_row['product_id'],
                        'cartsize' => $cart_row['cartsize'],
                      
                        'quantity' => $cart_row['quantity']
                    ];  
                }

                header("Location: home-client.php");
                exit();
            } else {
                header("Location: sign-in.php?error=Incorrect Email or Password");
                exit();
            }
        } else {
            header("Location: sign-in.php?error=Incorrect Email or Password");
            exit();
        }
    }
} else {
    header("Location: sign-in.php");
}
?>

