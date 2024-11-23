<?php 
 include ('./admin_connect.php');
 function getCartProductCount($conn) {
    $session_id = session_id();
    $result = $conn->query("SELECT COUNT(DISTINCT product_id) AS count FROM cart WHERE session_id = '$session_id'");
    $row = $result->fetch_assoc();
    return $row['count'] ? $row['count'] : 0;
}


function  redirectt($url,$error)
{
    $_SESSION ['error']= $error;
    header('Location: '.$url);
    exit(0);

}


function  directe($url,$success)
{
    $_SESSION ['success']= $success;
    header('Location: '.$url);
    exit(0);

}

//session message
function alertmessages(){
    if(isset($_SESSION['error'])){
        echo '<div class="alert alert-success">
        <strong>'. $_SESSION ['error'].'</strong>
        
        </div>';
        unset( $_SESSION ['error']);
    }
}
//session message
function alertmess(){
    if(isset($_SESSION['success'])){
        echo '<div class="alert alert-danger">
        <strong>'. $_SESSION ['success'].'</strong>
        
        </div>';
        unset( $_SESSION ['success']);
    }}
?>


