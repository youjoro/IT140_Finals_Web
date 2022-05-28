<?php
error_reporting(E_ALL ^ E_WARNING); 
//adjust names
	class DBobject {
		private $host;
		private $user;
		private $pass;
		private $db;
		private $mysqli;

		public function __construct() {
			$this->host = 'localhost';
			$this->user = 'root';
			$this->pass = '';
			$this->db = 'fumo_db';
			$this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db) or die($this->mysqli->error);

			if($this->mysqli->connect_error){
				die("Connection failed".$this->mysqli->connect_error);
			}
			
		}

		public function user_exists($check_email){
			$sql = "SELECT * FROM `user_info` WHERE `User_email` = '$check_email';";
			$check=mysqli_query($this->mysqli,$sql);
			
			if($check->num_rows == 0){
				return FALSE;
			}

			echo"<small>User Exists</small>";
			return TRUE;

		}

		public function insert_user_data($user_email,$user_pass){
			
			$sql = "INSERT INTO `user_info` (`User_email`,`User_password`) VALUES ('$user_email','$user_pass')";
			mysqli_query($this->mysqli, $sql);

			echo "User Data Inserted";
		}

		function update_device_info($id_find,$user_email){

			$update_user = "UPDATE available_devices SET owner_email = '$user_email' WHERE device_id = '$id_find';";
			mysqli_query($this->mysqli, $update_user);

			echo "Device data updated";
		  }
	  
		function device_exists($id_find){
			$query = "SELECT `owner_email` FROM `available_devices` WHERE `device_id` LIKE $id_find;";
			$sql=mysqli_query($this->mysqli, $query);

			$result = mysqli_fetch_assoc($sql);

			if ($sql->num_rows == 0 || $result['owner_email'] != 0){
				echo $id_find." is Not Available";
				return FALSE;
			}

			return TRUE;

		}

	}
	
?>