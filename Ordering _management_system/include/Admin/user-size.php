<?php

require "./user_layouts/header.php";
require_once "admin_connect.php";
require 'user_layouts/sidebar.php';
require 'user_layouts/topbar.php';
?>



<div class="container-sm " style="margin-top:100px;width:70%;margin-left:20%; ">
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Size</h6>
           

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