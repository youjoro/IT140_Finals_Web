<?php
    include 'db_conn.php';

    $db = new DBobject;
    
    $result1 = $db->device_exists(1234);
    $result2 = $db->device_exists(3244);
    $result3 = $db->device_exists(4444);


?>