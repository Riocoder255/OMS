<?php
require_once "./admin_connect.php";

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    $query = "SELECT  DISTINCT 
    io.product_name, 
    io.quantity, 
    io.size, 
    io.category, 
    io.total_price, 
    io.image AS product_image
  FROM 
    items_orders AS io
  WHERE 
    io.order_id = $order_id";


    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = [
                'product_name' => $row['product_name'],
                'quantity' => $row['quantity'],
                'size' => $row['size'],
                'category' => $row['category'],
                'total_price' => $row['total_price'],
                'image' => $row['product_image'] ?? 'default.jpg', // Default image if not set
            ];
        }

        echo json_encode(['success' => true, 'items' => $items]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No items found for this order.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Order ID is missing.']);
}
