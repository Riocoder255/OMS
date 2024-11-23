<?php


include_once './function.php';



$paramResult =checkParamId('id');
if(is_numeric($paramResult)){
    $cat_id = validated($paramResult);
    
    $cat =getById('category',$cat_id);
    if($cat['status'] == 200){

        $userDeleteRes =  deleteQuery('category',$cat_id);
        if($userDeleteRes){
            redirect('attribute.php','category is deleted successfully');


        }else{
            redirect('attribute.php','something went wrong');

        }

    }else{
        redirect('attribute.php.php',$cat);
    }

}else{
    redirect('attribute.php',$paramResult);

}
?>