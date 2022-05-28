<?php
    include 'db_conn.php';

    $user_email=$_POST['user_email'];
    $user_pass=$_POST['user_password'];
    $id_find = $_POST['device_id'];

    if ($id_find != null && $id_find != '' ){
      
      $db_conn = new DBobject;

      if($db_conn->user_exists($user_email) == FALSE){

        $db_conn->insert_user_data($user_email,$user_pass);
        
        if($db_conn->device_exists($id_find)==TRUE){
          
          $db_conn->update_device_info($id_find,$user_email);
        }
        echo "transaction complete";
      }
      echo "bawal yan pre";


    }

    header("Location: client_view.html");
    
    die();
?>