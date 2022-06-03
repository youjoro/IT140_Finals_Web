<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $db_conn = new DBobject;
    $email = $_GET['email'];
    $device_id = $_GET['id'];

    $json_data = $db_conn->get_device_data($email, $device_id);

    echo $json_data;

    $cmd = "py graph.py ".json_encode($json_data);
    pclose(popen($cmd, "w")); //This line will run the php script on the background

    die();
?>