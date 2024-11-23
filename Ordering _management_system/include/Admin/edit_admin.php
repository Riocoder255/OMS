<?php
include './layouts/header.php';
include './layouts/sidebar.php';
include './layouts/topbar.php';
include './admin_connect.php';
?>
<div class="container md-6">
    <div class="card-body">
    <?= alertmessage();
                        alertme();
                        ?>
        <div class="card-header">
            <h6 class=" text-bold text-dark">Edit Admin / User</h6>
        </div>
        <div class="card-body">
        <form action="./admin-form.php"  method="post" enctype="multipart/form-data">

       <?php
            $paramResult =checkParamId('id');
            if(!is_numeric($paramResult)){
                echo  '<h5>'.$paramResult.'</h5>';
                return false;
            }
            $user = getById('user_form',checkParamId('id'));
            if($user['status'] == 200){
                ?>
       <div class="row">
                    <div class="col">
                    <input type="hidden"class="form-control" name="user_id" value="<?= $user['data']['id'];?>">

                        <label for="" class="text-dark">Firstname</label>
                        <input type="text"class="form-control" name="fname" value="<?= $user['data']['fname'];?>">

                        
                    </div>
                    <div class="col">
                    <label for=""class="text-dark">Lastname</label>
                    <input type="text"class="form-control" name="lname"value="<?= $user['data']['lname'];?> ">

                    </div>

                    <div class="col">
                    <label for=""class="text-pdark"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text"class="form-control" name="phone"value="<?= $user['data']['phone'];?>">


                    </div>
                   
                  
        </div>
        <br>

        
        <div class="row">
        <div class="col">
            <label for=""class="text-dark">Select Roles</label>
            <select name="roles_as" id="" class="form-select">
                    
                    <option value="admin"<?= $user['data']['roles_as'] == 'admin'  ?  'selected':'';?>>admin</option>
                    <option value="user"<?= $user['data']['roles_as']  ==   'user' ?  'selected':'';?>>user</option>
                </select>
                    </div>

                    <div class="col">
                    <select class="form-select" name="branch_id" required>
                            <option value="">------Select Branch------</option>
                            <?php
                            $query = "SELECT * FROM branch";
                            $query_run = mysqli_query($conn, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_array($query_run)) {
                                    echo "<option value='{$row['id']}'>{$row['Branch_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

      

                    <div class="col">
            
            <label for="" class="text-dark">Profile</label>
    
            <input type="file" name="image" class="form-control">
                 <input type="hidden"name="image_old" value="<?= $user['data']['image'];?>">
                 <img src="<?=   "Uploads/".$user['data']['image']?>" alt=""width="10%" alt="image"style="border-radius:100%;">

                    </div>
                        </div>


                        <div class="row">

                        <div class="col">
            
            <label for="" class="text-dark">Dated</label>
    
    <input type="date" name="dated"value="<?= $user['data']['created'];?>" id="" class="form-control">
    
    
                        </div>
                        <div class="col">
                    <label for=""class="text-dark"><i class="fas fa-user"></i> Username</label>
                    <input type="text"class="form-control" name="uname"value="<?= $user['data']['uname'];?>">


                    </div>
                    <div class="col">
                    <label for=""class="text-dark"><i class=" fas fa-key"></i> Password</label>
                    <input type="password"class="form-control" name="password" value="<?= $user['data']['password'];?>">


                    </div>
                        </div>


<div class="row">  
                        <div class="col">
                        <label for="" class="text-dark">Is_ban</label>
                        <br>

                        <input type="checkbox" name="is_ban"value="<?= $user['data']['is_ban'] == true  ? 'checked':'banned' ;?>" id="" style="width:30px; height:30px;">

                        </div></div>
    
    


        </div>
 <br>
        
    </div>

   <div class="form-group " style="text-align:center">
   <button class="btn btn-success" type="submit"  name="update_data">Update</button>
   <a href="./admin.php"class="btn btn-secondary">Back</a>
   </div>

   <?php

}else{
    echo  '<h5>'.$user['message'].'</h5>';

}   

?>

       </form>

</div>


<?php 
include './layouts/footer.php';
include './layouts/scripts.php';
?>