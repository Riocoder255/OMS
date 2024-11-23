<?php
include './function.php';
include_once './admin_connect.php';

if(isset($_POST['dep_btn'])){
    $dep_name = validated($_POST['dep_name']);

    if(empty($dep_name)){
        direct('department.php',"Department name can't be blank");
    
    
    }else
        $query1= "SELECT * FROM department WHERE dep_name= '$dep_name'";
        $result1=mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1) > 0){
            redirect('category.php',"Department is already exist try another");


        
        }
        
    else{
        $query ="INSERT INTO  department(	dep_name)VALUES('$dep_name')";
        $result= mysqli_query($conn,$query);

        if($result){
            redirect('department.php',"Add department is successfully");
        }else{
            direct('department.php','missing information');
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
            $query ="UPDATE category SET cat_name ='$cat_name' WHERE id ='$cat_id'";
            $result =mysqli_query($conn,$query);
            if($result){
                redirect('category.php',"Update category is successfully");


            }else{
                redirect('edit_admin.php','missing information');

            }

        }


    }


    


    if(isset($_POST['update_dept'])){
        $dept_name =validated($_POST['dept_name']);

        $dept_date =validated($_POST['dept_date']);


        $cat_id = validated($_POST['cat_id']);
        $cat = getById('department', $cat_id);
        if($cat['status']!=200){
            redirect('edit_dept.php?id='.$cat_id,'No such id  found');
        }

        if($dept_name != ''){
            $query ="UPDATE department SET dep_name ='$dept_name',created='$dept_date' WHERE id ='$cat_id'";
            $result =mysqli_query($conn,$query);
            if($result){
                redirect('department.php',"Update  department is successfully");


            }else{
                redirect('edit_admin.php','missing information');

            }

        }


    }



?>