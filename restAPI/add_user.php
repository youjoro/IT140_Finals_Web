<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $email = $_GET['email'];
    $password = $_GET['password'];

    $db_conn = new DBobject;
    
    echo $db_conn -> insert_user_data($email, $password);

    die();

?>