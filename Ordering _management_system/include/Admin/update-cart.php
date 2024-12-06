<?php
include("./admin_connect.php");
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the action is to increment or decrement
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    list($operation, $cart_id) = explode('_', $action); // Split 'increment_1' or 'decrement_1'
    $cart_id = (int)$cart_id; // Ensure it's an integer

    // Fetch the current quantity and price of the item
    $query = "SELECT quantity, price FROM cart WHERE id = $cart_id AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $quantity = $row['quantity'];
        $price = $row['price'];

        // Increment or decrement quantity
        if ($operation == 'increment') {
            $new_quantity = $quantity + 1;
        } elseif ($operation == 'decrement' && $quantity > 1) {
            $new_quantity = $quantity - 1;
        } else {
            // If quantity is already 1, don't decrement further
            $new_quantity = $quantity;
        }

        // Update the cart with the new quantity and recalculate total price
        $new_total_price = $new_quantity * $price;
        $update_query = "UPDATE cart SET quantity = $new_quantity, total_price = $new_total_price WHERE id = $cart_id AND user_id = '$user_id'";
        if (mysqli_query($conn, $update_query)) {
            // Redirect back to the cart page
            header('Location: cart_view.php');
            exit;
        } else {
            echo "Error updating cart.";
        }
    } else {
        echo "Item not found in your cart.";
    }
} else {
    echo "No action specified.";
}
?>
