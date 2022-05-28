<?php
    include 'db_conn.php';

    $check_email=$_GET['q'];

    $db_conn = new DBobject;
    $db_conn -> user_exists($check_email);

    die();
?>