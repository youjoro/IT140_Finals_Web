<?php
    include 'db_conn.php';


    $user_email=$_POST['user_email'];
    $user_pass=$_POST['user_password'];


    if($mysqli->connect_error){
        die("Connection failed".$mysqli->connect_error);
    }
      echo "Connected successfully";
      $sql = "INSERT INTO `user_info` (`User_email`,`User_password`) VALUES ('$user_email','$user_pass')";
      $avg_sql ="SELECT `User_email`,`User_password` FROM `user_info`";


    $send_data =  mysqli_query($mysqli,$sql);
    echo $send_data;

?>