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
                        Edit Size
                </h6>
            </div>
            <div class="card-body">

            <?php
            $paramResult =checkParamId('id');
            if(!is_numeric($paramResult)){
                echo  '<h5>'.$paramResult.'</h5>';
                return false;
            }
            $cat = getById(' sizing',checkParamId('id'));
            if($cat['status'] == 200){
                ?>
                   <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                   <form action="size-form.php" method="POST" enctype="multipart/form-data">
                   
                
                    <input type="hidden" name="size_id"class="form-control" value="<?= $cat ['data']['id']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    <label for="">Size</label>
                
                    <input type="text" name="Size"class="form-control" value="<?= $cat ['data']['Size']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    <label for="">Matric number</label>
                
                    <input type="text" name="matric"class="form-control" value="<?= $cat ['data']['matric']; ?>">
                </div>
                
            </div>
         
                <button type="submit"name="update_size" class="btn btn-primary ">Update</button>
               

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