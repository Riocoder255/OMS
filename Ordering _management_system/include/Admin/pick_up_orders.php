<?php 
include ('./layouts-c/header-c.php');
include ('./layouts-c/navbar-c.php');


include './admin_connect.php';





?>
<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
    <script>
        function calculateBalance() {
            var totalAmount = parseFloat(document.getElementById('total_amount').value);
            var downpayment = parseFloat(document.getElementById('downpayment').value);
            var balance = totalAmount - downpayment;
            document.getElementById('balance').value = balance.toFixed(2);
        }
    </script>
</head>
<body>
    <h2>Place an Order</h2>
    <form method="post" action="submit_order.php">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name" value="<?php echo $customer['name']; ?>" readonly><br><br>

        <label for="customer_email">Customer Email:</label>
        <input type="email" id="customer_email" name="customer_email" value="<?php echo $customer['email']; ?>" readonly><br><br>

        <label for="customer_phone">Customer Phone:</label>
        <input type="text" id="customer_phone" name="customer_phone" value="<?php echo $customer['phone']; ?>" readonly><br><br>

        <label for="branch">Select Branch:</label>
        <select name="branch_id" id="branch">
            <?php
            $branch_result = $conn->query("SELECT * FROM branch");
            while ($branch = $branch_result->fetch_assoc()) {
                echo "<option value='".$branch['id']."'>".$branch['Branch_name']."</option>";
            }
            ?>
        </select><br><br>

        <label for="total_amount">Total Amount:</label>
        <input type="number" id="total_amount" name="total_amount" step="0.01" oninput="calculateBalance()"><br><br>

        <label for="downpayment">Downpayment:</label>
        <input type="number" id="downpayment" name="downpayment" step="0.01" oninput="calculateBalance()"><br><br>

        <label for="balance">Balance:</label>
        <input type="number" id="balance" name="balance" step="0.01" readonly><br><br>

        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method">
            <option value="G-Cash">G-Cash</option>
            <option value="Over the Counter">Over the Counter</option>
        </select><br><br>

        <label for="g_cash_number" id="g_cash_number_label" style="display:none;">G-Cash Number:</label>
        <input type="text" id="g_cash_number" name="g_cash_number" style="display:none;"><br><br>

        <button type="submit">Submit Order</button>
    </form>

    <script>
        document.getElementById('payment_method').addEventListener('change', function () {
            var paymentMethod = this.value;
            if (paymentMethod === 'G-Cash') {
                document.getElementById('g_cash_number_label').style.display = 'block';
                document.getElementById('g_cash_number').style.display = 'block';
            } else {
                document.getElementById('g_cash_number_label').style.display = 'none';
                document.getElementById('g_cash_number').style.display = 'none';
            }
        });
    </script>
</body>
</html>
