<?php

require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';

require_once "admin_connect.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                <?= alertmessage();?>
                    <h4>Insert Category
                        <a href="javascript:void(0)"class="add-more-form btn btn-primary float-end ">ADD MORE</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="./category-form.php" method="post" enctype="multipart/form-data">

                    <div class="main-form  mt-3 border-bottom">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Category Title</label>
                                    <input type="text" class="form-control" required name="cat_name[]">
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <br>
                                    <button class="remove-btn btn btn-danger ">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="paster-new-form"></div>
                    <br>
                    <button type="submit" class="btn btn-primary" name="cate_btn">Save Data</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<br><br>
<div class="container" >
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Category</h6>
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#categoryModal">
                Add
            </button>


        </div>
        <div class="card-body">
         
           
             <div class="responsive-table">



<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>id</th>
            <th>Categery_title</th>
            <th>Edit</th>
            <th>Delete</th>
            

        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $cat = getAll(' Sub_category');
        if (mysqli_num_rows($cat) > 0) {

            foreach ($cat as $catItem) {
        ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $catItem ['cat_name'];?></td>
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
<script  src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','.remove-btn',function(){
            $(this).closest('.main-form').remove();
        });
        $(document).on('click','.add-more-form',function(){
            $('.paster-new-form').append(' <div class="main-form  mt-3 border-bottom">\
                        <div class="row">\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <label for="">Category Title</label>\
                                    <input type="text" class="form-control" name=[>\
                                </div>\ </div>\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <br>\
                                    <button class="remove-btn btn btn-danger ">Remove</button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>');

        });
    });
</script>
<?php

include("./layouts/footer.php");

include("./layouts/scripts.php");

?>