<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';



require_once "admin_connect.php";



?>

<!----read modal---->







      

    <div class="container " style="margin-top:100px;">

        <div class="row justify-content-center">
            <div class="col-md-10">


                <div class="card">

                    <div class="card-header">
                        <h6 class="mb-0 weght-bold text-primary">Manage User /admin</h6>
                      <a href="./insert_admin.php" class="btn btn-outline-primary btn-sm float-end">Insert User</a>
                    </div>
                    <div class="card-body">
                    <?= alertmessage();
                        alertme();
                        ?>
                        <div class="responsive-table">



                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                           
                                            <th>avatar</th>
                                        <th>firstname</th>
                                        <th>Lastname</th>
                                        <th>Username</th>
                                        <th>Phone</th>
                                        <th>Assigned branch</th>
                                        <th>Roles</th>
                                        <th>Created_at</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>delete</th>

                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $query = "SELECT u.*, b.branch_name
                                  FROM user_form u
                                  LEFT JOIN branch b ON u.branch_id = b.id";
                        
                        // Execute the query
                        $result = mysqli_query($conn, $query);
                        $count=1;
                        
                        // Check if there are results
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through the results
                            while ($userItem = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?= $count ?></td>
                                    <td><img src="Uploads/<?= $userItem['image'] ?>" width="70px;" height="70px;" alt="Image"></td>
                                    <td><?= $userItem['fname'] ?></td>
                                    <td><?= $userItem['lname'] ?></td>
                                    <td><?= $userItem['uname'] ?></td>
                                    <td><?= $userItem['phone'] ?></td>
                                    <td><?= $userItem['branch_name'] ?></td> <!-- Display the branch name -->
                                    <td><?= $userItem['roles_as'] ?></td>
                                    <td><?= $userItem['created'] ?></td>
                                    <td><?= $userItem['is_ban'] == 1 ? '<p class="btn btn-danger btn-sm">Banned</p>' : '<p class="btn btn-success btn-sm">Active</p>' ?></td>
                                  
                                    <td><a href="edit_admin.php?id=<?= $userItem['id'] ?>"><i class="fas fa-edit btn btn-outline-primary"></i></a></td>
                                    <td><a href="user-delete.php?id=<?= $userItem['id'] ?>" onclick="return confirm('Are you sure you want to delete this data?')"><i class="fas fa-trash btn btn-outline-warning"></i></a></td>
                                </tr>
                                <?php
                                $count++;
                            }
                        } else {
                            echo "No users found.";
                        }
                        
                        // Close the database co



?>
                                  


                                </tbody>
                            </table>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<?php

include("./layouts/footer.php");

include("./layouts/scripts.php");

?>