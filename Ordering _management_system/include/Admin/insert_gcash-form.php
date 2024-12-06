<?php
require './layouts-c/header-c.php';
require './layouts-c/navbar-c.php';
require_once "./admin_connect.php";
require_once "./function-c.php";

if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}
$user_id = $_SESSION['user_id'];

$query = "SELECT SUM(total_amount) AS total_amount FROM orders";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalAmount = $row['total_amount'];

} else {
    $totalAmount = 0; // If no result or error, set to 0
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Amount</title>
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 5% auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>


<?php 


if (isset($_POST['submit'])) {
    // Get the form data
    $ref_number = mysqli_real_escape_string($conn, $_POST['ref_number']);
    $file = $_FILES['receipt'];

    // Handle file upload
    $uploadDir = "Uploads/";  // Directory where files will be uploaded
    $uploadFile = $uploadDir . basename($file['name']);
    $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Check if the file is a valid image
    if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        // Move the uploaded file to the server
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // Prepare the SQL query to insert the data into the database
            $sql = "INSERT INTO receipts (ref_number, receipt_image) VALUES ('$ref_number', '$uploadFile')";
            
            // Execute the query
            if (mysqli_query($conn, $sql)) {
                // Success: Show SweetAlert message
                echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Receipt has been uploaded successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'orders_history.php'; // Redirect to another page
                            }
                        });
                      </script>";
            } else {
                // Database insert failed: Show error SweetAlert
                echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error uploading the receipt.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                      </script>";
            }
        } else {
            // File upload failed: Show error SweetAlert
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue with the file upload.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
    } else {
        // Invalid file type: Show error SweetAlert
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Only image files are allowed (JPG, PNG, GIF).',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}

?>
</head>
<body> 
     <h2 class="text-primary" style="margin-top:5%;">G-CASH FORM</h2>
    <div class="container">
        <h2 class="text-danger">Total Amount: <span class="total-amount"><?php echo number_format($totalAmount, 2); ?></span></h2>
  

        <!-- Form for Reference Number and Receipt Upload -->
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="ref_number">Reference Number</label>
                <input type="text" id="ref_number" name="ref_number" >
            </div>

            <div class="form-group">
                <label for="receipt">Upload Receipt</label>
                <input type="file" id="receipt" name="receipt" accept="image/*">
            </div>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>

<?php
include("./layouts/footer.php");
include("./layouts/scripts.php");
?>
