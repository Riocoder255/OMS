<?php

require "user_layouts/header.php";
require 'user_layouts/sidebar.php';
require 'user_layouts/topbar.php';

require_once "admin_connect.php";
?>





<div class="container-sm " style="margin-top:100px;width:45%;margin-left:20%; ">
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Category</h6>
           


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
            <th>Categery_title</th>
          
            

        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $cat = getAll('category');
        if (mysqli_num_rows($cat) > 0) {

            foreach ($cat as $catItem) {
        ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $catItem ['cat_name'];?></td>
                   
                    
                    

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

include("./user_layouts/footer.php");

include("./user_layouts/scripts.php");

?>