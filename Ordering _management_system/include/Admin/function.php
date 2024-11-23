<?php 
include_once "./admin_connect.php";
session_start();
//this is validated input data 
function validated($inputData){
    global $conn;
   $validatedData=  mysqli_real_escape_string($conn,$inputData);
   return trim( $validatedData);



}
//url or direct to weebpage 
function  redirect($url,$error)
{
    $_SESSION ['error']= $error;
    header('Location: '.$url);
    exit(0);

}
//session message
function alertmessage(){
    if(isset($_SESSION['error'])){
        echo '<div class="alert alert-success">
        <strong>'. $_SESSION ['error'].'</strong>
        
        </div>';
        unset( $_SESSION ['error']);
    }
}
//session message
function alertme(){
    if(isset($_SESSION['success'])){
        echo '<div class="alert alert-danger">
        <strong>'. $_SESSION ['success'].'</strong>
        
        </div>';
        unset( $_SESSION ['success']);
    }}
    //fing the id it is true

function checkParamId($paramtype){
    if(isset($_GET[$paramtype])){
        if($_GET[$paramtype] != null){
            return $_GET[$paramtype];

        }else{
            return 'No id found';
        }
    }else{
        return 'No id given';
    }

}
//select all data in the table row
function getAll($tableName){
    global $conn;
    $table= validated($tableName);
    $query ="SELECT * FROM $table";
    $result =mysqli_query($conn,$query);
    return $result;

}
//fetch the data in to the row 

function getById($tableName,$id){
    global $conn;
    $table= validated($tableName);
    $id =validated($id);
    $query="SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn,$query);
    if($result){

        if(mysqli_num_rows($result) == 1){
            $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
            $response =[
                'status' => 200,
                'message'=> 'Fected data ',
                'data'=> $row
    
            ];
            return $response;


        }
        else{
            $response =[
                'status' => 404,
                'message'=> 'No data record '
    
            ];
            return $response;


        }

    }
    else
    {
        $response =[
            'status' => 500,
            'message'=> 'something  Went wrong '

        ];
        return $response;


    }
        
}
 

function  direct($url,$success)
{
    $_SESSION ['success']= $success;
    header('Location: '.$url);
    exit(0);

}


function deleteQuery($tableName,$id){
    global $conn;
    $table= validated($tableName);
    $id =   validated($id);

    $query =" DELETE  FROM $table where id = '$id' LIMIT 1";
    $result= mysqli_query($conn,$query);

    return $result;
}
//not authorize login dashboard  in the admin
function isAdmin()
{
    if (isset($_SESSION['auth']) && $_SESSION['auth_role'] == 'admin') {
        return true;
    }
    return false;
}
?>