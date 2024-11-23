<?php

require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';

require_once "admin_connect.php";


?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $freebie = $_POST["freebie"];

    // Validate inputs (make sure required fields are not empty)
    if (empty($category) || empty($quantity) || empty($price)) {
        echo "<script>alert('Please fill out all required fields.');</script>";
        exit;
    }

    // Check if we're updating or adding a new record
    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        // Update existing record
        $id = $_POST["id"];

        $stmt = $conn->prepare("UPDATE pricing SET category_id = ?, quantity = ?, price = ?, freebie = ? WHERE id = ?");
        $stmt->bind_param("sssss", $category, $quantity, $price, $freebie, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Record updated successfully');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO pricing (category_id, quantity, price, freebie) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $category, $quantity, $price, $freebie);

        if ($stmt->execute()) {
            echo "<script>alert('New record added successfully');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}





// Fetch data from database


?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                <?= alertmessage();?>
                    <h4> Pricing List
                       
                </div>
                <div class="card-body">
                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Table</title>
    <style>
     

        .container {
            display: flex;
            justify-content: space-between;
            width: 90%;
            margin: 20px 0;
        }

        .form-section {
            width: 48%;
        }

        .form-section select,
        .form-section input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-row input {
            width: 30%;
            text-align: center;
        }

        .add-btn {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .add-btn button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-btn button:hover {
            background-color: #0056b3;
        }

        .table-section {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
            text-align: center;
        }

        th, td {
            padding: 10px;
        }
    </style>
</head>
<body>
   
    <div class="container">
        <!-- Form Section -->
        <div class="form-section">
        <form method="POST" action="">

<label for="category">Category</label>
<select id="category" name="category">
    <?php
    // Fetch categories
    $query = "SELECT * FROM Sub_category";
    $query_run = mysqli_query($conn, $query);
    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_array($query_run)) {
            echo "<option value='{$row['id']}'>{$row['cat_name']}</option>";
        }
    }
    ?>
</select>

<!-- Input Rows -->
<div class="form-row">
    <input type="hidden" name="id" value="<?php echo isset($existing_id) ? $existing_id : ''; ?>">
    <input type="text" name="quantity" id="quantity" placeholder="Quantity (e.g., 1-4)" required>
    <input type="text" name="price" id="price" placeholder="Price (e.g., 800)" required>
    <input type="text" name="freebie" id="freebie" placeholder="Freebie">
</div>

<!-- Add/Update Button -->
<div class="add-btn">
    <button type="submit" name="submit" id="submit">Add</button>
</div>

</form>


        </div>

        <!-- Table Section -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Quantity (PCS)</th>
                        <th>Price</th>
                        <th>Freebie</th>
                    </tr>
                </thead>
                <tbody>
           
<?php
        // Fetch items from the database
        $query = "SELECT p.*, c.cat_name 
        FROM pricing p 
        LEFT JOIN sub_category c ON p.category_id = c.id";// Replace with your actual table name
        $query_run = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($query_run)) {
            echo "<tr class='editRow' data-id='{$row['id']}'>
                    <td>{$row['cat_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['freebie']}</td>
                    <td><button class='edit-btn'>Edit</button></td>
                    <td><button class='delete-btn' data-id='{$row['id']}'>Delete</button></td>
                </tr>";
        }
        ?>

               
                           
                    </tbody>
            </table>
        </div>
    </div>
    

    <script>
        // Handle Edit Button Click
        document.addEventListener('DOMContentLoaded', function() {
    // Handle Edit Button Click
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            const category = row.cells[0].textContent;
            const quantity = row.cells[1].textContent;
            const price = row.cells[2].textContent;
            const freebie = row.cells[3].textContent;

            // Set the form fields with the data
            document.querySelector('input[name="id"]').value = id;
            document.querySelector('select[name="category"]').value = category;
            document.querySelector('input[name="quantity"]').value = quantity;
            document.querySelector('input[name="price"]').value = price;
            document.querySelector('input[name="freebie"]').value = freebie;
        });
    });

    // Handle Delete Button Click
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const confirmation = confirm('Are you sure you want to delete this record?');
            if (confirmation) {
                window.location.href = 'delete.php?id=' + id;  // Redirect to delete page
            }
        });
    });
});


    </script>



</body>
</html>

</div>
<script  src="https://code.jquery.com/jquery-3.6.0.js"></script>

    
<?php

include("./layouts/footer.php");

include("./layouts/scripts.php");

?>