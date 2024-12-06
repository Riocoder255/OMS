<?php
include("./admin_connect.php"); // Assuming you need it for product details
include ('./layouts-c/header-c.php');
include ('./layouts-c/navbar-c.php');



// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Query to fetch cart details for the logged-in user
$qry = mysqli_query($conn, "
    SELECT 
        cart.id AS cart_id, 
        product_price.product_name, 
        cart.cartsize AS size, 
        cart.quantity, 
        cart.price, 
        pricing.category_name,
        (cart.quantity * cart.price) AS total_price, 
        cart.image_path
    FROM cart
    JOIN product_price ON cart.product_id = product_price.product_id
     JOIN pricing  ON product_price.price_id  = pricing.id
    WHERE cart.user_id = '$user_id'
");



if ($qry && mysqli_num_rows($qry) > 0) {
        echo "<form action='update-cart.php' method='POST' id='cart_form  '>
                <table  class='table table-bordered border-primary' style='margin-left:10%;width:60%; margin-top:5%;'>
                    <tr>
                        <th><input type='checkbox' id='select_all'> Select All</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>";
        
        $total_cart_value = 0; // Variable to hold the total value of the selected items
        
        // Fetch and display each cart item
        while ($row = mysqli_fetch_assoc($qry)) {
            $cart_id = $row['cart_id'];
            $product_name = $row['product_name'];
            $cat_name = $row['category_name'];
            $size = $row['size'];
            $quantity = $row['quantity'];
            $price = $row['price'];
            $total_price = $row['total_price'];
            $image_path = $row['image_path'];

            $total_cart_value += $total_price;


            echo "<tr>
            <td><input type='checkbox' name='selected_items[]' value='$cart_id' class='cart_checkbox' data-total='$total_price'></td>
            <td class='col'>" . htmlspecialchars($product_name) . "</td>
              <td class='col'>" . htmlspecialchars($cat_name) . "</td>
            <td>" . htmlspecialchars($size) . "</td>
            <td>
                <button type='submit' name='action' value='decrement_$cart_id' class='btn btn-warning btn-sm'>-</button>
                " . htmlspecialchars($quantity) . "
                <button type='submit' name='action' value='increment_$cart_id' class='btn btn-success btn-sm'>+</button>
            </td>
            <td>" . htmlspecialchars($price) . "</td>
            <td class='total_price'>" . htmlspecialchars($total_price) . "</td>
            <td><img src='design_upload/" . htmlspecialchars($image_path) . "' alt='Product Image' width=40'></td>
            <td>
                <a href='javascript:void(0);' class='btn btn-danger btn-sm' onclick='confirmDelete($cart_id)'>
                    <i class='fas fa-trash'></i>
                </a>
            </td>
        </tr>";
        }

        // Display the total amount of the selected items
        echo "<tr><td colspan='8' style='text-align:center;'>
                <div>Total Cart Value: <span id='total_amount'>0</span></div>
            
            </td></tr>";

        echo "</table>
        <div>
                    
                </div>";

                ?>
                <label>
            
            
                <button type="button" class="btn btn-primary" id="proceedButton">Proceed to checkout</button>
            
        </td>


        
        </form>
            <?php
} else {
    ?>
    <div class="empty-cart-container">
        <!-- Replace the src attribute with your image URL -->
      
       <img src="https://www.gospeedy.co.in/images/empty.gif" alt="Crying Cart" class="empty-cart-image">
      
        <div class="empty-cart-text">Your Cart is Empty</div>
        <a href="home-client.php" class=" btn btn-danger">Go Orders now .</a>
    </div>
    <?php
   
   
  
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
                window.location.href = "cart_view.php"; // Replace with your cart page URL
            });
        </script>';
    } else {
        echo "Error deleting item: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "";
}
?>

<script type="text/javascript">


    function confirmDelete(cartId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove this item from your cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the PHP script to handle deletion
                window.location.href ='cart_view.php?id=' + cartId;
            }
        });
    }
</script>

<script>

    
// JavaScript to handle select all functionality
// Function to update the total cart value dynamically
function updateTotal() {
    let total = 0;

    // Get all selected checkboxes
    const selectedItems = document.querySelectorAll('.cart_checkbox:checked');

    // Calculate the total value of selected items
    selectedItems.forEach(item => {
        total += parseFloat(item.getAttribute('data-total'));
    });

    // Update the total value in the display
    document.getElementById('total_amount').textContent = total.toFixed(2);
}

// Add event listener to all checkboxes to trigger the updateTotal function
document.querySelectorAll('.cart_checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateTotal);
});

// Handle proceed button click
document.getElementById('proceedButton').addEventListener('click', function () {
    const selectedItems = Array.from(document.querySelectorAll('.cart_checkbox:checked'));

    if (selectedItems.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'No items selected',
            text: 'Please select at least one item to proceed.',
        });
        return;
    }

    // Collect selected item data
    const items = selectedItems.map(item => ({
        cart_id: item.value,
        product_name: item.closest('tr').querySelector('.col:nth-child(2)').textContent.trim(),
        category: item.closest('tr').querySelector('.col:nth-child(3)').textContent.trim(),
        size: item.closest('tr').querySelector('td:nth-child(4)').textContent.trim(),
        quantity: item.closest('tr').querySelector('td:nth-child(5)').textContent.trim(),
        image_path: item.closest('tr').querySelector('img').getAttribute('src'),
        total_price: item.getAttribute('data-total')
    }));

    // Calculate the total amount
    const totalAmount = items.reduce((sum, item) => sum + parseFloat(item.total_price), 0);

    // Redirect to the payment page with selected items
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'payment-c.php';

    const itemsInput = document.createElement('input');
    itemsInput.type = 'hidden';
    itemsInput.name = 'cart_items';
    itemsInput.value = JSON.stringify(items);
    form.appendChild(itemsInput);

    const amountInput = document.createElement('input');
    amountInput.type = 'hidden';
    amountInput.name = 'total_amount';
    amountInput.value = totalAmount.toFixed(2);
    form.appendChild(amountInput);

    document.body.appendChild(form);
    form.submit();
});



</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Function to update the total amount
    function updateTotalAmount() {
        var totalAmount = 0;
        // Loop through each selected item and add its total price
        $('.cart_checkbox:checked').each(function() {
            totalAmount += parseFloat($(this).data('total'));
        });
        // Update the total amount on the page
        $('#total_amount').text(totalAmount.toFixed(2));
    }

    // Handle "Select All" checkbox
    $('#select_all').click(function() {
        var isChecked = $(this).prop('checked');
        $('.cart_checkbox').prop('checked', isChecked);
        updateTotalAmount();
    });

    // Handle individual checkbox selection
    $(document).on('change', '.cart_checkbox', function() {
        // Check if all checkboxes are selected to update "Select All" checkbox
        var allSelected = $('.cart_checkbox').length === $('.cart_checkbox:checked').length;
        $('#select_all').prop('checked', allSelected);
        updateTotalAmount();
    });

    // Handle "Proceed to Checkout"
    $('#proceedButton').click(function() {
        var selectedItems = [];
        $('.cart_checkbox:checked').each(function() {
            selectedItems.push($(this).val());
        });

        if (selectedItems.length > 0) {
            // Send selected items to checkout or display them
            console.log("Selected Items for Checkout:", selectedItems);
            // Example: You can redirect to checkout page or handle further
            // window.location.href = 'checkout.php?items=' + selectedItems.join(',');
        } else {
            Swal.fire({
                title: 'No items selected!',
                text: 'Please select items to proceed to checkout.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    });
});
</script>

<link rel="stylesheet" href="./Display/css/style-find.css">
    
</body>
</html>
