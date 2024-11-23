<?php  include './layouts-c/header-c.php';
include './layouts-c/navbar-c.php'


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .canvas-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .canvas-container canvas {
            border: 1px solid #000;
            width: 400px;
            height: 400px;
            background-color: #fff;
        }
        .drag-elements img, .drag-elements div {
            width: 100px;
            cursor: pointer;
            margin: 10px;
        }
        .color-picker {
            margin: 10px;
        }
        .tshirt-container {
            position: relative;
            width: 400px;
            height: 400px;
            border: 1px solid #000;
            background: url('tshirt_template.png') no-repeat center center;
            background-size: contain;
        }
        .draggable {
            position: absolute;
            cursor: move;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Customize Your T-shirt</h1>
        
        <!-- Category and Size Selection -->
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category">
                <!-- Populate categories from database -->
            </select>
        </div>
        <div class="form-group">
            <label for="size">Size</label>
            <select class="form-control" id="size">
                <!-- Populate sizes from database -->
            </select>
        </div>
        
        <!-- Color Picker -->
        <div class="form-group color-picker">
            <label for="color">Choose Color</label>
            <input type="color" id="color" class="form-control">
        </div>
        
        <!-- Logo Upload -->
        <div class="form-group">
            <label for="logoUpload">Upload Logo</label>
            <input type="file" id="logoUpload" class="form-control">
        </div>
        
        <!-- Drag Elements -->
        <div class="drag-elements text-center">
            <div draggable="true" id="text" class="draggable" style="background-color: #ddd; padding: 10px;">Drag me</div>
        </div>

        <!-- Canvas Container -->
        <div class="canvas-container">
            <div class="tshirt-container" id="tshirt-container"></div>
        </div>

        <!-- Save Button -->
        <div class="text-center mt-4">
            <button id="save-design" class="btn btn-primary">Save Design</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let tshirtContainer = document.getElementById('tshirt-container');
        let uploadedLogo = null;

        // Load categories and sizes from the server
        $(document).ready(function() {
            $.ajax({
                url: 'load_data.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    data.categories.forEach(category => {
                        $('#category').append(new Option(category.name, category.id));
                    });
                    data.sizes.forEach(size => {
                        $('#size').append(new Option(size.name, size.id));
                    });
                }
            });
        });

        // Handle color picker
        $('#color').on('change', function() {
            tshirtContainer.style.backgroundColor = this.value;
        });

        // Handle logo upload
        $('#logoUpload').on('change', function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                uploadedLogo = new Image();
                uploadedLogo.src = event.target.result;
                uploadedLogo.classList.add('draggable');
                uploadedLogo.style.width = '100px';
                uploadedLogo.style.top = '50px';
                uploadedLogo.style.left = '50px';
                tshirtContainer.appendChild(uploadedLogo);
                makeDraggable(uploadedLogo);
            }
            reader.readAsDataURL(file);
        });

        // Make elements draggable
        function makeDraggable(element) {
            element.addEventListener('mousedown', function(e) {
                let offsetX = e.clientX - parseInt(window.getComputedStyle(element).left);
                let offsetY = e.clientY - parseInt(window.getComputedStyle(element).top);

                function mouseMoveHandler(e) {
                    element.style.top = (e.clientY - offsetY) + 'px';
                    element.style.left = (e.clientX - offsetX) + 'px';
                }

                function reset() {
                    window.removeEventListener('mousemove', mouseMoveHandler);
                    window.removeEventListener('mouseup', reset);
                }

                window.addEventListener('mousemove', mouseMoveHandler);
                window.addEventListener('mouseup', reset);
            });
        }

        document.querySelectorAll('.draggable').forEach(element => {
            makeDraggable(element);
        });

        // Handle saving the design
        $('#save-design').on('click', function() {
            html2canvas(tshirtContainer).then(canvas => {
                const dataURL = canvas.toDataURL('image/png');
                const category = $('#category').val();
                const size = $('#size').val();

                $.ajax({
                    url: 'save_design.php',
                    method: 'POST',
                    data: {
                        image: dataURL,
                        category: category,
                        size: size
                    },
                    success: function(response) {
                        alert(response.message);
                    }
                });
            });
        });
    </script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</body>
</html>



<?php 

include './layouts-c/footer-c.php';


?>