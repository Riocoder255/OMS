<?php
require "user_layouts/header.php";
require 'user_layouts/sidebar.php';
require 'user_layouts/topbar.php';



require_once "admin_connect.php";



?>

    <div class="container " style="margin-top:100px;">

        <div class="row justify-content-center">
            <div class="col-md-10">


                <div class="card">

                    <div class="card-header">
                        <h6 class="mb-0 weght-bold text-primary">View Payment </h6>
                       
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
                                        <th>Payment</th>
                                       
                                        <th>Created_at</th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $users = getAll('payment_method');
                                    if (mysqli_num_rows($users) > 0) {

                                        foreach ($users as $userItem) {
                                    ?>
                                            <tr>
                                                <td><?= $count ?></td>

                                                <td><?= $userItem['payment_name'] ?></td>
                                                <td><?= $userItem['created'] ?></td>
                                               
                                                

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

include("./user_layouts/footer.php");

include("./user_layouts/scripts.php");

?>