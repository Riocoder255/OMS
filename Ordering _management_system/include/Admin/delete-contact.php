<?php


include_once './function.php';



$paramResult =checkParamId('id');
if(is_numeric($paramResult)){
    $cat_id = validated($paramResult);
    
    $cat =getById('contact_user',$cat_id);
    if($cat['status'] == 200){

        $userDeleteRes =  deleteQuery('contact_user',$cat_id);
        if($userDeleteRes){
            redirect('contact.php','contact  is deleted successfully');


        }else{
            redirect('contact.php','something went wrong');

        }

    }else{
        redirect('contact.php',$cat);
    }

}else{
    redirect('contact.php',$paramResult);

}
?>