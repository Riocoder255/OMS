<?php
include('./admin_connect.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $item = $_POST['item'];
    $size = $_POST['size'];
    $qty = $_POST['qty'];
    $category = $_POST['category'];
    $customer_name = $_POST['customer_name'];
    $user = $_POST['user_id'];

    // Optionally handle the signature (base64 image)
    if (isset($_POST['signature'])) {
        $signature = $_POST['signature']; // Base64 signature
    } else {
        $signature = null;
    }

    // Insert the receive log into the database
    $query = "INSERT INTO receive_logs (item, size, qty, category, customer_name, user_id, signature) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);

// Update the bind_param type definition string to 'ssissis' (7 parameters)
$stmt->bind_param("ssissis", $item, $size, $qty, $category, $customer_name, $user, $signature);
$stmt->execute();

if ($stmt->affected_rows > 0) {
echo "Receive log successfully recorded.";
} else {
echo "Error recording the receive log.";
}
}
?>
