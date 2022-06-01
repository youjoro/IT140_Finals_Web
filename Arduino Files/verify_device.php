<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $device_id = $_GET['id'];
    

    $db_conn = new DBobject;
    
    echo $db_conn -> device_exists($device_id);

    die();
?>