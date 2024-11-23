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
                <h1 class="modal-title fs-5" id="categoryModalLabel">Set Pick Up Date</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="category-form.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <p class="text-primary">Please choose the desired Pick up date</p>
                        <input type="date" class="form-control text-primary" placeholder="category title" name="cat_name">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="cate_btn">Set date</button>
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
                        <h6 class="mb-0 weght-bold text-primary">View Orders</h6>
                      
                    </div>
                    <div class="card-body">
                   
                        <div class="responsive-table">



                            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                            <th>id</th>
                                            <th>Customer</th>
                                            <th>contact</th>
                                            <th>payment_method</th>
                                            <th>order_status</th>
                                            <th>pay_status</th>
                                            <th>status</th>







                                        




                                        

                                    </tr>
                                </thead>
                                <tbody>
                               
                                  <td>1</td>
                                  <td>Java</td>
                                  <td>0909999</td>
                                  <td>g-cash</td>
                                  <td  ><p class="btn btn-danger">pending</p></td>
                                  <td  ><p class="btn btn-success">paid</p></td>

                            <td> <button type="button" class="btn btn-primary  btn-sm" data-bs-toggle="modal" data-bs-target="#categoryModal">
                      pick up date
                     </button>
</td>
                       <td class="text-success">  Reciepe</p></td>
                       <td>  <p style="color: green;">View</p></td>










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