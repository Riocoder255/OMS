<?php


include_once './function.php';



$paramResult =checkParamId('id');
if(is_numeric($paramResult)){
    $size_id = validated($paramResult);
    
    $size =getById('sizing',$size_id);
    if($size['status'] == 200){

        $sizeDeleteRes =  deleteQuery('sizing',$size_id);
        if($sizeDeleteRes){
            redirect('size.php','Size is deleted successfully');


        }else{
            redirect('size.php','something went wrong');

        }

    }else{
        redirect('size.php',$size);
    }

}else{
    redirect('size.php',$paramResult);

}
?>