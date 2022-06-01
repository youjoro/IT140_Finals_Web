<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $db_conn = new DBobject;
    $email = $_GET['email'];
    $device_id = $_GET['id'];

    $db_conn->get_device_data($email, $device_id);
?>