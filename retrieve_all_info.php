<?php
    include 'static/db_conn.php';

    $db_conn = new DBobject;

    
    $datas = $db_conn->show_user_table();

    echo ($datas);
?>