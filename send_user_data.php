<?php
    include 'db_conn.php';

    $user_email=$_POST['user_email'];
    $user_pass=$_POST['user_password'];
    $id_find = $_POST['device_id'];

    $db_conn = new DBobject;

    if ($id_find != null && $id_find != ''){
      if($db_conn->checkDevice($id_find)==TRUE){
        $db_conn->insert_user_data($user_email,$user_pass);


        $db_conn->update_device_info($id_find,$user_email);
        
      }
    }
    else{
      $db_conn->insert_user_data($user_email,$user_pass);
    }

?>