<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $db_conn = new DBobject;
    $email = $_GET['email'];

    $db_conn->get_all_devices($email);

    die();
?>