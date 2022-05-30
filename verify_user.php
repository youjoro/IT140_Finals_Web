<?php
    include 'static/db_conn.php';

    $user_email=$_POST['user_email'];
    $user_pass=$_POST['user_password'];

    $db_conn = new DBobject;
    if ($db_conn->verify_user($user_email,$user_pass)==TRUE){
        header("Location: user_view.html");
    }

    
    
    die();
?>