<?php
include './admin_connect.php';
include  './function.php';


if(isset($_POST['color_btn'])){
    $age_type= validated($_POST['age_type']);

    if(empty($age_type)){
        direct('attribute.php',"Category name can't be blank");
    
    
    }else
        $query1= "SELECT * FROM  category WHERE age_type= '$age_type'";
        $result1=mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1) > 0){
            redirect('attribute.php',"color is already exist try another");


        
        }
        
    else{
        $query ="INSERT INTO  category(age_type)VALUES('$age_type')";
        $result= mysqli_query($conn,$query);

        if($result){
            redirect('attribute.php',"Add  category is successfully");
        }else{
            direct('attribute.php','missing information');
        }
    }}
   

    if(isset($_POST['update_color'])){
        $color_name =validated($_POST['color_name']);

        $cat_id = validated($_POST['cat_id']);
        $cat = getById('category', $cat_id);
        if($cat['status']!=200){
            redirect('color-edit.php?id='.$cat_id,'No such id  found');
        }

        if($color_name != ''){
            $query ="UPDATE category SET age_type ='$color_name' WHERE id ='$cat_id'";
            $result =mysqli_query($conn,$query);
            if($result){
                redirect('attribute.php',"Update Category is successfully");


            }else{
                redirect('color-edit.php','missing information');

            }

        }


    }


    




?>


?>