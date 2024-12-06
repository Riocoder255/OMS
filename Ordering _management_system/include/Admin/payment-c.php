<?php
include './layouts-c/header-c.php';
include './layouts-c/navbar-c.php';
include './admin_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_items = isset($_POST['cart_items']) ? json_decode($_POST['cart_items'], true) : [];
    $cart_total = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0.0;
    $cart_qty = count($cart_items); // Count the number of items
} else {
    $cart_items = [];
    $cart_total = 0.0;
    $cart_qty = 0;
    header('Location: cart_view.php'); 
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .box {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin: 50px auto;
        padding: 20px;
        flex-wrap: wrap;
    }

    .table-container {
        flex: 1;
        min-width: 300px;
        max-width: 500px;
        overflow-x: auto;
    }

    .form-container {
        flex: 1;
        max-width: 400px;
        background-color: #ffffff;
        padding: 10px;
        margin-top: -3%;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .btn-primary {
        width: 100%;
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    @media screen and (max-width: 768px) {
        .box {
            flex-direction: column;
        }
    }
</style>

<body>
    <div class="box">
        <div class="table-container">
            <table class="table table-bordered border-primary">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= htmlspecialchars($item['category']) ?></td>
                            <td><?= htmlspecialchars($item['size']) ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td><img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" width="50"></td>
                            <td><?= htmlspecialchars($item['total_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="form-container">
            <h2 class="form-title">Payment Form</h2>
            <form action="./insert_orders.php" method="POST" id="paymentForm">
                <input type="hidden" name="cart_items" value='<?= htmlspecialchars(json_encode($cart_items)) ?>'>
                <input type="hidden" name="total_amount" value="<?= $cart_total ?>">

                <div class="form-group">
                    <label><strong>Total Items:</strong> <?= $cart_qty; ?></label><br>
                    <label><strong>Cart Total:</strong> ₱<?= number_format($cart_total, 2); ?></label>
                    <input type="hidden" id="cart_total" value="<?= $cart_total; ?>">
                </div>

                <div class="form-group">
                    <label for="branch" class="form-label"><strong>Select Branch</strong></label>
                    <select name="branch" id="branch" class="form-select" required>
                        <option value="">------Select Branch------</option>
                        <?php
                        $query = "SELECT * FROM branch";
                        $query_run = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($query_run)) {
                            echo "<option value='{$row['id']}'>{$row['Branch_name']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><strong>Payment Type:</strong></label><br>
                    <label><input type="radio" name="payment_type" value="Downpayment" id="downpaymentRadio" required> Downpayment (50%)</label><br>
                    <label><input type="radio" name="payment_type" value="Fullcashpayment" required> Full Payment</label>
                </div>  

                <div class="form-group">
                    <label><strong>Payment Method:</strong></label><br>
                    <label><input type="radio" name="payment_method" value="GCash" required> GCash</label><br>
                    <label><input type="radio" name="payment_method" value="Over the Counter" required> Over the Counter</label>
                </div>

                <div class="form-group">
                    <label><strong>Final Amount:</strong></label>
                    <input type="text" id="final_amount_display" class="form-control" readonly>
                    <input type="hidden" id="final_amount" name="final_amount">
                </div>

                <div class="form-group">
                    <label><strong>Remaining Balance:</strong></label>
                    <input type="text" id="remaining_balance" class="form-control" readonly name="remaining_balance">
                </div>

                <button type="submit" class="btn btn-primary" id="proceedPaymentBtn">Proceed to Payment</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartTotal = parseFloat(document.getElementById('cart_total').value);
            const cartQty = <?= $cart_qty; ?>;
            const downpaymentRadio = document.getElementById('downpaymentRadio');

            downpaymentRadio.disabled = cartQty < 4;

            document.getElementById('final_amount_display').value = '₱' + cartTotal.toFixed(2);
            document.getElementById('final_amount').value = cartTotal.toFixed(2);
            document.getElementById('remaining_balance').value = '₱0.00';

            document.querySelectorAll('input[name="payment_type"]').forEach(function (radio) {
                radio.addEventListener('change', function () {
                    let finalAmount = cartTotal;
                    let remainingBalance = 0;

                    if (this.value === 'Downpayment') {
                        finalAmount = cartTotal / 2;
                        remainingBalance = cartTotal - finalAmount;
                    }

                    document.getElementById('final_amount_display').value = '₱' + finalAmount.toFixed(2);
                    document.getElementById('final_amount').value = finalAmount.toFixed(2);
                    document.getElementById('remaining_balance').value = '₱' + remainingBalance.toFixed(2);
                });
            });

            document.getElementById('proceedPaymentBtn').addEventListener('click', function (event) {
                const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
                if (!selectedPaymentMethod) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select a payment method before proceeding.',
                    });
                


                    }
            });
        });
    </script>
</body>
</html>
