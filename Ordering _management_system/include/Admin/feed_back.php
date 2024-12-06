<?php 
include './layouts-c/header-c.php';
include './layouts-c/navbar-c.php';
include './admin_connect.php'; // Connection to the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: center; margin-top: 5px; }
        .star-rating input[type="radio"] { display: none; }
        .star-rating label { font-size: 2rem; color: #ccc; cursor: pointer; }
        .star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color: #f5c518; }
        #imagePreview { display: flex; gap: 10px; margin-top: 10px; }
        #imagePreview img { max-width: 100px; max-height: 100px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <form id="feedbackForm" class="p-4 border rounded shadow-sm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <div class="star-rating" id="starRating">
                    <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 stars">★</label>
                    <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars">★</label>
                    <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars">★</label>
                    <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars">★</label>
                    <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star">★</label>
                </div>
                <p id="ratingDisplay" class="text-center mt-2">Selected Rating: <span id="selectedRating">None</span></p>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Enter your feedback"></textarea>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Upload Images (Optional)</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                <div id="imagePreview"  type="hidden"></div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const feedbackForm = document.getElementById('feedbackForm');
            const starRating = document.getElementById('starRating');
            const ratingDisplay = document.getElementById('selectedRating');
            const imageInput = document.getElementById('images');
            const imagePreview = document.getElementById('imagePreview');

            starRating.addEventListener('change', (event) => {
                if (event.target.name === 'rating') {
                    ratingDisplay.textContent = event.target.value;
                }
            });

            imageInput.addEventListener('change', () => {
                imagePreview.innerHTML = ''; // Clear previous previews
                const files = imageInput.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        imagePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });

            feedbackForm.addEventListener('submit', (event) => {
                event.preventDefault();
                const formData = new FormData(feedbackForm);
                fetch('./feedback_controller.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Feedback Submitted', text: 'Thank you for your feedback!' });
                        feedbackForm.reset(); // Clear the form
                    } else {
                        alert('Failed to submit feedback: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    </script>
</body>
</html>
