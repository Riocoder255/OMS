<?php

include("./admin_connect.php"); // Assuming you need it for product details
include ('./layouts-c/header-c.php');
include ('./layouts-c/navbar-c.php');

$totalAmount = 0;
$cart_items = [];

// Fetch product details for items in the cart
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
        $product_id = $item['product_id'];
        $size_id = $item['size_id'];
        $color_id = $item['color_id']; // Make sure color_id is set in the cart session
        $quantity = $item['quantity'];

        $product_query = $conn->query("
            SELECT 
                p.product_name, 
                p.price, 
                p.cover, 
                s.Size,
                ps.images AS product_image
            FROM 
                product_price p 
            JOIN 
                sizing s ON s.id = $size_id
            JOIN 
                product_size ps ON ps.product_id = p.product_id AND ps.size_id = s.id
            WHERE 
                p.product_id = $product_id
        ");

        if ($product_row = $product_query->fetch_assoc()) {
            $quantity = (int)$quantity; // Cast quantity to an integer
            $price = (float)$product_row['price']; // Cast price to a float
            
            $product_row['quantity'] = $quantity;
            $product_row['total_price'] = $price * $quantity; // Perform multiplication with numeric types
            $product_row['cart_key'] = $key;
            $product_row['color_id'] = $color_id; // Add color_id to the product row
            $cart_items[] = $product_row;
            $totalAmount += $product_row['total_price'];
        }
    }
}

$color_names = [];
$color_query = mysqli_query($conn, "SELECT id, color_name FROM colors");
while ($row = mysqli_fetch_assoc($color_query)) {
    $color_names[$row['id']] = $row['color_name'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script>
        function updateTotal() {
            let total = 0;
            let checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.dataset.price) * parseInt(checkbox.dataset.quantity);
                }
            });
            document.getElementById('totalAmount').innerText = 'Total Amount: P ' + total.toFixed(2);
            document.getElementById('total_amount').value = total.toFixed(2);
        }

        function selectAllProducts(source) {
            let checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = source.checked;
            });
            updateTotal();
        }

        function handlePaymentOption() {
            const fullPaymentRadio = document.getElementById('full_payment');
            const downPaymentRadio = document.getElementById('down_payment_option');
            const downPaymentInput = document.getElementById('down_payment_input');
            const totalAmount = parseFloat(document.getElementById('total_amount').value);

            if (fullPaymentRadio.checked) {
                downPaymentInput.value = totalAmount.toFixed(2);
                downPaymentInput.disabled = true;
            } else if (downPaymentRadio.checked) {
                downPaymentInput.value = '';
                downPaymentInput.disabled = false;
            }
        }
    </script>
</head>
<body>
<?php if (!empty($cart_items)): ?>
    <div class="container" style="margin-top:100px;">
        <div class="row justify-content-center">
            <div class="col-md-14">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-2 weight-bold text-primary" style="font-size: 30px;text-align:center">Your Cart</h6>
                        <br>
                    </div>
                    <div class="card-body">
                        <div class="c">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <tr>
                                    <th><input type="checkbox" style="width: 50px; height:20px" onclick="selectAllProducts(this)"></th>
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Size</th>
                                    <th>Color</th> <!-- Changed to Color -->
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td><input type="checkbox" class="product-checkbox" data-price="<?php echo $item['price']; ?>" data-quantity="<?php echo $item['quantity']; ?>" style="width: 50px; height:20px" onclick="updateTotal()"></td>
                                        <td><a href="find-semelar.php" class="text-decoration-none text-dark"><?php echo htmlspecialchars($item['product_name']); ?></a></td>
                                        <td><img src="design_upload/<?php echo htmlspecialchars($item['product_image']); ?>" width="50"></td>
                                        <td><?php echo htmlspecialchars($item['Size']); ?></td>
                                        <td><?php echo htmlspecialchars($color_names[$item['color_id']]); ?></td> <!-- Updated to use color_id from item -->
                                        <td>P<?php echo htmlspecialchars($item['price']); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td>P<?php echo htmlspecialchars($item['total_price']); ?></td>
                                        <td>
                                            <form method="POST" action="update-cart.php">
                                                <input type="hidden" name="cart_key" value="<?php echo htmlspecialchars($item['cart_key']); ?>">
                                                <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" class="form-control w-50">
                                                <button type="submit" class="btn btn-outline-success btn-sm"><i class="fas fa-edit"></i></button>
                                            </form>
                                            <form method="POST" action="delete_cart.php">
                                                <input type="hidden" name="cart_key" value="<?php echo htmlspecialchars($item['cart_key']); ?>">
                                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="text-success" id="totalAmount">Total Amount: P <?php echo number_format($totalAmount, 2); ?></td>
                                    <td></td>
                                </tr>
                            </table>
                            <form action="./chec-out.php" method="post">
                                <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $totalAmount; ?>">

                                <label for="full_payment">
                                    <input type="radio" name="payment_option" id="full_payment" value="full" onclick="handlePaymentOption()" required>
                                    Full Payment
                                </label>
                                <label for="down_payment_option">
                                    <input type="radio" name="payment_option" id="down_payment_option" value="down" onclick="handlePaymentOption()">
                                    Down Payment
                                </label>

                                <br>
                                <label for="down_payment_input">Down Payment Amount:</label>
                                <input type="number" name="down_payment" id="down_payment_input" step="0.01" min="0" max="<?php echo $totalAmount; ?>" required disabled>

                                <br>
                                
                                <br><br>
                                <button type="submit" class="btn btn-outline-dark btn-sm">Pick up orders</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <p class="text-center text-danger m-5 text-bold" style="font-size: 30px;">Your cart is empty.</p>
    <a href="./home-client.php" class="btn btn-primary btn-sm" style="margin-left: 550px;">Back to Orders</a>
<?php endif; ?>
</body>
</html>
