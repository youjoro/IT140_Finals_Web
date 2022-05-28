<?php
//adjust names
	class DBobject {
		private $host;
		private $user;
		private $pass;
		private $db;
		private $mysqli;

		public function __construct() {
			$this->host = 'localhost';
			$this->user = 'pma';
			$this->pass = '';
			$this->db = 'fumo_db';
			$this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db) or die($this->mysqli->error);

			if($this->mysqli->connect_error){
				die("Connection failed".$this->mysqli->connect_error);
			}
			echo "Connected successfully";
		}

		public function insert_user_data($user_email,$user_pass){

			$sql = "INSERT INTO `user_info` (`User_email`,`User_password`) VALUES ('$user_email','$user_pass')";
			mysqli_query($this->mysqli, $sql);

			echo "User Data Inserted";
		}

		function update_device_info($id_find,$user_email){

			#$update_user = "UPDATE `available_devices` SET `owner_email` = $user_email WHERE `available_devices`.`device_id` = $id_find;";
			#mysqli_query($this->mysqli,$update_user);

			#mysqli_commit($this->mysqli);
			echo "hi";
		  }
	  
		  function checkDevice($id_find){

			$find_device = "SELECT * FROM `available_devices` WHERE `device_id` LIKE $id_find;";
			$sql=mysqli_query($this->mysqli, $find_device);

			if($sql->num_rows != 0){
			  return FALSE;
			}
			return TRUE;

			echo $sql;
			
		}

	}
	
?>