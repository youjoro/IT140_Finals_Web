<?php
    error_reporting(E_ALL ^ E_WARNING); 
    // Change Params if needed
    // Four known params so far: temperature, moisture, humidity

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
    $myfile = file_put_contents('arduino.log', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

    die();
?>