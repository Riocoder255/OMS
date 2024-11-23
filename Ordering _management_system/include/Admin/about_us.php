<?php
include ('./layouts/header.php');
include ('./layouts/sidebar.php');

include ('./layouts/topbar.php');


require_once "admin_connect.php";
?>




<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoryModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="about_form.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder=" title" name="title_name">
                    </div>
                    <div class="form- m-2">
                    <label for="floatingTextarea2">Comments</label>
                    <textarea class="form-control" id="floatingTextarea2" style="height: 100px" name="about_name"></textarea>
       
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="about_btn">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="container-sm " style="margin-top:100px;width:50%;margin-left:20%; ">
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">About us</h6>
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
            <th>Title</th>
            <th>Content</th>

            <th>Edit</th>
            <th>Delete</th>
            

        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $cat = getAll(' About_us');
        if (mysqli_num_rows($cat) > 0) {

            foreach ($cat as $catItem) {
        ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $catItem ['Title'];?></td>

                    <td><?= $catItem ['content'];?></td>
                    <td> <a href="category-edit.php?id=<?=$catItem['id'];?>"><i class="  fas fa-edit btn btn-outline-primary"></i></a></td>
                  <td> <a href="cat-delete.php?id=<?= $catItem['id'];?>"onclick="return confirm('Are you sure you want to delete this data?')"><i class="  fas fa-trash btn btn-outline-warning"></i></a></td>
                    
                    
                    

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