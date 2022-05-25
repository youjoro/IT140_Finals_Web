<?php
    include_once 'db_conn.php';

    $user_email=$_POST['user_email'];
    $user_pass=$_POST['user_password'];
    $id_find = $_POST['device_id'];

    if($mysqli->connect_error){
        die("Connection failed".$mysqli->connect_error);
    }
      echo "Connected successfully";

    if ($id_find != null && $id_find != ''){
      if(checkDevice($id_find)==TRUE){
        insert_user_data($user_email,$user_pass);


        update_device_info($id_find,$user_email);
        
      }
    }else{
      insert_user_data($user_email,$user_pass);
    }

    

    function insert_user_data($user_email,$user_pass){
      include 'db_conn.php';

      $sql = "INSERT INTO `user_info` (`User_email`,`User_password`) VALUES ('$user_email','$user_pass')";

      $send_data =  mysqli_query($mysqli,$sql);

      echo "sent";
    }
    
    function update_device_info($id_find,$user_email){
      include 'db_conn.php';

      $check_user = "SELECT *  FROM `user_info` WHERE `User_email` LIKE $user_email;";

      $check = mysqli_query($mysqli,$check_user);

      $insert_user = "UPDATE `available_devices` SET `owner_email` = $user_email WHERE `available_devices`.`device_id` = $id_find;";

      $send_data =  mysqli_query($mysqli,$insert_user);
    }

    function checkDevice($id_find){
      include 'db_conn.php';
      
      $find_device = "SELECT *  FROM `available_devices` WHERE `device_id` LIKE $id_find;";
      $sql=mysqli_query($mysqli,$find_device);
      if($sql->num_rows > 0){
        return TRUE;
      }else{
        return FALSE;
      }

    }
?>