<?php
include './function.php';
include_once './admin_connect.php';

if(isset($_POST['cate_btn'])){
    $cat_title = validated($_POST['branch_name']);


    $map_image = $_FILES['map_image']['name'];
    $target_dir = "design_upload/"; // Directory to store uploaded files
    $target_file = $target_dir . basename($map_image);

    if (move_uploaded_file($_FILES['map_image']['tmp_name'], $target_file)) {
        // Ins
    }
    if(empty($cat_title)){
        direct('branch.php',"Branch can't be blank");
    
    
    }else
        $query1= "SELECT * FROM  branch WHERE Branch_name = '$cat_title'";
        $result1=mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1) > 0){
            redirect('branch.php',"Branch is already exist try another");


        
        }
        
    else{
        $query ="INSERT INTO   branch(Branch_name,map_image)VALUES('$cat_title','$map_image')";
        $result= mysqli_query($conn,$query);

        if($result){
            redirect('branch.php',"Add branch is successfully");
        }else{
            direct('branch.php','missing information');
        }
    }}
   

    if(isset($_POST['update_branch'])){
        $cat_name =validated($_POST['branch_name']);

        $cat_id = validated($_POST['branch_id']);
        $cat = getById(' branch', $cat_id);
        if($cat['status']!=200){
            redirect('branch-edit?id='.$cat_id,'No such id  found');
        }

        if($cat_name != ''){
            $query ="UPDATE  branch SET Branch_name ='$cat_name' WHERE id ='$cat_id'";
            $result =mysqli_query($conn,$query);
            if($result){
                redirect('branch.php',"Update category is successfully");


            }else{
                redirect('branch-edit.php','missing information');

            }

        
    }

    }


    




?>