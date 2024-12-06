<?php
session_start();
require './admin_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize inputs
    $product_id = intval($_POST['product_id']); // Ensure product ID is an integer
    $size = isset($_POST['Size']) ? trim($_POST['Size']) : null; // Get size from radio button
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Get quantity
    $productsize_id = isset($_POST['productsize_id']) ? htmlspecialchars($_POST['productsize_id']) : null; // Get selected image
    $action = $_POST['action']; // Action (add to cart or buy now)

    // Validation
    if (empty($size)) {
        echo'<script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>';
        echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>';
        echo' <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">';
      echo '<script type="text/javascript">
      Swal.fire({
         
          text: "Opps error please select  image and size.",
          icon: "error",
          confirmButtonText: "OK"
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = "find-semelar.php?product_id=' . $product_id . '"; // Redirect to cart
          }
      });
      </script>';
    }
    if (empty($productsize_id)) {
        echo'<script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>';
        echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>';
        echo' <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">';
      echo '<script type="text/javascript">
      Swal.fire({
         
          text: "Opps error please select  image and size.",
          icon: "error",
          confirmButtonText: "OK"
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = "find-semelar.php?product_id=' . $product_id . '"; // Redirect to cart
          }
      });
      </script>';
    }

    // Fetch the product price from the database based on product ID
    $qry = mysqli_query($conn, "SELECT price FROM pricing WHERE id ");
    if ($qry && $row = mysqli_fetch_assoc($qry)) {
        $price = $row['price']; // Get the price
    } else {
        die("Error fetching product price.");
    }

    // Calculate total price
    $total_price = $price * $quantity;

    // Use prepared statement to insert data into the cart table
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, 	cartsize, quantity, price, image_path) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Bind parameters (user_id, product_id, size, quantity, total_price, productsize_id)
    $stmt->bind_param("iisids", $user_id, $product_id, $size, $quantity, $total_price, $productsize_id);

    // Execute the query
    if ($stmt->execute()) {
        if ($action === 'buy_now') {
            header("Location: checkout.php"); // Redirect to checkout if 'buy now' is selected
            exit;
        } else {
            echo'<script src="https://code.jquery.com/jquery-1.7.1.min.js"></script>';
        echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>';
        echo' <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">';
          echo '<script type="text/javascript">
          Swal.fire({
              title: "Added to Cart!",
              text: "Your item has been successfully added to the cart.",
              icon: "success",
              confirmButtonText: "OK"
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = "find-semelar.php?product_id=' . $product_id . '"; // Redirect to cart
              }
          });
          </script>';
        }
    } else {
        echo "Error: " . $stmt->error; // Display error if query fails
    }

    // Close the statement
    $stmt->close();
}
?>
