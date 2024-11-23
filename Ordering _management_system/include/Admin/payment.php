<?php
require "layouts/header.php";
require 'layouts/sidebar.php';
require 'layouts/topbar.php';



require_once "admin_connect.php";



?>

<div class="modal fade" id="InsertUser" tabindex="-1" aria-labelledby="InsertUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="InsertUserLabel">Add payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="width: 90%; height:10%;">
                <form action="payment-form.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter Payment" name="payment">
                    </div>
                   


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="save_payment">Save Data</button>
            </div>
            </form>
        </div>
    </div>
</div>

    <div class="container " style="margin-top:100px;">

        <div class="row justify-content-center">
            <div class="col-md-10">


                <div class="card">

                    <div class="card-header">
                        <h6 class="mb-0 weght-bold text-primary">View Payment </h6>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#InsertUser">
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
                                        <th>Payment</th>

                                       
                                        <th>Created_at</th>
                                        <th>Edit</th>
                                        <th>delete</th>

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
                                               
                                                <td> <a href="payment-edit.php?id=<?=$userItem['id'];?>"><i class="  fas fa-edit btn btn-outline-primary"></i></a></td>
                                                <td> <a href="payment-delete.php?id=<?= $userItem['id'];?>"onclick="return confirm('Are you sure you want to delete this data?')"><i class="  fas fa-trash btn btn-outline-warning"></i></a></td>
                                                

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