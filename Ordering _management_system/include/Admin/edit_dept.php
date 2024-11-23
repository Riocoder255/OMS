<?php
include_once './layouts/header.php';

require 'layouts/sidebar.php';
require 'layouts/topbar.php';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-sm" style="padding-left:14%; margin-top:9%; ">
       
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                        Edit category
                </h6>
            </div>
            <div class="card-body">

            <?php
            $paramResult =checkParamId('id');
            if(!is_numeric($paramResult)){
                echo  '<h5>'.$paramResult.'</h5>';
                return false;
            }
            $cat = getById('department',checkParamId('id'));
            if($cat['status'] == 200){
                ?>
                   <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                   <form action="./department-form.php" method="POST" enctype="multipart/form-data">
                   
                
                    <input type="hidden" name="cat_id"class="form-control" value="<?= $cat ['data']['id']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    <label for="">Department</label>
                
                    <input type="text" name="dept_name"class="form-control" value="<?= $cat ['data']['dep_name']; ?>">
                </div>

                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    <label for="">dated</label>
                
                    <input type="date" name="dept_date"class="form-control" value="<?= $cat ['data']['created']; ?>">
                </div>
            </div>
         
                    <a href="category.php"><BUtton  class="btn btn-secondary">CLOSE</BUtton></a>
                <button type="submit"name="update_dept" class="btn btn-primary ">Update</button>
               

                <?php

   }else{
    echo  '<h5>'.$cat['message'].'</h5>';

 }

?>
</form>
        
    </div>
</body>
</html>
<?php
include_once './layouts/scripts.php';
include_once './layouts/footer.php';




?>