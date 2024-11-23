<?php


include_once './function.php';



$paramResult =checkParamId('id');
if(is_numeric($paramResult)){
    $pay_id = validated($paramResult);
    
    $pay =getById('payment_method',$pay_id);
    if($pay['status'] == 200){

        $userDeleteRes =  deleteQuery('payment_method',$pay_id);
        if($userDeleteRes){
            redirect('payment.php','payment already   deleted successfully');


        }else{
            redirect('payment.php','something went wrong');

        }

    }else{
        redirect('payment.php',$pay);
    }

}else{
    redirect('payment.php',$paramResult);

}
?>