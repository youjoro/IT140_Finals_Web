<?php
    // Change Params if needed
    // Three known params so far: temperature, moisture, humidity

    $temp = $_GET['temp'];
    $moisture = $_GET['moisture'];
    $humidity = $_GET['humidity'];

    $txt = "user id date";
    $myfile = file_put_contents('arduino.log', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

    die();
?>