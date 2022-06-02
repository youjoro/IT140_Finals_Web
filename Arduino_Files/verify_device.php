<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $device_id = $_GET['id'];
    $verify = 0;
    $db_conn = new DBobject;
    
    if ($db_conn->verify_device($device_id)==TRUE){
        $verify=1;
    }else{
        $verify=0;
    }



    $send_link ="http://localhost//IT140_Finals_Web/Arduino_Files/Ardu_to_Py/Py_To_php.py?data=".$verify;
    echo $send_link;

    die();
?>