  <?php
  include './layouts-c/header-c.php';
  include './layouts-c/navbar-c.php';
  include './admin_connect.php';



if (isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'];

  // Join query to fetch product details along with sizes and concatenated images
  $qry = mysqli_query($conn, "
  SELECT pp.product_id, pp.product_name, pp.cover, pp.price, pp.product_sale, ps.size_id, s.Size, ps.color_id, c.color_name, ps.images
  FROM product_price pp
  JOIN product_size ps ON pp.product_id = ps.product_id
  JOIN sizing s ON ps.size_id = s.id
  JOIN colors c ON ps.color_id = c.id
  WHERE pp.product_id = '$product_id'
  ");

  $product_details = [];
  $sizes = [];
  $unique_sizes = [];
  $colors = [];
  $unique_colors = [];
  $unique_images = [];

  while ($row = mysqli_fetch_assoc($qry)) {
      $product_details[] = $row;
      if (!in_array($row['size_id'], $unique_sizes)) {
          $unique_sizes[] = $row['size_id'];
          $sizes[] = $row;
      }
   
      // Process images and ensure uniqueness
      $images = explode(',', $row['images']);
      foreach ($images as $image) {
          if (!in_array($image, $unique_images)) {
              $unique_images[] = $image;
          }
      }
  }

  // Fetch product details separately for display
  $product_qry = mysqli_query($conn, "SELECT * FROM product_price WHERE product_id = '$product_id'");
  $res = mysqli_fetch_assoc($product_qry);
}
?>

 

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <style>
    .size {
      width: 14%;

      position: absolute;
    }

    #ImgDl .modal-header {
      padding: 0;

    }

    #ImgDl .modal-body {
      padding: 0;
    }

    #imgDl .modal-header .close {
      position: absolute;
    }

    #imgDl .modal-body .img-fluid {
      border-radius: 5px;
      width: 100px;
    }

    .button {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-left: 50%;

    }

    .buy {
      margin-left: 10px;
    }

    .quantity {
      width: 140px;
      margin-left: 210%;
      margin-top: 20px;
    }

    .size-chart {
      margin-left: 55%;
      border: 1px solid lightgray;
      width: 100px;

    }

    .size-chart a {
      color: black;
      text-decoration: none;
    }


    .wrapper-1 {
      width: 500px;
      margin-top: -120px;


    }

    .wrapper-1 .title h4 {
      font-size: 24px;
      color: #000;
      font-weight: 700;
      text-align: center;
      margin-left: -70%;
      margin-top: 140px;
    }

    .container {
      padding-left: 10px;



    }

    .container .option_item {

      display: flex;
      position: relative;
      width: 150px;
      height: 30px;
      margin: 10px;


    }

    .container .option_item .checkbox {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
      opacity: 0;

    }

    .option_item .option_inner {
      width: 149px;
      height: 40px;
      background: #fff;
      border-radius: 5px;
      text-align: center;
      cursor: pointer;
      color: #585c68;
      display: block;
      margin-left: -215px;
      margin-top: -20px;
      border: 1px solid black;
      position: relative;
    }

    .option_item .option_inner .icon {
      margin-bottom: 10px;
    }

    .option_item .option_inner .icon img {
      width: 25px;
      margin-top: 5px;
      margin-left: -40px;
    }


    .option_item .option_inner .name {
      user-select: none;
      font-size: 10px;

      margin-left: 55px;
      margin-top: -44px;

    }

    .option_item .checkbox:checked~.option_inner.facebook {
      border-color: #3b5999;
      color: #3b5999;
    }

    .option_item .checkbox:checked~.option_inner.twitter {
      border-color: #55acee;
      color: #55acee;
    }

    .option_item .checkbox:checked~.option_inner.instagram {
      border-color: #e4405f;
      color: #e4405f;
    }

    .option_item .checkbox:checked~.option_inner.linkedin {
      border-color: #0077b5;
      color: #0077b5;
    }

    .option_item .checkbox:checked~.option_inner.whatsapp {
      border-color: #25d366;
      color: #25d366;
    }

    .option_item .checkbox:checked~.option_inner.google {
      border-color: #dd4b39;
      color: #dd4b39;
    }

    .option_item .checkbox:checked~.option_inner.reddit {
      border-color: #ff5700;
      color: #ff5700;
    }

    .option_item .checkbox:checked~.option_inner.quora {
      border-color: #b92b27;
      color: #b92b27;
    }

    .option_item .option_inner .tickmark {
      position: absolute;
      top: 0;
      left: 0;
      border: 20px solid;
      border-color: #000 transparent transparent #000;
      display: none;
    }

    .option_item .option_inner .tickmark:before {
      content: "";
      position: absolute;
      top: -18px;
      left: -18px;
      width: 15px;
      height: 5px;
      border: 3px solid;
      border-color: transparent transparent #fff #fff;
      transform: rotate(-45deg);
    }

    .option_item .checkbox:checked~.option_inner .tickmark {
      display: block;
    }

    .option_item .option_inner.facebook .tickmark {
      border-color: #3b5999 transparent transparent #3b5999;
    }


    .thumbnail {
      object-fit: cover;
      max-width: 100px;
      max-height: 100px;
      cursor: pointer;
      margin-left: 15px;
      opacity: 0.5;
      margin: 5px;

    }

    .thumbnail:hover {
      opacity: 1;
      border: 1px solid black;
    }

    .active {
      opacity: 1;

    }

    #slide-wrapper {
      max-width: 500px;
      display: flex;
      min-height: 100px;
      align-items: center;
    }

    #slider {
      width: 440px;
      display: flex;
      flex-wrap: nowrap;
      overflow-x: hidden;
    }


    .card-2 {
      width: 900px;
      height: 900px;
      border: 1px solid lightgray;
      box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
      margin: 2%;
    }

    .card-2 .image {
      width: 500px;
      object-fit: cover;
      border-radius: 1px;
      border: 1px solid lightgray;
      height: 350px;
      margin-top: 70px;
      margin-left: 20px;
      cursor: pointer;
    }

    .card-2 .image img {
      margin-left: 100px;
      margin-top: 30px;
      height: 80%;
    }

    .card-2 .info {
      margin-left: 65%;
      margin-top: -45%;
      line-height: 30px;
      font-weight: bold;
      font-size: 17px;
      letter-spacing: .1em;




    }

    .front {
      margin-left: 10px;
      color: #0077b5
    }

    .card-2 .info .rate {
      color: gold;
    }

    .sep-rate {
      display: flex;


    }

    .sep-rate .discount {
      font-weight: 300;
    }

    .sep-rate .price {
      font-size: 25px;
      padding-left: 7px;
      object-fit: cover;
      color: red;
    }

    .arrow {
      width: 30px;
      height: 30px;
      cursor: pointer;
      transition: .3s;
    }

    .arrow:hover {
      opacity: .5;
      width: 35px;
      height: 35px;
    }

    .container-1 {
      width: 150px;
      height: 60px;
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      justify-content: center;
      align-items: center;
      border: 1px solid lightgray;
    }

    .container-1 img {
      width: 40px;
      height: 30px;
      margin-left: -70px;
      margin-top: 10px;
    }

    .image-color {
      padding: 10px;
    }
  </style>

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
      <div class="container ">
        <div class="card-2">
          <div class="image">

            <img src="product_upload/<?php echo $res['cover']; ?>" alt="" id="featured" class="">
          </div>
          <div id="slide-wrapper">

            <img src="./product_upload/arrow.jpg" alt="" class="arrow" id="slide_left">
            <div id="slider" style="overflow-x: hidden;">

           <?php foreach ($unique_images as $image): ?>
    <img src="design_upload/<?php echo $image; ?>"
         alt=""
         class="thumbnail"
         data-color-id="<?php echo $color['color_id']; ?>"
         data-image="<?php echo htmlspecialchars($row['images']); ?>">
<?php endforeach; ?>



            </div>
            <img src="./product_upload/left.jpg" alt="" class="arrow" id="slide_right">

          </div>

          <div class="info text-dark">
            <div class="product_name">
              <p><?php echo $res['product_name']; ?> </p>
            </div>
            <div class="rate">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
            <div class="sep-rate">

              <p class="discount"><del> <?php echo$res['product_sale'] ?> </del></p>
              <p class="price"> ₱  <?php  echo $res['price']; ?></p>


            </div>





            <form action="cart-form.php" method="post">

            <input type="hidden" name="product_id" value="<?php echo $res['product_id']; ?>">
    <!-- Include hidden input fields for size_id, color_id, and quantity -->
    <input type="hidden" name="size_id" id="selected_size_id" value="">
    <input type="hidden" name="color_id" id="selected_color_id" value="">
    <input type="hidden" name="quantity" id="selected_quantity" value="1">
              <div class="row">
              <div class="col">
              <p>Select Size:</p>
              <?php foreach ($sizes as $size): ?>
                       
                        <label class="btn btn-outline-success" for="success-outlined">
                        <input type="radio" name="size_id" value="<?php echo $size['size_id']; ?>" requiredclass="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                        
                        <?php echo htmlspecialchars($size['Size']); ?></label>

                        <?php endforeach; ?>
              </div>
        <br>
       
    

              </div>


              
              <div class="row">
              <div class="col">
              
             

            
              </div>
    
       
    

              </div>


          </div>
          
          

          <div class="sub" style="margin-top: 20px;">


            <div class="row">
              <div class="col-md-4">

               <br><br>

                <div class="input-group mb-3 quantity ">
                  <button class="input-group-text  btn-subtract" type="button">-</button>

                  <input type="hidden" name="product_id" value="<?php echo $res['product_id'] ?>">
                  <input type="number" class="form-control item-quantity " id=" quantity" name='quantity'>
                  <button class="input-group-text  btn-add" type="button">+</button>

                </div>
              </div>

            </div>

       
               <div class="button">
              <button type="submit" class="btn btn-secondary btn-xs pull-right"name="action">
                <li class="fa fa-cart-arrow-down"></li> Add To Cart


              </button>
              <button type="submit" class="btn btn-success buy" name="action" value="buy_now">Buy now</button>

            </div>
        </form>
          </div>
        </div>
      </div>
    </div>
    </div>



    <script src="./Display/Js/js-quantity.js"></script>
    <script type="text/javascript">
      let thumbnails = document.getElementsByClassName('thumbnail');
      let activeImage = document.getElementsByClassName('active');
      const colorRadios = document.querySelectorAll('.color-radio');
      const featuredImage = document.getElementById('featured');


      document.addEventListener('DOMContentLoaded', function () {
        const sizeRadios = document.querySelectorAll('.size-radio');
        const colorRadios = document.querySelectorAll('.color-radio');
        const quantityInput = document.getElementById('quantity');
        const selectedSizeIdInput = document.getElementById('selected_size_id');
        const selectedColorIdInput = document.getElementById('selected_color_id');
        const selectedQuantityInput = document.getElementById('selected_quantity');

        // Event listeners for size and color selection
        sizeRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                selectedSizeIdInput.value = this.value;
            });
        });

        colorRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                selectedColorIdInput.value = this.value;
                // Optionally update main product image based on selected color
            });
        });

        // Event listener for quantity input
        quantityInput.addEventListener('change', function () {
            selectedQuantityInput.value = this.value;
        });
    });
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>

  </html>

  <?php
  include './layouts-c/footer-c.php';

  ?>