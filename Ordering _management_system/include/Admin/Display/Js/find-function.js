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

//radio button selected

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
