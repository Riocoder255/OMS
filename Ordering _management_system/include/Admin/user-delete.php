<?php

require 'function.php';

$paramResult =checkParamId('id');
if(is_numeric($paramResult)){
    $user_id = validated($paramResult);
    
    $user =getById('user_form',$user_id);
    if($user['status'] == 200){

        $userDeleteRes =  deleteQuery('user_form',$user_id);
        if($userDeleteRes){
            redirect('admin.php','admin/user is deleted successfully');


        }else{
            redirect('admin.php','something went wrong');

        }

    }else{
        redirect('admin.php',$user);
    }

}else{
    redirect('admin.php',$paramResult);

}


?>