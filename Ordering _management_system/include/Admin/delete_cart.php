
// Replace with your database connection file
<?
if (!isset($_SESSION['user_id'])) {
    die("Please log in to continue.");
}

// Get the cart ID from the URL
if (isset($_GET['id'])) {
    $cart_id = intval($_GET['id']); // Sanitize input

    // Prepare the SQL query to delete the item from the cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $_SESSION['user_id']); // Bind parameters

    if ($stmt->execute()) {
        // Redirect back to the cart page with a success message
        echo '<script type="text/javascript">
            Swal.fire({
                title: "Deleted!",
                text: "The item has been removed from your cart.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "cart_page.php"; // Replace with your cart page URL
            });
        </script>';
    } else {
        echo "Error deleting item: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
?>