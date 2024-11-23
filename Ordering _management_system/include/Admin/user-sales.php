<?php

require "user_layouts/header.php";
require 'user_layouts/sidebar.php';
require 'user_layouts/topbar.php';

require_once "admin_connect.php";
?>




<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="categoryModalLabel">Add category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="category-form.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="category title" name="cat_name">
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
<div class="container-sm " style="margin-top:100px;width:80%; ">
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Sales</h6>
            <br>
           
             <a href="" class="fas fa-print btn btn-outline-success" ></a>

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
            <th>Customers</th>
            <th>Sale_date</th>
            <th>total_amount</th>


         
            

        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $cat = getAll('category');
        if (mysqli_num_rows($cat) > 0) {

            foreach ($cat as $catItem) {
        ?>
               



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

include("./user_layouts/footer.php");

include("./user_layouts/scripts.php");

?>