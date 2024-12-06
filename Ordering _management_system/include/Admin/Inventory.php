
    <?php
    include "./layouts/header.php";

    require 'layouts/sidebar.php';
    require 'layouts/topbar.php';
    require './admin_connect.php';






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./Display/css/virtual-select.min.css">
    <style>
        #multipleSelect {
            max-width: 100%;
            width: 350px;
        }
        .vscomp-toggle-button {
            padding: 10px 30px 10px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

                <div class="card-body" style="margin-top: 10%;">
                    <?php
                    alertmessage();
                    alertme();
                    ?>
                    <div class="c">
                         <input type="search" placeholder="search">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  
                                    <th>Customer_id</th>
                                    <th>Customer_name</th>
                                    <th>Order_type</th>

                                    <th>Order_list</th>
                                    
                                    <th>Recieve_log</th>
                                    <th>Branch </th>
                                    <th>Total</th>
                                    <th>Date_ordered</th>
                                    <th>Date_finish </th>
                                    <th>Payment_history </th>
                                    
                                  
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./Display/Js/virtual-select.js"></script>
</body>
</html>

<?php
include "./layouts/footer.php";
include "./layouts/scripts.php";
?>

