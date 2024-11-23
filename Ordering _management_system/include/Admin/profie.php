<?php 
include('./layouts/header.php');
include('./layouts/sidebar.php');
include('./layouts/topbar.php');

// Fetch sizes
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testbl";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query = "SELECT * FROM sizing";
$query_run = mysqli_query($conn, $query);

$sizes = [];
if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_array($query_run)) {
        $sizes[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mysqli Multiple Select option using Bootstrap Select Plugin and Jquery Ajax</title>
    <!-- Bootstrap 5 CSS -->
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
</head>
<body>
    <br /><br />
    <div class="container">
        <br />
        <h2 align="center">PHP Mysqli Multiple Select option using Bootstrap Select Plugin and Jquery Ajax</h2>
        <br />
        <div class="col-md-4" style="margin-left:200px;">
            <form method="post" action="insert.php" id="multiple_select_form">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>
                <div class="mb-3">
                    <label for="product_price" class="form-label">Product Price</label>
                    <input type="number" class="form-control" id="product_price" name="product_price" required>
                </div>
                <div class="mb-3">
                    <label for="sizes" class="form-label">Sizes</label>
                    <select name="sizes[]" id="sizes" class="form-control selectpicker" data-live-search="true" multiple required>
                        <?php
                        // Fetch sizes from database and populate options
                        $query = "SELECT * FROM sizing";
                        $query_run = mysqli_query($conn, $query);
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_array($query_run)) {
                                echo "<option value='{$row['id']}'>{$row['Size']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" name="submit" class="btn btn-info" value="Submit" />
            </form>
            <br />
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.selectpicker').selectpicker();
        });
    </script>
</body>
</html>

<?php 
include('./layouts/footer.php');
include('./layouts/scripts.php');
?>
