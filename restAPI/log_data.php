<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    error_reporting(E_ALL ^ E_WARNING); 
    // Change Params if needed
    // Four known params so far: temperature, moisture, humidity
    // Date must follow this format => Year-Month-Day

    $temp = $_GET['temp'];
    $moisture = $_GET['moisture'];
    $humidity = $_GET['humidity'];
    $date = $_GET['date'];

    $data = [
        'Temperature' => $temp,
        'Moisture' => $moisture,
        'Humidity' => $humidity,
        'Date' => $date,
    ];

    $txt = json_encode($data);
    $myfile = file_put_contents($PATH."arduino_logs/arduino_".$date.".log", $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

    #pclose(popen("start /b php ".$PATH."static/log_to_db.php", "w"));

    die();
?>