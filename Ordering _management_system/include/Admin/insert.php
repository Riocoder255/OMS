<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testbl";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["product_name"]) && isset($_POST["sizes"]) && isset($_POST["product_price"])) {
    $product_name = mysqli_real_escape_string($conn, $_POST["product_name"]);
    $sizes = $_POST["sizes"];
    $price = mysqli_real_escape_string($conn, $_POST["product_price"]);

    // Debugging: Output received data
    echo "Received data: ";
    var_dump($_POST);

    // Insert product
    $query = "INSERT INTO products (product_name, product_price) VALUES ('$product_name', '$price')";
    if (mysqli_query($conn, $query)) {
        $product_id = mysqli_insert_id($conn);

        // Insert each size
        foreach ($sizes as $size_id) {
            $query = "INSERT INTO product_size (product_id, size_id) VALUES ('$product_id', '$size_id')";
            mysqli_query($conn, $query);
        }

        echo "Product and sizes inserted successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Product name, price, or sizes not set.";
}

mysqli_close($conn);
?>
