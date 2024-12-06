<?php 

require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';
require_once "./admin_connect.php";
require_once "./function-c.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- refund -->

    <!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="refundModalLabel">Process Refund</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Refund Form -->
        <form id="refundForm">
          <div class="mb-3">
            <label for="order_id" class="form-label">Order ID</label>
            <input type="text" class="form-control" id="order_id" name="order_id" required>
          </div>
          <div class="mb-3">
            <label for="refund_amount" class="form-label">Refund Amount</label>
            <input type="number" class="form-control" id="refund_amount" name="refund_amount" step="0.01" required>
          </div>
          <div class="mb-3">
            <label for="refund_reason" class="form-label">Refund Reason</label>
            <textarea class="form-control" id="refund_reason" name="refund_reason" required></textarea>
          </div>
          <input type="hidden" id="refunded_by" name="refunded_by" value="1"> <!-- Admin User ID (replace with session or user id) -->
          <button type="submit" class="btn btn-primary">Submit Refund</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <div class="container">
        
 <div class="card-body">
    <div class="card-header">
         <h2>Refund management
         <button class="btn btn-primary btn-sm btn-receive" data-order-id="<?= $row['order_id']; ?>" data-bs-toggle="modal" data-bs-target="#refundModal">
  Process Refund
</button>


         </h2>
    </div>

    <div class="card-body">
    <table class="table">
   <thead>
      <tr>
         <th>Order ID</th>
         <th>Item</th>
         <th>Size</th>
         <th>Quantity</th>
         <th>Category</th>
         <th>Customer Name</th>
         <th>Status</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      <?php 
      $refundQuery = "  SELECT 
       items_orders.quantity,orders.order_id ,orders.total_item, items_orders.size, items_orders.category  
       ,  orders.order_status
      
       
FROM  items_orders
JOIN orders ON  items_orders. order_id = orders.order_id";
            
            
         ;
      $refundResult = $conn->query($refundQuery);
      ?>

      <?php if ($refundResult->num_rows > 0): ?>
         <?php while($order = $refundResult->fetch_assoc()): ?>
            <tr>
               <td><?= $order['order_id'] ?></td>
               <td><?= $order['total_item'] ?></td>
               <td><?= $order['size'] ?></td>
               <td><?= $order['quantity'] ?></td> <!-- Corrected from qty to quantity -->
               <td><?= $order['category'] ?></td>
               <td></td>
               <td><?= $order['order_status'] ?></td>
               <td>
                  <!-- Button for processing refund -->
                  <button class="btn btn-primary btn-sm btn-receive" data-order-id="<?= $order['order_id']; ?>" data-bs-toggle="modal" data-bs-target="#refundModal">Process Refund</button>
               </td>
            </tr>
         <?php endwhile; ?>
      <?php else: ?>
         <tr>
            <td colspan="8" class="text-center">No orders found.</td>
         </tr>
      <?php endif; ?>
   </tbody>
</table>
        </tbody>
    </table>

 
  </tbody>
</table>
    </div>
 </div>
    </div><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Trigger Modal
  document.querySelector('.btn-receive').addEventListener('click', function() {
    var orderId = this.getAttribute('data-order-id');
    $('#refundModal').modal('show'); // Show the modal
    // Optionally, pre-fill order_id in the modal (if you want to auto-fill it)
    document.getElementById('order_id').value = orderId;
  });

  // Handle Refund Form Submission via AJAX
  document.getElementById('refundForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    // Send the form data to PHP via AJAX
    fetch('process_refund.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(responseText => {
      if (responseText.includes('success')) {
        // Show success SweetAlert
        Swal.fire({
          title: 'Success!',
          text: 'Refund processed successfully.',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          // Close the modal
          $('#refundModal').modal('hide');
          // Optionally, reload the page or update the UI
        });
      } else {
        // Show error SweetAlert
        Swal.fire({
          title: 'Error!',
          text: responseText,
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    })
    .catch(error => {
      console.error('Error:', error);
      Swal.fire({
        title: 'Error!',
        text: 'An error occurred while processing the refund.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    });
  });
</script>

    
</body>
</html>


<?php 



?>