<?php
include './layouts/header.php';
include './layouts/sidebar.php';
include './layouts/topbar.php';
include './admin_connect.php';
?>
<style>
   
</style>
<div class="container md-6">
    <div class="card-body">
    <?= alertmessage();
                        alertme();
                        ?>
        <div class="card-header">
            <h6 class=" text-bold text-dark">Insert Admin / User</h6>
        </div>
        <div class="card-body">
       <form action="./admin-form.php" method="post" enctype="multipart/form-data">
       <div class="row">
                    <div class="col">
                        <label for="" class="text-dark">Firstname</label>
                        <input type="text" class="form-control" aria-label="First name"  name="fname">
                    </div>
                    <div class="col">
                    <label for=""class="text-darkt">Lastname</label>
                        <input type="text" class="form-control"aria-label="First name" name="lname">
                    </div>
                   
                    </div>
                    
                    
        <div class="row">
            <div class="col">
                <label for=""class="text-dark"><i class=" fas fa-phone"> </i>Phone Number</label>
                        <input type="text" class="form-control"aria-label="First name" name="phone">
            </div>
        <div class="col">
            <label for=""class="text-dark">Assigned Branch</label>
            <select class="form-select" name="branch_id" required>
                            <option value="">------Select Branch------</option>
                            <?php
                            $query = "SELECT * FROM branch";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_array($query_run)) {
                                    echo "<option value='{$row['id']}'>{$row['Branch_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
        </div>
                    
       
      

        
        <div class="row">
        <div class="col">
            <label for=""class="text-dark">Select Roles</label>
            <select name="roles_as" class="form-select">
                            <option value="">Select Role</option>
                            <option value="admin">admin</option>        
                            <option value="user">user</option>
                        </select>
                    </div>
        <div class="col">
            <label for=""class="text-dark"><i class="fas fa-user"></i>profile</label>
                    <input type="file" class="form-control" name="image">

                   
        </div>

        
    </div>


    <div class="row">
                    <div class="col">
                    <label for=""class="text-dark"><i class="fas fa-envelope"></i> Email</label>

                        <input type="text" class="form-control" aria-label="First name" name="uname">
                    </div>
                    <div class="col">
                    <label for=""class="text-dark"><i class=" fas fa-key"></i> Password</label>

                        <input type="text" class="form-control" aria-label="First name" name="password">
                    </div>
                    </div>
                  
        </div>

   <div class="form-group " style="text-align:center; margin-top: 110px;">
   <button class="btn btn-primary " type="submit"  name="save_data">Save</button>
   <a href="./admin.php"class="btn btn-secondary">Back</a>
   </div>
       </form>

</div>


<?php 
include './layouts/footer.php';
include './layouts/scripts.php';
?>