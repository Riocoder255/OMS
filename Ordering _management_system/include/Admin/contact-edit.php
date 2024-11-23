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
                        Edit contact
                </h6>
            </div>
            <div class="card-body">

            <?php
            $paramResult =checkParamId('id');
            if(!is_numeric($paramResult)){
                echo  '<h5>'.$paramResult.'</h5>';
                return false;
            }
            $cat = getById(' contact_user',checkParamId('id'));
            if($cat['status'] == 200){
                ?>
                   <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                   <form action="./contact-form.php" method="POST" enctype="multipart/form-data">
                   
                
                    <input type="hidden" name="cat_id"class="form-control" value="<?= $cat ['data']['id']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                
                    <input type="text" name="f_name"class="form-control" value="<?= $cat ['data']['firstname']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                
                    <input type="text" name="l_name"class="form-control" value="<?= $cat ['data']['Lastname']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    
                
                    <input type="text" name="address"class="form-control" value="<?= $cat ['data']['address']; ?>">
                </div>

                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                  
                
                  <input type="text" name="email"class="form-control" value="<?= $cat ['data']['email']; ?>">
              </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                  
                
                    <input type="text" name="phone"class="form-control" value="<?= $cat ['data']['phone']; ?>">
                </div>
                <div class="form-group mb-3" style="width: 50%; margin-top:4%;">
                    
                
                    <input type="date" name="created"class="form-control" value="<?= $cat ['data']['created']; ?>">
                </div>


                <div class="form-group mb-2">
                <label for="">status</label>
                <br>
                 <input type="checkbox" name="is_ban" id="" style="width:30px; height:30px;">
</div>
            </div>
         
                    <a href="category.php"><BUtton  class="btn btn-secondary">CLOSE</BUtton></a>
                <button type="submit"name="update_conntact" class="btn btn-primary ">Update</button>
               

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