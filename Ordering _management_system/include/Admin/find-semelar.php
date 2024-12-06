  <?php
  include './layouts-c/header-c.php';
  include './layouts-c/navbar-c.php';
  include './admin_connect.php';



if (isset($_GET['product_id'])) {
  $id = $_GET['product_id'];

  // Join query to fetch product details along with sizes and concatenated images
  $qry = mysqli_query($conn, "SELECT DISTINCT
        product_price.*, 
        pricing.*, 
        product_size.product_id, 

        product_size.images
        
       
    FROM 
        product_price
    INNER JOIN 
        pricing ON product_price.price_id = pricing.id
    INNER JOIN 
        product_size ON product_price.product_id = product_size.product_id
     

    WHERE 
        product_price.product_id = '$id';
  ");

  $image_unique = [];
$size= [];

  $product_details = [];
    while ($row = mysqli_fetch_assoc($qry)) {
        $image_unique [] = $row;
        $size [] = $row;
      // Process images and ensure uniqueness
     
      
  }

  // Fetch product details separately for display
  $product_qry = mysqli_query($conn, "SELECT DISTINCT
    p.*, 
    pc.*
    
FROM 
    product_price p
JOIN 
    pricing  pc
ON 
    p.price_id = pc.id
  WHERE p.product_id = '$id'
    ");
$res = mysqli_fetch_assoc($product_qry);

;
}



// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve and sanitize inputs
  $product_id = intval($_POST['product_id']);
  $size = isset($_POST['Size']) ? trim($_POST['Size']) : null;
  $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
  $productsize_id = isset($_POST['productsize_id']) ? htmlspecialchars($_POST['productsize_id']) : null;
  $action = $_POST['action'];

  // Validation
  if (empty($size)) {
      echo '<script type="text/javascript">
          Swal.fire({ text: "Oops! Please select a size.", icon: "error", confirmButtonText: "OK" })
          .then(() => { window.history.back(); });
      </script>';
      exit(0);
  }
  if (empty($productsize_id)) {
      echo '<script type="text/javascript">
          Swal.fire({ text: "Oops! Please select an image.", icon: "error", confirmButtonText: "OK" })
          .then(() => { window.history.back(); });
      </script>';
      exit(0);
  }

  // Fetch the product price
  $qry = mysqli_query($conn, "SELECT price FROM pricing WHERE id ");
  if (!$qry || !($row = mysqli_fetch_assoc($qry))) {
      die("Error fetching product price or product not found.");
  }
  $price = $row['price'];
  $total_price = $price * $quantity;

  // Check if the product, size, and image already exist in the cart
  $user_id = $_SESSION['user_id']; // Assuming session has the user ID
  $check_cart = mysqli_query($conn, "SELECT id, quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id' AND cartsize = '$size' AND image_path = '$productsize_id'");

  if ($check_cart && mysqli_num_rows($check_cart) > 0) {
      // If the item already exists, update the quantity
      $existing_item = mysqli_fetch_assoc($check_cart);
      $new_quantity = $existing_item['quantity'] + $quantity; // Increase the quantity
      $cart_id = $existing_item['id'];

      // Update the cart quantity and total price
      $update_stmt = $conn->prepare("UPDATE cart SET quantity = ?, price = ? WHERE id = ?");
      if (!$update_stmt) {
          die("Error preparing statement: " . $conn->error);
      }
      $update_stmt->bind_param("idi", $new_quantity, $total_price, $cart_id);

      if ($update_stmt->execute()) {
          echo '<script type="text/javascript">
              Swal.fire({
                  title: "Updated Cart!",
                  text: "The quantity of your item has been updated.",
                  icon: "success",
                  confirmButtonText: "OK"
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "find-semelar.php?product_id=' . $product_id . '"; // Redirect to product page
                  }
              });
          </script>';
      } else {
          echo "Error updating cart: " . $update_stmt->error;
      }
      $update_stmt->close();
  } else {
      // If the item does not exist in the cart, insert a new record
      $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, cartsize, quantity, price, image_path) 
                              VALUES (?, ?, ?, ?, ?, ?)");
      if (!$stmt) {
          die("Error preparing statement: " . $conn->error);
      }

      $stmt->bind_param("iisids", $user_id, $product_id, $size, $quantity, $total_price, $productsize_id);

      if ($stmt->execute()) {
          if ($action === 'buy_now') {
            echo '<script type="text/javascript">
            Swal.fire({
                title: "Added to Cart!",
                text: "Your item has been successfully added to the cart.",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "cart_view.php"; 
                }
            });
        </script>'; // Redirect to checkout if 'buy now' is selected
              exit;
          } else {
              echo '<script type="text/javascript">
                  Swal.fire({
                      title: "Added to Cart!",
                      text: "Your item has been successfully added to the cart.",
                      icon: "success",
                      confirmButtonText: "OK"
                  }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.href = "find-semelar.php?product_id=' . $product_id . '"; 
                      }
                  });
              </script>';
          }
      } else {
          echo "Error: " . $stmt->error;
      }
      $stmt->close();
  }
}



?>
 

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <link rel="stylesheet" href="./Display/css/style-find.css">
  <body>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="ImgDl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            <img src="./product_upload/437187705_339790395393976_4547365603316354518_n.jpg" class="img-fluid">

          </div>

        </div>
      </div>
    </div>
    <div>
    <form  method="post" enctype="multipart/form-data" id="cartform">
      <div class="container ">
        <div class="card-2">
          <div class="image">

            <img src="product_upload/<?php echo $res['cover']; ?>" alt="" id="featured" class="">
          </div>
          <div id="slide-wrapper">

            <img src="./product_upload/arrow.jpg" alt="" class="arrow" id="slide_left">
            <div id="slider" style="overflow-x: hidden;">

  
            <?php
foreach ($image_unique as $product) {
    $images = explode(',', $product['images']);
    foreach ($images as $index => $image) {
        $image = trim($image);

        // Unique id for each image and radio button
        $uniqueId = "image_" . uniqid() . "_" . $index; // Adding uniqid() to prevent potential duplicates

        echo "<div class='image-thumbnail' id='thumbnail_" . $uniqueId . "'>"; // Unique ID for thumbnail
        echo "<label for='" . $uniqueId . "' class='image-label'>";
        // Add onclick to select the radio button
        echo "<img src='design_upload/" . $image . "' alt='Thumbnail' class='thumbnail' onclick=\"selectImage('" . $uniqueId . "')\" data-image='product_upload/" . $image . "'>";
        echo "</label>";
        // Radio button with the unique id
        echo "<input type='radio' name='productsize_id' value='" . $image . "' id='" . $uniqueId . "' hidden>";
        echo "</div>";
    }
}
?>


            </div>
            <img src="./product_upload/left.jpg" alt="" class="arrow" id="slide_right">

          </div>

          <div class="info text-dark">
          <p style="color: red; "> ₱<?php echo $res['price']; ?></p> 
            <div class="product_name">
              <h2><?php echo $res['product_name']; ?> </h2>
              <p> <span class="text-danger">Category </span>     <?php echo $res['category_name']; ?> </p>
         
            </div>
          
            <div class="sep-rate">

             
            


            </div>





           
                 <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
                 <input type="hidden" name="price" value="<?php echo $res['price']; ?>">
            <p  name ="price" id="price" style="display: none;" >Total :<?php echo $res['price']; ?></p> <!-- Display initial price -->
           
<!-- Hidden inputs for product details -->

<button type="button" id="decrement"  class="btn btn-danger btn-sm" style="width:20%;">-</button>
<!-- Quantity input with buttons to increase or decrease -->
<input type="number" id="selected_quantity" name="quantity" value="1" min="1" step="1" readonly style="width:20%;">
<button type="button" id="increment"  class="btn btn-success btn-sm" style="width:20%;">+</button>
 <br>
              <div class="row">
              <div class="col">
             <br>

             <?php
$qry = mysqli_query($conn, "SELECT DISTINCT
    sizing.size
FROM 
    product_price
INNER JOIN 
    product_size ON product_price.product_id = product_size.product_id
INNER JOIN  
    sizing ON product_size.size_id = sizing.id
WHERE 
    product_price.product_id = '$id'");

$size = [];

// Fetch sizes from the query
if ($qry && mysqli_num_rows($qry) > 0) {
    while ($row = mysqli_fetch_assoc($qry)) {
        $size[] = $row['size']; // Store sizes in the array
    }
} else {
    echo "No sizes available for this product.";
}

// Ensure unique sizes
$unique_sizes = array_unique($size);
?>

<!-- HTML Output -->
<?php if (!empty($unique_sizes)): ?>
    <div id="size-container">
        <label for="size">Select Size:</label>
        <select name="Size" id="size">
            <option value="">Choose a size</option> <!-- Default option -->
            <?php foreach ($unique_sizes as $size): ?>
                <option value="<?php echo htmlspecialchars($size); ?>">
                    <?php echo htmlspecialchars($size); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <p id="size-error" style="color: red; display: none; font-size: 0.9em;">Please select a size.</p>
<?php else: ?>
    <p>No sizes available for this product.</p>
<?php endif; ?>


              </div>
 
       
      
      </div>
      <div class="row">
      <div class="col">
      
      <script>
document.getElementById('add-to-cart').addEventListener('click', function () {
    const sizeDropdown = document.getElementById('size');
    const sizeError = document.getElementById('size-error');

    // Reset styles and error message
    sizeDropdown.style.border = '';
    sizeError.style.display = 'none';

    // Check if a size is selected
    if (!sizeDropdown.value) {
        // Highlight dropdown with red border
        sizeDropdown.style.border = '2px solid red';

        // Show error message
        sizeError.style.display = 'block';

        // Prevent further action (e.g., form submission)
        return;
    }

    // If size is selected, proceed (e.g., submit form or call add-to-cart logic)
    alert('Size selected: ' + sizeDropdown.value);
});
</script>



<script>
function selectImage(radioId) {
    // Find all image-thumbnail elements and remove the 'selected' class
    document.querySelectorAll('.image-thumbnail').forEach((thumbnail) => {
        thumbnail.classList.remove('selected');
    });

    // Add the 'selected' class to the currently selected thumbnail
    const selectedThumbnail = document.getElementById('thumbnail_' + radioId);
    if (selectedThumbnail) {
        selectedThumbnail.classList.add('selected');
    }

    // Ensure the radio button is checked
    const radio = document.getElementById(radioId);
    if (radio) {
        radio.checked = true;
    }
}
</script>






      </div>

              </div>



            


          </div>
          
          
<br><br>
      
       
               <div class="button">
               <button type="submit" class="btn btn-secondary" name="action" value="add_to_cart" id="add-to-cart">Add To Cart</button>

              </button>
              <button type="submit" class="btn btn-success buy" name="action" value="buy_now">Buy now</button>

            </div>
        </form>
          </div>
        </div>
      </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">

// click  select  radio of   the images

$(document).ready(function () {
    // Add click event to thumbnails
    $('.thumbnail').on('click', function () {
        // Get the data-image attribute of the clicked image
        const selectedImage = $(this).data('image');
        
        // Mark the corresponding radio button as checked
        const radioButton = $(this).closest('.image-thumbnail').find('input[type="radio"]');
        radioButton.prop('checked', true);

        // Optional: Add visual feedback for the selected image
        $('.thumbnail').removeClass('selected');
        $(this).addClass('selected');

        // Send the selected image to the server using AJAX
       
    });
});
</script>

    </script>

   

    <script>
    



document.getElementById('increment').addEventListener('click', function() {
    var quantityInput = document.getElementById('selected_quantity');
    var quantity = parseInt(quantityInput.value);
    quantityInput.value = quantity + 1;

    // Show the freebie if quantity >= 3
    if (quantity + 1 >= 3) {
        document.getElementById('freebie').style.display = 'block';
    }
});



// JavaScript to handle increment, decrement, and dynamic price update
document.getElementById('increment').addEventListener('click', function() {
    let quantity = document.getElementById('selected_quantity').value;
    quantity++;
    document.getElementById('selected_quantity').value = quantity;

    updatePrice(quantity);
});

document.getElementById('decrement').addEventListener('click', function() {
    let quantity = document.getElementById('selected_quantity').value;
    if (quantity > 1) {
        quantity--;
        document.getElementById('selected_quantity').value = quantity;
    }

    updatePrice(quantity);
});

function updatePrice(quantity) {
    // Fetch the base price from the hidden element
    let basePrice = <?php echo $res['price']; ?>;
    let totalPrice = basePrice * quantity;

    // Update the price displayed on the page
    document.getElementById('price').innerText = totalPrice.toFixed(2);
}
</script>

    <script src="./Display/Js/js-quantity.js"></script>
    <script type="text/javascript">

document.querySelectorAll('input[name="productsize_id"]').forEach(input => {
    input.addEventListener('change', () => {
        console.log(`Selected product: ${input.value}`);
    });
});
      let thumbnails = document.getElementsByClassName('thumbnail');
      let activeImage = document.getElementsByClassName('active');
      const colorRadios = document.querySelectorAll('.color-radio');
      const featuredImage = document.getElementById('featured');


    
      for (var i = 0; i < thumbnails.length; i++) {
        console.log(activeImage)
        thumbnails[i].addEventListener('mouseover', function() {
          /*
          if(activeImage.length>0){
              activeImage[0].classlist.remove('active');
          }
          */
          this.classList.add('active')
          document.getElementById('featured').src = this.src
        });

      }
      let buttonRight = document.getElementById('slide_right');
      let buttonLeft = document.getElementById('slide_left');
      buttonLeft.addEventListener('click', function() {
        document.getElementById('slider').scrollLeft -= 180
      });
      buttonRight.addEventListener('click', function() {
        document.getElementById('slider').scrollLeft += 180
      });

      var minus = document.querySelector(".btn-subtract")
      var add = document.querySelector(".btn-add");
      var quantityNumber = document.querySelector(".item-quantity");
      var currentValue = 1;

      minus.addEventListener("click", function() {
        currentValue -= 1;
        quantityNumber.value = currentValue;
        console.log(currentValue)
      });

      add.addEventListener("click", function() {
        currentValue += 1;
        quantityNumber.value = currentValue;
        console.log(currentValue);
      });
      $(function() {
        $(".zoom,  .xzoom-gallery").xzoom({
          zoomWidth: 400,
          tint: "#333",
          XOffset: 15,
        })
      })

      colorRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const selectedColorId = this.value;
                    thumbnails.forEach(thumbnail => {
                        if (thumbnail.getAttribute('data-color-id') == selectedColorId) {
                            thumbnail.style.display = 'inline-block';
                        } else {
                            thumbnail.style.display = 'none';
                        }
                    });
                });
            });


          
</script>
      
    </script>

    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>

  </html>

  <?php
  include './layouts-c/footer-c.php';

  ?>