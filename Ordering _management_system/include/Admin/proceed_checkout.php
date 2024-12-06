<?php
include("./admin_connect.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $selected_items = $_POST['selected_items'] ?? []; // Ensure selected_items exists
    $total_amount = $_POST['total_amount'] ?? 0;

    if (empty($selected_items)) {
        echo "<script>alert('No items selected for checkout.'); window.history.back();</script>";
        exit;
    }

    // Start database transaction
    $conn->begin_transaction();

    try {
        // Insert order into `orders` table
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, total_amount, orders_created)
            VALUES (?, ?, NOW())
        ");
        $stmt->bind_param("id", $user_id, $total_amount);
        $stmt->execute();
        $order_id = $conn->insert_id;

        // Prepare statement for inserting order items
        $item_stmt = $conn->prepare("
            INSERT INTO  items_orders (order_id, product_id, quantity,  total_price)
            VALUES (?, ?, ?,  ?)
        ");

        foreach ($selected_items as $cart_id) {
            $cart_id = intval($cart_id); // Sanitize input

            // Fetch cart details
            $qry = $conn->query("
                SELECT product_id, quantity, price, (quantity * price) AS total_price
                FROM cart
                WHERE id = $cart_id AND user_id = $user_id
            ");

            if ($row = $qry->fetch_assoc()) {
                $product_id = $row['product_id'];
                $quantity = $row['quantity'];
              
                $total_price = $row['total_price'];

                // Debugging: Check fetched data
                if (is_null($total_price)) {
                    throw new Exception("Error: total_price is null for cart_id $cart_id");
                }

                // Bind and execute item insertion
                $item_stmt->bind_param("iiidd", $order_id, $product_id, $quantity,  $total_price);
                $item_stmt->execute();
            } else {
                throw new Exception("Cart item with id $cart_id not found or does not belong to user.");
            }

            // Optionally, remove item from cart
            $conn->query("DELETE FROM cart WHERE id = $cart_id");
        }

        // Commit transaction
        $conn->commit();

        // Redirect to payment
        header("Location: payment_form.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        die("Error saving order: " . $e->getMessage());
    }
}
?>
