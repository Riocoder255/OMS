<?php

require "./layouts/header.php";
require_once "admin_connect.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';
?>




<!-- Modal -->
<div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sizeModal">Add Size</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="size-form.php" method="POST" enctype="multipart/form-data">
                    <div class="form- mb-3">
                        <input type="text" class="form-control" placeholder="Size name" name="size_name">
                    </div>
                    <div class="form-group ">
                        <input type="text" class="form-control" placeholder="Metric_size" name="matric_size">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="size_btn">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="container-sm " style="margin-top:100px;width:70%;margin-left:20%; ">
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Size</h6>
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#sizeModal">
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
            <th>Size</th>
            <th>Metric_number</th>

            
            <th>Edit</th>

            <th>Delete</th>
            

        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $size = getAll('sizing');
        if (mysqli_num_rows($size) > 0) {

            foreach ($size as $sizeItem) {
        ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $sizeItem ['Size'];?></td>
                    <td><?= $sizeItem ['matric'];?></td>
                    <td> <a href="edit-size.php?id=<?= $sizeItem['id'];?>"onclick="return confirm('Are you sure you want to edit this data?')"><i class="  fas fa-edit btn btn-outline-success"></i></a></td>


                  <td> <a href="delete-size.php?id=<?= $sizeItem['id'];?>"onclick="return confirm('Are you sure you want to delete this data?')"><i class="  fas fa-trash btn btn-outline-warning"></i></a></td>
                    
                    
                    

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