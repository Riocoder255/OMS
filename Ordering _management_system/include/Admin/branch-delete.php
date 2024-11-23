<?php


include_once './function.php';



$paramResult =checkParamId('id');
if(is_numeric($paramResult)){
    $cat_id = validated($paramResult);
    
    $cat =getById('branch',$cat_id);
    if($cat['status'] == 200){

        $userDeleteRes =  deleteQuery('branch',$cat_id);
        if($userDeleteRes){
            redirect('branch.php','Branch is deleted successfully');


        }else{
            redirect('branch.php','something went wrong');

        }

    }else{
        redirect('branch.php',$cat);
    }

}else{
    redirect('branch.php',$paramResult);

}
?>