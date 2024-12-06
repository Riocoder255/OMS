<?php

require './layouts-c/header-c.php';
require './layouts-c/navbar-c.php';
require_once "./admin_connect.php";
require_once "./function-c.php";
if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}
$user_id = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1 class="text-primary" style="text-align: center;">Your Order History</h1>
    <br>
    <div class="container-sm">
        <div class="card-body">
            <table class="table  table-striped-columns">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer_name</th>

                        <th>Branch</th>
                        <th>Total Amount</th>
                        <th>Remaing_balance</th>
                        <th>Payment Method</th>
                        <th>Order_approval</th>
                        <th>Status</th>
                        <th>View orders</th>
                        <th>Payment update</th>
                        <th>Order date finished</th>
                        <th>Payment History</th>


                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT orders.order_id as order_id, 
            orders.total_amount, 
            orders.remaining_balance,
            orders.payment_status, 
            orders.payment_type, 
            orders.payment_method, 
            orders.orders_created,
            orders.order_date_finished,
            orders.order_approval,
            branch.branch_name as branch_name,
             customer.name as name,
             customer.email as email

     FROM orders
     INNER JOIN branch ON orders.branch_id = branch.id
     JOIN customer ON orders.user_id = customer.user_id
     WHERE orders.user_id = ?
     ORDER BY orders.orders_created  DESC";

                    $stmt = $conn->prepare($query);
                    $stmt->bind_param('i', $user_id);
                    $stmt->execute();

                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()):
                    
                       
                        ?>

                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>

                            <td><?php echo htmlspecialchars($row['branch_name']); ?></td>
                            <td><?php echo number_format($row['total_amount'], 2); ?></td>
                            <td><?php echo number_format($row['remaining_balance'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_approval']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                            <td>
                                <button class="btn btn-success btn-sm view-order-btn"
                                    data-order-id="<?= $row['order_id'] ?>"> <i class="fas fa-eye"></i</button>
                            </td>

                            <td>
                                <button class="btn btn-success view-payment-btn btn-sm"
                                    data-order-id="<?= $row['order_id'] ?>"><i class="fas fa-edit"></i></button>

                            
<td>
<td>
                                                    <button class="btn btn-primary btn-sm views-payment-btn" data-order-id="<?= $row['order_id'] ?>">View</button>
                                               
                                                     <td>
                                                     <button class="btn btn-primary btn-sm cancelled-btn" data-order-id="<?= $row['order_id'] ?>">Cancel Order</button>
                                                     </td>
                            
                            <td><?php echo $row['orders_created'] ?></td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="paymentUpdateModal" tabindex="-1" aria-labelledby="paymentUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentUpdateModalLabel">Update Payment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentUpdateForm">
                        <input type="hidden" id="orderId" name="order_id">

                        <div class="mb-3">
                            <label for="totalAmount" class="form-label">Total Amount</label>
                            <input type="number" class="form-control" id="totalAmount" name="total_amount" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="remainingBalance" class="form-label">Remaining Balance</label>
                            <input type="number" class="form-control" id="remainingBalance" name="remaining_balance" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="paymentType" class="form-label">Payment Type</label>
                            <select class="form-control" id="paymentType" name="payment_type">
                                <option value="Fullcashpayment">Full Cash</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <select class="form-control" id="paymentMethod" name="payment_method">
                                <option value="GCash">GCash</option>
                                <option value="Over_the_counter">Over the Counter</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Category</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody id="orderDetailsBody">
                            <!-- Content will be dynamically loaded -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- payment_history -->
    <!-- payment_history -->
    <div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentHistoryModalLabel">Payment History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="paymentHistoryContent">
                        <!-- Payment history content will be loaded dynamically here -->
                        <p>Loading payment history...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
        const paymentUpdateModal = new bootstrap.Modal(document.getElementById('paymentUpdateModal'));
        const orderDetailsBody = document.getElementById('orderDetailsBody');

        // Attach click event to buttons for viewing order details
        document.querySelectorAll('.view-order-btn').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');

                // Fetch order details via AJAX
                fetch(`get_order_details.php?id=${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const rows = data.items.map(item => `
                            <tr>
                                <td><img src="${item.image}" alt="${item.product_name}" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                <td>${item.product_name}</td>
                                <td>${item.quantity}</td>
                                <td>${item.size}</td>
                                <td>${item.category}</td>
                                <td>${item.total_price}</td>
                            </tr>
                        `).join('');
                            orderDetailsBody.innerHTML = rows;
                        } else {
                            orderDetailsBody.innerHTML = '<tr><td colspan="6">No items found for this order.</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching order details:', error);
                        orderDetailsBody.innerHTML = '<tr><td colspan="6">Error loading order details.</td></tr>';
                    });

                // Show the modal
                modal.show();
            });
        });


        // Open Payment Modal
        document.querySelectorAll('.view-payment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-order-id');
                fetch(`get_payment_details.php?order_id=${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('orderId').value = orderId;
                            document.getElementById('totalAmount').value = data.payment.total_amount;
                            document.getElementById('remainingBalance').value = data.payment.remaining_balance;
                            document.getElementById('paymentType').value = data.payment.payment_type;
                            document.getElementById('paymentMethod').value = data.payment.payment_method;
                            paymentUpdateModal.show();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error fetching payment details:', error));
            });
        });

        // Handle Payment Update Form Submission
        document.getElementById('paymentUpdateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const paymentType = document.getElementById('paymentType').value;
            if (paymentType === 'full_cash') {
                document.getElementById('remainingBalance').value = 0;
            }

            const formData = new FormData(this);

            fetch('update_payment.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            timer: 2000, // Timer in milliseconds (2000ms = 2 seconds)
                            showConfirmButton: false, // Hides the "OK" button
                            willClose: () => {
                                paymentUpdateModal.hide(); // Hide the modal
                                location.reload(); // Reload the page
                            }
                        });

                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'An error occurred.', 'error');
                    console.error('Error updating payment:', error);
                });



        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentButtons = document.querySelectorAll(".views-payment-btn");
        const modal = new bootstrap.Modal(document.getElementById("paymentHistoryModal"));
        const paymentHistoryContent = document.getElementById("paymentHistoryContent");

        paymentButtons.forEach(button => {
            button.addEventListener("click", function() {
                const orderId = this.getAttribute("data-order-id");

                // Show modal
                modal.show();

                // Clear and load payment history
                paymentHistoryContent.innerHTML = "<p>Loading payment history...</p>";

                // Fetch payment history dynamically
                fetchPaymentHistory(orderId);
            });
        });

        function fetchPaymentHistory(orderId) {
            fetch("fetch_payment_history.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        order_id: orderId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Render the payment history table
                        renderPaymentHistory(data.payments);
                    } else {
                        paymentHistoryContent.innerHTML = `<p class="text-danger">Failed to load payment history: ${data.message}</p>`;
                    }
                })
                .catch(error => {
                    console.error("Error fetching payment history:", error);
                    paymentHistoryContent.innerHTML = `<p class="text-danger">An error occurred while loading payment history.</p>`;
                });
        }

        function renderPaymentHistory(payments) {
            if (payments.length === 0) {
                paymentHistoryContent.innerHTML = "<p>No payment history available.</p>";
                return;
            }

            // Build the table
            let table = `
                <table class="table table-bordered">
                    <thead>
                        <tr>
                       
                            <th> total Amount</th>
                            <th> total item</th>
                            <th> remaining  balance</th>
                            <th>Payment Method</th>
                                  <th>Payment  type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            payments.forEach(payment => {
                table += `
                    <tr>
                    
                        <td>${payment.total_amount}</td>
                        <td>${payment.total_item}</td>
                        <td>${payment.remaining_balance}</td>
                        <td>${payment.payment_method}</td>
                         <td>${payment.payment_type}</td>
                        <td>${payment.order_approval}</td>
                        
                    </tr>
                `;
            });

            table += `
                    </tbody>
                </table>
            `;

            paymentHistoryContent.innerHTML = table;
        }
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // When the button is clicked, trigger the cancel order function
    document.querySelectorAll('.cancelled-btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var orderId = this.getAttribute('data-order-id'); // Get the order ID from the data attribute

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to cancel this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to cancel the order
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'cancel_order.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Show success or error message
                        Swal.fire(
                            'Cancelled!',
                            xhr.responseText, // Response message from PHP
                            'success'
                        );
                        // Optionally, you can update the UI or remove the button
                    }
                };
                xhr.send('order_id=' + orderId); // Send order ID to PHP
            }
        });
    });
});
</script>




</html>
<?php
include("./layouts/footer.php");
include("./layouts/scripts.php");
?>