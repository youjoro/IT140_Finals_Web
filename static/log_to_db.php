<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $db_conn = new DBobject;
    $unix_timestamp = $_GET['date'];

    $date = date("Y-m-d", $unix_timestamp);
    $filepath = $PATH."arduino_logs/arduino_".$date.".log";

    $f = fopen($filepath, 'r');
    $earliest_record = fgets($f);
    fclose($f);

    $record_array = json_decode($earliest_record, true);

    $previous_timestamp = $record_array['Date'] + 0;
    $current_timestamp = $unix_timestamp + 0;
    $delta_time = $current_timestamp - $previous_timestamp;

    if ($delta_time <= 3600) { 
        return;
    }

    // get all records, average then add to db

    $temp_array = array();
    $humidity_array = array();
    $moisture_array = array();

    foreach (new SplFileObject($filepath) as $line) {
        $data = json_decode($line, true);

        array_push($temp_array, $data['Temperature']);
        array_push($humidity_array, $data['Humidity']);
        array_push($moisture_array, $data['Moisture']);

    }

    $average_temp = array_sum($temp_array) / count($temp_array);
    $average_humidity = array_sum($humidity_array) / count($humidity_array);
    $average_moisture = array_sum($moisture_array) / count($moisture_array);

    $db_conn->insert_device_data($data['Device_id'],
                                 $average_temp,
                                 $average_humidity,
                                 $average_moisture,
                                 $data['Date']);

    unlink($filepath);
?>