    <?php
    require "layouts/header.php";
    require 'layouts/sidebar.php';
    require 'layouts/topbar.php';
    require_once "./admin_connect.php";
    require_once "./function-c.php";

    // Handle status change


    // Fetch orders
    $query = "SELECT DISTINCT
    o.order_id,
    o.total_amount,
    o.payment_type,
    o.remaining_balance,
    o.payment_status,
    o.orders_created,
    o.total_item,
    o.order_date_finished,
    o.order_approval,
    o.order_status,
    c.name AS customer_name,
    c.lname AS customer_lname,
    b.Branch_name AS branch_name
    
FROM 
    orders AS o
INNER JOIN 
    customer AS c ON o.user_id = c.user_id
INNER JOIN 
    branch AS b ON o.branch_id = b.id
 
";



    $result = mysqli_query($conn, $query) or die('QUERY IS FAILED' . mysqli_error($conn));



    ?>

    <!-- Order Details Modal -->
    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-20">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0 font-weight-bold text-primary">View Orders</h6>
                    </div>
                    <div class="card-body">
                        <div class="responsive-table">
                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Branch</th>
                                        <th>Order List</th>
                                        <th>Remaining Balance</th>
                                        <th>Total Amount</th>
                                        <th>Total Item</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>orders status</th>
                                        <th>Payment update</th>
                                        <th>Confirm Orders</th>
                                        <th>Payment history</th>
                                        <th>receive log</th>

                                        <th>Orders Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        $count = 1;
                                        while ($row = mysqli_fetch_array($result)) {


                                    ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= htmlspecialchars($row['customer_name']) ?> <?= htmlspecialchars($row['customer_lname']) ?></td>
                                                <td><?= htmlspecialchars($row['branch_name']) ?></td>
                                                <td>
                                                    <button class="btn btn-success btn-sm view-order-btn"
                                                        data-order-id="<?= $row['order_id'] ?>"> <i class="fas fa-eye"></i></button>
                                                </td>
                                                <td><?= htmlspecialchars($row['remaining_balance']) ?></td>
                                                <td><?= htmlspecialchars($row['total_amount']) ?></td>
                                                <td><?= htmlspecialchars($row['total_item']) ?></td>
                                                <td><?= htmlspecialchars($row['payment_type']) ?></td>
                                                <td><?= htmlspecialchars($row['payment_status']) ?></td>
                                                <td style="color: <?= ($row['order_status'] == 'cancelled') ? 'red' : ($row['order_status'] == 'active' ? 'green' : 'black') ?>;">
                                                    <?= htmlspecialchars($row['order_status']) ?>
                                                </td>

                                                <td>
                                                    <button class="btn btn-success view-payment-btn btn-sm"
                                                        data-order-id="<?= $row['order_id'] ?>"><i class="fas fa-edit"></i></button>

                                                <td>
                                                    <a href="javascript:void(0);"
                                                        class="  btn btn-pending order-status-link <?= $row['order_approval'] === 'approved' ? 'text-success' : 'text-danger' ?>"
                                                        data-order-id="<?= $row['order_id'] ?>"
                                                        data-status="<?= $row['order_approval'] ?>">
                                                        <?= $row['order_approval'] === 'approved' ? 'Approved' : 'processing' ?>
                                                    </a>
                                                </td>


                                                <td>
                                                    <button class="btn btn-primary btn-sm views-payment-btn" data-order-id="<?= $row['order_id'] ?>">View</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm"
                                                        data-id="<?php echo $row['order_id']; ?>"
                                                        data-bs-toggle="modal" data-bs-target="#logModal">
                                                        Receive
                                                    </button>
                                                </td>


                                            </tr>
                                    <?php $count++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='11'>No records found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- logoo -->

<!-- Modal Structure -->
<div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logModalLabel">Receive Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form to capture the receive log data -->
                <form id="receiveForm" action="receive_log.php" method="POST">
                    <input type="hidden" name="order_id" id="order_id">

                    <!-- Item, Size, Quantity, Category -->
                    <div class="mb-3">
                        <label for="item" class="form-label">Item</label>
                        <input type="text" class="form-control" id="item" name="item" >
                    </div>

                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <input type="text" class="form-control" id="size" name="size" >
                    </div>

                    <div class="mb-3">
                        <label for="size" class="form-label">qty</label>
                        <input type="number" class="form-control" id="size" name="qty">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                 
                        <?php 
                        $query = "SELECT * FROM pricing ";
                        $result = $conn->query($query);
                        
                        // Check if there are any results
                        if ($result->num_rows > 0) {
                            echo '<select class="form-select" name=" category" id="user" ';
                            echo '<option value="">Select  catageory</option>';
                            
                            // Loop through the result set and display each admin as an option in the dropdown
                            while ($row = $result->fetch_assoc()) {
                                $adminId = $row['id']; // Assuming 'id' is the primary key of the admin
                                $adminName = $row['category_name']; // Assuming 'name' stores the admin's name
                                
                                // Output each option
                                echo "<option value='$adminId'>$adminName</option>";
                            }
                        
                            echo '</select>';
                        } else {
                            echo "No admin users found.";
                        }
                        ?>
                    </div>

                    <!-- Customer Name -->
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" >
                    </div>

                    <!-- Signature -->
                    <div class="mb-3">
                        <label for="signature" class="form-label">Signature</label>
                        <input type="hidden" name="signature" id="signature">
                        <canvas id="signatureCanvas" class="form-control" width="300" height="150"></canvas>
                    </div>

                    <!-- Select User (Admin) -->
                    <div class="mb-3">
                        <label for="user" class="form-label">User</label>
                        <?php 
                        $query = "SELECT * FROM user_form ";
                        $result = $conn->query($query);
                        
                        // Check if there are any results
                        if ($result->num_rows > 0) {
                            echo '<select class="form-select" name="user_id" id="user" >';
                            echo '<option value="">Select Admin</option>';
                            
                            // Loop through the result set and display each admin as an option in the dropdown
                            while ($row = $result->fetch_assoc()) {
                                $adminId = $row['id']; // Assuming 'id' is the primary key of the admin
                                $adminName = $row['fname']; // Assuming 'name' stores the admin's name
                                
                                // Output each option
                                echo "<option value='$adminId'>$adminName</option>";
                            }
                        
                            echo '</select>';
                        } else {
                            echo "No admin users found.";
                        }
                        ?>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
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
    <!-- payment modal -->
    <!-- Payment Update Modal -->
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
                                <option value="full_cash">Full Cash</option>
                                <option value="otc">Over The Counter</option>
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

    <!-- recieve log -->

    <!-- Modal for Editing Customer -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="orderId" class="form-label">Order ID</label>
                            <input type="text" class="form-control" id="orderId" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customerName" required>
                        </div>
                        <div class="mb-3">
                            <label for="customerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="customerEmail" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- recieve logs -->

    <!-- Modal -->



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll(".order-status-link");

            links.forEach(link => {
                link.addEventListener("click", function() {
                    const orderId = this.getAttribute("data-order-id");
                    const currentStatus = this.getAttribute("data-status");
                    const newStatus = currentStatus === "processing" ? "approved" : "processing";

                    // SweetAlert confirmation
                    Swal.fire({
                        title: `Change status to ${newStatus}?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: `Yes, ${newStatus} it!`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Update the link text, status, and color
                            this.setAttribute("data-status", newStatus);
                            this.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                            // Remove old class and add the new one
                            this.classList.toggle("text-danger", newStatus === "processing");
                            this.classList.toggle("text-success", newStatus === "approved");

                            // Update the database
                            updateOrderStatus(orderId, newStatus);

                            // SweetAlert success message
                            Swal.fire(
                                `${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}!`,
                                `The order has been ${newStatus} successfully.`,
                                "success"
                            );
                        }
                    });
                });
            });

            // Function to update the status in the database
            function updateOrderStatus(orderId, newStatus) {
                fetch("update_order_status.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                            order_approval: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert("Failed to update order status: " + data.message);
                        }
                    })
                    .catch(error => console.error("Error updating order status:", error));
            }
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
                        <td>${payment.payment_status}</td>
                        
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all modal trigger links
            const modalTriggers = document.querySelectorAll('.open-log-modal');

            // Add event listener to each link
            modalTriggers.forEach(trigger => {
                trigger.addEventListener('click', function(e) {
                    // Prevent default behavior (navigation)
                    e.preventDefault();

                    // Get the order_id from data-* attribute
                    const orderId = this.getAttribute('data-order-id');

                    // Set the order id in the modal
                    document.getElementById('order-id').textContent = orderId;

                    // Fetch customer name and other details via AJAX or another PHP function
                    fetchCustomerName(orderId);
                });
            });

            // Function to fetch customer name
            function fetchCustomerName(orderId) {
                // Example of an AJAX call to fetch the customer name (you can adapt this as needed)
                fetch('get_customer_info.php?order_id=' + orderId)
                    .then(response => response.json())
                    .then(data => {
                        // If customer data is returned
                        if (data.success) {
                            document.getElementById('name').textContent = data.name;
                        } else {
                            document.getElementById('name').textContent = 'Customer not found';
                        }
                    })
                    .catch(error => {
                        document.getElementById('name').textContent = 'Error fetching customer data';
                        console.error('Error fetching customer data:', error);
                    });
            }
        });
    </script>




    <script>
        $(document).ready(function() {
            // Listen for button click
            $(".view-receive-btn").click(function() {
                var orderId = $(this).data("order-id");

                // Make an AJAX request to fetch customer name based on order_id
                $.ajax({
                    url: './get-customer-info.php', // PHP script that retrieves the customer's name
                    type: 'GET',
                    data: {
                        order_id: orderId
                    },
                    success: function(response) {
                        // Assuming the response is the customer's name
                        $('#customerName').text('Customer Name: ' + response);

                        // Show the modal
                        $('#receiveModal').modal('show');
                    },
                    error: function() {
                        alert('Error retrieving data');
                    }
                });
            });
        });
    </script>






<!-- 
 -->

 <script>
    // When the modal is shown, populate the form with the order ID
document.querySelectorAll('.btn').forEach(function(button) {
    button.addEventListener('click', function() {
        var orderId = this.getAttribute('data-id');
        document.getElementById('order_id').value = orderId;
    });
});

// Handle signature drawing
const signatureCanvas = document.getElementById('signatureCanvas');
const ctx = signatureCanvas.getContext('2d');
let isDrawing = false;

signatureCanvas.addEventListener('mousedown', (e) => {
    isDrawing = true;
    ctx.moveTo(e.offsetX, e.offsetY);
});

signatureCanvas.addEventListener('mousemove', (e) => {
    if (isDrawing) {
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
    }
});

signatureCanvas.addEventListener('mouseup', () => {
    isDrawing = false;
});

// Clear signature
function clearSignature() {
    ctx.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
}

 </script>

<script>
    // Listen for the form submission
    document.getElementById('receiveForm').addEventListener('submit', function(event) {
        // Prevent the form from submitting immediately to show SweetAlert first
        event.preventDefault();

        // Trigger SweetAlert message
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to submit the form!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                this.submit();
            }
        });
    });
</script>


    <?php
    include("./layouts/footer.php");
    include("./layouts/scripts.php");
    ?>

    <style>
        .btn-success {
            color: white;
            background-color: green;
            border-color: green;
        }

        .btn-danger {
            color: white;
            background-color: red;
            border-color: red;
        }
    </style>