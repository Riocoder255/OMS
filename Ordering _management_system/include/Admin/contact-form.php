<?php
include './function.php';
include_once './admin_connect.php';

if(isset($_POST['contact_btn'])){
    $f_name = validated($_POST['f_name']);
    $l_name = validated($_POST['l_name']);
    $address = validated($_POST['address']);
    $mail = validated($_POST['mail']);
    $num = validated($_POST['num']);
    $is_ban = validated($_POST['is_ban']) == true ? 1 : 0;




    


    if(empty($f_name)){
        direct('contact.php',"Category tile can't be blank");
    
    
    }else
        $query1= "SELECT * FROM contact_user WHERE email = '$email'";
        $result1=mysqli_query($conn,$query1);
        if(mysqli_num_rows($result1) > 0){
            redirect('contact.php',"Category is already exist try another");


        
        }
        
    else{
        $query ="INSERT INTO  contact_user(	
            
            Lastname,
            firstname,
            address,
            email,
            phone,
            status)VALUES('$f_name','$l_name','$address','$mail','$num','$is_ban')";
        $result= mysqli_query($conn,$query);

        if($result){
            redirect('contact.php',"Add Contact is successfully");
        }else{
            direct('contact.php','missing information');
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


    


    if(isset($_POST['update_conntact'])){
        $f_name =validated($_POST['f_name']);
        $l_name =validated($_POST['l_name']);
        $address =validated($_POST['address']);
        $email =validated($_POST['email']);

        $phone =validated($_POST['phone']);
        $created =validated($_POST['created']);



        $is_ban = validated($_POST['is_ban']) == true ? 1 : 0;




        $cat_id = validated($_POST['cat_id']);
        $cat = getById('contact_user', $cat_id);
        if($cat['status']!=200){
            redirect('edit_admin.php?id='.$cat_id,'No such id  found');
        }

        if($f_name != '' ||$l_name!=''||$address!=''||$email!=''){
            $query ="UPDATE contact_user
            SET firstname ='$f_name',Lastname='$l_name',address='$address',email='$email',phone='$phone
            ',status='$is_ban',created='$created' WHERE id ='$cat_id'";
            $result =mysqli_query($conn,$query);
            if($result){
                redirect('contact.php',"Update contact is successfully");


            }else{
                redirect('edit_admin.php','missing information');

            }

        }


    }


?>