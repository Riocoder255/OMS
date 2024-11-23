<?php

require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';

require_once "admin_connect.php";
?>




<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoryModalLabel">Add Contact</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./contact-form.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" placeholder="Firstname" name="f_name">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control" placeholder="Lastname" name="l_name">
                    </div>

                    <div class="form-group mb-2">
                        <label for="">Address</label>
                        <br>
                    <textarea name="address" id="" cols="40" ></textarea>
                    </div>
                    
                    <div class="form-group mb-2">
                         <input type="email" placeholder="  email " name="mail" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                         <input type="number" placeholder="  Phone number " name="num" class="form-control">
                    </div>
                    

                    <input type="hidden" name="is_ban" id="" style="width:30px; height:30px;">

                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="contact_btn">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="container-sm " style="margin-top:100px;width:90%;">
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Contact</h6>
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#categoryModal">
                Add
            </button>


        </div>
        <div class="card-body">
            <?= alertmessage();
            alertme();
            ?>
             <div class="responsive-table">



<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>id</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Address</th>
            <th>Email</th>
            <th>Phone</th>
            <th>status</th>
            <th>created</th>

            <th>Edit</th>
            <th>Delete</th>





            

        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $cat = getAll('contact_user');
        if (mysqli_num_rows($cat) > 0) {

            foreach ($cat as $catItem) {
        ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $catItem ['firstname'];?></td>
                    <td><?= $catItem ['Lastname'];?></td>
                    <td><?= $catItem ['address'];?></td>
                    <td><?= $catItem ['email'];?></td>
                    <td><?= $catItem ['phone'];?></td>
                    <td ><?= $catItem['status'] == 1 ?'<p class="btn btn-danger btn-sm">banned</p>':'<p class="btn btn-success btn-sm">Active</p>'; ?></td>


                    <td><?= $catItem ['created'];?></td>




                    <td> <a href="contact-edit.php?id=<?=$catItem['id'];?>"><i class="  fas fa-edit btn btn-outline-primary"></i></a></td>
                  <td> <a href="delete-contact.php?id=<?= $catItem['id'];?>"onclick="return confirm('Are you sure you want to delete this data?')"><i class="  fas fa-trash btn btn-outline-warning"></i></a></td>
                    
                    
                    

                </tr>



            <?php
                $count++;
            }
        } else {
            ?>
            <tr>
                <td colspan="7">No Record Found</td>
            </tr>

        <?php
        }


        ?>


    </tbody>
</table>







        </div>

    </div>
</div>

</div>
</div>

<?php

include("./layouts/footer.php");

include("./layouts/scripts.php");

?>