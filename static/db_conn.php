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
			$this->host = 'localhost:3307';
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

		public function verify_user($user_email,$user_pass){
			
			$sql ="SELECT `User_email`,`User_password` FROM `user_info` WHERE `User_email` LIKE '$user_email' and `User_password` LIKE '$user_pass';";
			$check=mysqli_query($this->mysqli,$sql);
			
			if($check->num_rows == 0){
				return FALSE;
			}

			echo"<small>Logged in Welcome whoever tf u are</small>";
			return TRUE;

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

		function get_worker_state() {
			$query = "SELECT `isWritingToDB` FROM `php_state` WHERE `isWritingToDB`;";
			$sql=mysqli_query($this->mysqli, $query);
			$result = mysqli_fetch_assoc($sql);

			return $result['isWritingToDB'];
		}

		function change_worker_state(int $bool) {
			$not_bool = (int)!$bool;

			$update_user = "UPDATE php_state SET isWritingToDB = $bool WHERE isWritingToDB = $not_bool;";
			mysqli_query($this->mysqli, $update_user);
			 
		}

		function insert_device_data($device_id, $temp, $humidity, $moisture, $date) {
			$query = "INSERT INTO `device_data` VALUES ('$device_id', '$temp', '$humidity', '$moisture', '$date')";
			mysqli_query($this->mysqli, $query);
		}

		function get_device_data($email, $id=NULL){
			$query = "SELECT `device_data`.`device_id`, `Temperature`, `Humidity`, `Moisture`, `reading_time`
					FROM `device_data`
					JOIN `available_devices` on `device_data`.`device_id` = `available_devices`.`device_id`
					JOIN `user_info` on `user_info`.`User_email` = `available_devices`.`owner_email`
					WHERE `user_info`.`User_email` = '$email'";
			
			if ($id) {
				$query .= " AND `device_data`.`device_id`='$id'";
			}

			$query .= " AND cast(from_unixtime(`reading_time`) as Date) = cast(now() as Date)";

			$query .= " ORDER BY `reading_time` ASC";
			
			$result = mysqli_query($this->mysqli, $query);

			$json = array();
			while($row = mysqli_fetch_assoc($result)) {
				$json[] = $row;
			}
			return json_encode($json);
		}

		function get_all_devices($email) {
			$query = "SELECT `device_id` FROM `available_devices` WHERE `owner_email` = '$email';";
			$result = mysqli_query($this->mysqli, $query);

			$json = array();
			while($row = mysqli_fetch_assoc($result)) {
				$json[] = $row;
			}
			echo json_encode($json);
		}

		function show_user_table(){
			$query = "SELECT `User_email`,`User_password`,`First_Name`,`Last_Name`,`Birth_date` FROM `user_info`;";
			$sql = mysqli_query($this->mysqli, $query);

			if ($sql->num_rows > 0) {
				// output data of each row
				while($row = $sql->fetch_assoc()) {
				echo "<tr><td>" . $row["User_email"]. "</td><td>" . $row["User_password"] . "</td><td>"
				. $row["First_Name"]. "</td><td>" . $row["Last_Name"] . "</td><td>" . $row["Birth_date"] . "</td></tr>";
				}
				echo "</table>";
				} else { echo "0 results"; }
		}
	}
	
?>