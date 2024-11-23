<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';

require_once "admin_connect.php";



?>


<div class="container " style="margin-top:100px;">

<div class="row justify-content-center">
    <div class="col-md-9">


        <div class="card">

            <div class="card-header">
                <h6 class="mb-0 weght-bold text-primary">Manage Customer</h6>
                
            </div>
            <div class="card-body">
            
                <div class="responsive-table">



                    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                             <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Created</th>
                                
                                

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $cus = getAll('customer');
                            if (mysqli_num_rows($cus) > 0) {

                                foreach ($cus as $cusItem) {
                            ?>
                                    <tr>
                                        <td><?= $count ?></td>

                                        <td><?= $cusItem['name'] ?></td>
                                        <td><?= $cusItem['lname'] ?></td>
                                        <td><?= $cusItem['email'] ?></td>
                                        <td><?= $cusItem['created'] ?></td>
                                        
                                        

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
</div>


<?php

include("./layouts/footer.php");

include("./layouts/scripts.php");

?>
