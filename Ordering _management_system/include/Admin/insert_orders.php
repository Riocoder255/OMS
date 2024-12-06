<?php
session_start();
include './admin_connect.php';
if (!isset($_SESSION['user_id'])) {
    die('User not logged in');
}

$user_id = $_SESSION['user_id'];

// Retrieve POST data
$data = json_decode(file_get_contents('php://input'), true);
$branch = isset($_POST['branch']) ? intval($_POST['branch']) : null;
$paymentType = $_POST['payment_type'] ?? null;
$paymentMethod = $_POST['payment_method'] ?? null;
$cart_items = json_decode($_POST['cart_items'], true);
$finalAmount = isset($_POST['final_amount']) ? floatval($_POST['final_amount']) : 0.0;
$remainingBalance = isset($_POST['remaining_balance']) ? floatval($_POST['remaining_balance']) : 0.0;
$totalQty = count($cart_items);
$status = $_POST['status'] ?? '';
$orderApproval = 'processing'; // Default value for order approval

// Validate inputs
if (empty($branch)) {
    echo json_encode(['success' => false, 'message' => 'Branch is required.']);
    exit;
}

if (empty($cart_items)) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
    exit;
}

// Calculate remaining balance
if ($paymentType === 'Downpayment') {
    $remainingBalance = $finalAmount; // Full amount remains unpaid
}

// Determine the order_date_finished value
$orderDateFinished = ($status === 'Paid') ? date('Y-m-d H:i:s') : '';

// Insert into `orders` table
$query = "INSERT INTO orders (user_id, branch_id, payment_type, payment_method, total_amount,payment_status, remaining_balance, total_item, order_date_finished, order_approval) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$status = ($paymentType === 'Downpayment') ? 'Inprogress ' : 'finish';
$stmt->bind_param('iissdsdiss', $user_id, $branch, $paymentType, $paymentMethod, $finalAmount, $status, $remainingBalance, $totalQty, $orderDateFinished, $orderApproval);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to insert order.']);
    exit;
}

$orderId = $stmt->insert_id; // Get the newly created order ID

// Insert order items
foreach ($cart_items as $item) {
    $product_id = $item['product_name'];
    $cart_id = isset($item['cart_id']) ? intval($item['cart_id']) : 0;
    $category = isset($item['category']) ? $item['category'] : '';
    $size = isset($item['size']) ? $item['size'] : '';
    $quantity = isset($item['quantity']) ? intval(preg_replace('/[^0-9]/', '', $item['quantity'])) : 0;

    if ($quantity <= 0) {
        echo "Invalid quantity for product: {$item['product_name']}";
        exit;
    }

    $price = isset($item['total_price']) ? floatval($item['total_price']) : 0.0;
    $image = isset($item['image_path']) ? $item['image_path'] : '';

    // Insert the order items into the order_items table
    $order_item_query = "INSERT INTO items_orders (order_id, product_name, cart_id, category, size, quantity, total_price, image) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $order_item_stmt = $conn->prepare($order_item_query);
    $order_item_stmt->bind_param('isissdis', $orderId, $product_id, $cart_id, $category, $size, $quantity, $price, $image);
    $order_item_stmt->execute();
}

// Clear cart after successful insertion
if (!empty($cart_items)) {
    $selectedCartIds = array_column($cart_items, 'cart_id');
    $placeholders = implode(',', array_fill(0, count($selectedCartIds), '?'));
    $deleteCartQuery = "DELETE FROM cart WHERE id IN ($placeholders)";
    $deleteStmt = $conn->prepare($deleteCartQuery);
    $deleteStmt->bind_param(str_repeat('i', count($selectedCartIds)), ...$selectedCartIds);

    if ($deleteStmt->execute()) {
        header('');

        if ($paymentMethod === 'GCash') {
            // Step 1: PayMongo secret key//
        header('Location: insert_gcash-form.php');
        
            
        } else if ($paymentMethod === 'Over the Counter') {
            header("Location: orders_history.php?order_id=$order_id");
        
        exit(0);
        } 
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to clear cart.']);
    }
}
?>
