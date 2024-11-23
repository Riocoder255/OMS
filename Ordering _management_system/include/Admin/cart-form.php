<?php
session_start();
require './admin_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $size_id = mysqli_real_escape_string($conn, $_POST['size_id']);
    $color_id = mysqli_real_escape_string($conn, $_POST['color_id']);

    
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session upon login

    // Initialize the cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Create a unique key for the cart item based on product_id, size_id, and color_id
    $cart_item_key = $product_id . '_' . $size_id . '-' . $color_id;
    if (isset($_SESSION['cart'][$cart_item_key])) {
        // Update the quantity if the product is already in the cart
        $_SESSION['cart'][$cart_item_key]['quantity'] += $quantity;
        
        // Update the item in the database
        $new_quantity = $_SESSION['cart'][$cart_item_key]['quantity'];
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ? AND size_id = ? AND color_id = ?");
        $stmt->bind_param('iiiii', $new_quantity, $user_id, $product_id, $size_id, $color_id);
    } else {
        // Insert a new item into the cart
        $_SESSION['cart'][$cart_item_key] = [
            'product_id' => $product_id,
            'size_id' => $size_id,
            'color_id' => $color_id,
            'quantity' => $quantity
        ];
        
        // Insert the item into the database
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, size_id, color_id, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('iiiii', $user_id, $product_id, $size_id, $color_id, $quantity);
    }

    $stmt->execute();
    $stmt->close();

    // Redirect to cart page or wherever you want
    $_SESSION['status'] = "Add to cart is Successfully";
    header("Location: find-semelar.php?product_id=$product_id");
}
?>
