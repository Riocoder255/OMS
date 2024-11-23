<?php
include './function.php';
include_once './admin_connect.php';

if(isset($_POST['size_btn'])){
    $size_name= validated($_POST['size_name']);
    $size_matric= validated($_POST['matric_size']);


    if(empty($size_name)){
        direct('size.php',"Size  can't be blank");
    }
        else if(empty($size_matric)){
            direct('size.php',"matric number can't be blank");
        
    
    }else
        $query1= "SELECT * FROM sizing WHERE Size = '$size_name'";
        $result1=mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1) > 0){
            redirect('size.php',"Size is already exists try another");


        
        }
        
    else{
        $query ="INSERT INTO sizing(Size,matric)VALUES('$size_name','$size_matric')";
        $result= mysqli_query($conn,$query);

        if($result){
            redirect('size.php',"Add Sizing is successfully");
        }else{
            direct('size.php','missing information');
        }
    }}
   

    if(isset($_POST['update_size'])){

            $Size =validated($_POST['Size']);
            $matric=validated($_POST['matric']);

    
            $size_id = validated($_POST['size_id']);
            $size = getById(' sizing', $size_id);
            if($size['status']!=200){
                redirect('edit-size.php?id='.$size_id,'No such id  found');
            }
    
            if($size != '' || $matric!=''){
                $query ="UPDATE  sizing SET Size ='$Size' , matric ='$matric' WHERE id ='$size_id'";
                $result =mysqli_query($conn,$query);
                if($result){
                    redirect('size.php',"Update category is successfully");
    
    
                }else{
                    redirect('edit-size.php','missing information');
    
                }
    
            }
    
    
        }
