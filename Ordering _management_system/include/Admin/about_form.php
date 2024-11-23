<?php
include './function.php';
include_once './admin_connect.php';

if(isset($_POST['about_btn'])){
    $title_name = validated($_POST['title_name']);
    $about_name= validated($_POST['about_name']);


    if(empty($title_name)){
        direct('about_us.php'," title can't be blank");
     } else if(empty($about_name)){
            direct('about_us.php'," content can't be blank");
    
    }else
        $query1= "SELECT * FROM  about_us WHERE Title = '$title_name'";
        $result1=mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1) > 0){
            redirect('about_ud.php'," title is already exist try another");


        
        }
        
    else{
        $query ="INSERT INTO  about_us(	Title,content)VALUES('$title_name','$about_name')";
        $result= mysqli_query($conn,$query);

        if($result){
            redirect('about_us.php',"Add about us is successfully");
        }else{
            direct('about_us.php','missing information');
        }
    }}
   

    if(isset($_POST['update_cat'])){
        $cat_name =validated($_POST['cat_name']);

        $cat_id = validated($_POST['cat_id']);
        $cat = getById('category', $cat_id);
        if($cat['status']!=200){
            redirect('edit_admin.php?id='.$cat_id,'No such id  found');
        }

        if($cat_name != ''){
            $query ="UPDATE  sub_category SET cat_name ='$cat_name' WHERE id ='$cat_id'";
            $result =mysqli_query($conn,$query);
            if($result){
                redirect('category.php',"Update category is successfully");


            }else{
                redirect('edit_admin.php','missing information');

            }

        }


    }


    




?>