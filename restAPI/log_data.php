<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    error_reporting(E_ALL ^ E_WARNING); 
    // Change Params if needed
    // Four known params so far: temperature, moisture, humidity
    // Date must follow this format => Year-Month-Day

    $device_id = $_GET['id'];
    $temp = $_GET['temp'];
    $moisture = $_GET['moisture'];
    $humidity = $_GET['humidity'];
    $unix_timestamp = $_GET['date'];

    $date = date("Y-m-d", $unix_timestamp);

    $data = [
        'Device_id' => $device_id,
        'Temperature' => $temp,
        'Moisture' => $moisture,
        'Humidity' => $humidity,
        'Date' => $unix_timestamp,
    ];

    $txt = json_encode($data);
    $myfile = file_put_contents($PATH."arduino_logs/arduino_".$date.".log", $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

    $cmd = "start /b php ".$PATH."static/log_to_db.php ".$unix_timestamp;

    pclose(popen($cmd, "w")); //This line will run the php script on the background

    die();
?>