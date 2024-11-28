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
                <h1 class="modal-title fs-5" id="categoryModalLabel">Add Branch</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="branch-form.php" method="POST" enctype="multipart/form-data">
                    
                       <div class="row">
                        <div class="col">
                            <label for="">Name Branch</label>
                        <input type="text" class="form-control"  name="branch_name">
                        </div>
                        <div class="col">
                            <label for="">Map image</label>
                            <input type="file" class="form-control" name="map_image">
                        </div>
                       </div>
                   
                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="cate_btn">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="container-sm " style="margin-top:100px;width:45%;margin-left:20%; ">
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Branch</h6>
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
            <th>Branch </th>
            <th>Map </th>
            <th>Edit</th>
            <th>Delete</th>
            

        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $cat = getAll('branch');
        if (mysqli_num_rows($cat) > 0) {

            foreach ($cat as $catItem) {
        ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $catItem ['Branch_name'];?></td>
                    <td>
                    <img src="design_upload/<?= htmlspecialchars($catItem['map_image']); ?>" alt="Branch Image" style="width:100px; height:auto;">
            </td>


                    <td> <a href="branch-edit.php?id=<?=$catItem['id'];?>"><i class="  fas fa-edit btn btn-outline-primary"></i></a></td>
                  <td> <a href="branch-delete.php?id=<?= $catItem['id'];?>"onclick="return confirm('Are you sure you want to delete this data?')"><i class="  fas fa-trash btn btn-outline-warning"></i></a></td>
                    
                    
                    

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