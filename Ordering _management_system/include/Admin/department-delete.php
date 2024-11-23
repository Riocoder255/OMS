<?php


include_once './function.php';



$paramResult =checkParamId('id');
if(is_numeric($paramResult)){
    $cat_id = validated($paramResult);
    
    $cat =getById('department',$cat_id);
    if($cat['status'] == 200){

        $userDeleteRes =  deleteQuery('department',$cat_id);
        if($userDeleteRes){
            redirect('department.php','department is deleted successfully');


        }else{
            redirect('department..php','something went wrong');

        }

    }else{
        redirect('department..php',$cat);
    }

}else{
    redirect('department.php',$paramResult);

}
?>