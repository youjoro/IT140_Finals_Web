<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';
    
    function check_state($db_conn) {
        return $db_conn->get_worker_state();
    }

    function main_func($PATH) {
        $db_conn = new DBobject;
        $isWriting = check_state($db_conn);

        $logs = scandir($PATH."/arduino_logs/", SCANDIR_SORT_DESCENDING);
        $previous_log_date = substr($logs[1], 8, 10);

        if ($isWriting || empty($previous_log_date)) {
            return;
        }

        $db_conn->change_worker_state(1);

        $current_date = date("Y-m-d");
        // write to database

        #unlink($PATH."/arduino_logs/"."$logs[1]"); DELETE LOG TO SAVE SPACE
        $db_conn->change_worker_state(0);
        
    }

    main_func($PATH);
?>