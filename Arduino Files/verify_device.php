<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $device_id = $_GET['id'];
    
    $db_conn = new DBobject;
    
    if ($db_conn -> device_exists($device_id)==FALSE){
        echo shell_exec("python $PATH/Arduino Files/Ardu_to_Py/Py_To_php.py 'NO' 'nigga'");
        
    }

    

    die();
?>