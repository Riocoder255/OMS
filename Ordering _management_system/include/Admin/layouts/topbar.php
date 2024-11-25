<?php 

if (!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'admin') {
    $_SESSION['message'] = "You are not authorized as ADMIN";
    header('Location: login.php');
    exit(0);
}

// Fetch the admin's current data from the database
$user_id = $_SESSION['auth_user']['user_id'];
$query = "SELECT * FROM user_form WHERE id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_array($result);
} else {
    $_SESSION['message'] = "User not found.";
    header('Location: index.php');
    exit(0);
}
?>


<!-- Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="edit-profile.php" method="post" enctype="multipart/form-data">
          <div class="form-group mb-2">
            <label for="fname">First Name</label>
            <input type="text" class="form-control" name="fname" value="<?= $user['fname']; ?>" required>
          </div>
          <div class="form-group mb-2">
            <label for="lname">Last Name</label>
            <input type="text" class="form-control" name="lname" value="<?= $user['lname']; ?>" required>
          </div>
          
          <div class="form-group mb-2">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $user['email']; ?>" required>
          </div>
          <div class="form-group mb-2">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter new password" required>
          </div>
          <div class="form-group mb-2">
            <label for="image">Profile Image</label>
            <input type="file" class="form-control" name="image">
            <input type="hidden" name="image_old" value="<?= $user['image']; ?>">
            <img src="<?= "Uploads/" . $user['image']; ?>" alt="Profile Image" width="100px" style="border-radius:50%;">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="update_profile" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if(isset($_SESSION['auth_user'])):?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="Uploads/<?=  $_SESSION['auth_user']['user_image']; ?>" alt="Admin Image" style="wdith:30px; height:30px; border-radius:20px;">
                                </i><?= $_SESSION['auth_user']['user_name']?>
                                        <?php else : ?>
                                    <?php endif;?>

                            </a>


                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editProfileModal">
  Edit Profile
</button></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <form action="allcode.php" method="POST" enctype="multipart/form-data">
                                        <button  type="submit"name="Logout_btn" class="dropdown-item">Logout</button>
                                    </form>
                            
                            
                            </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
           
            <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
           