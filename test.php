<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $db_conn = new DBobject;
    $db_conn->change_worker_state(0);
?>