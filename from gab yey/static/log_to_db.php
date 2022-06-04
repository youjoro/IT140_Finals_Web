<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';
    include $PATH.'static/db_conn.php';

    $db_conn = new DBobject;
    $unix_timestamp = $argv[1];

    $date = date("Y-m-d", $unix_timestamp);
    $filepath = $PATH."arduino_logs/arduino_".$date.".log";

    $f = fopen($filepath, 'r');
    $earliest_record = fgets($f);
    fclose($f);

    $record_array = json_decode($earliest_record, true);

    $previous_timestamp = $record_array['Date'] + 0;
    $current_timestamp = $unix_timestamp + 0;
    $delta_time = $current_timestamp - $previous_timestamp;

    if ($delta_time <= 600) { 
        return;
    }

    $data_array = array();

    // filter first to get device_id
    foreach (new SplFileObject($filepath) as $line) {
        $data = json_decode($line, true);

        if ($data['Device_id'] == 0){ continue;}

        if (!in_array($data_array[$data['Device_id']], $data_array)) {
            $data_array[$data['Device_id']] = array();
            array_push($data_array[$data['Device_id']], $data);
        }

        else{
            array_push($data_array[$data['Device_id']], $data);
        }
    }


    //once filtered by device_id, add to db by their device_id
    foreach ($data_array as $device) {
        $temp_array = array();
        $humidity_array = array();
        $moisture_array = array();

        $current_device = "";
        $current_date = $unix_timestamp;

        foreach ($device as $data){
            array_push($temp_array, $data['Temperature']);
            array_push($humidity_array, $data['Humidity']);
            array_push($moisture_array, $data['Moisture']);
            $current_device = $data['Device_id'];
        }

        $average_temp = array_sum($temp_array) / count($temp_array);
        $average_humidity = array_sum($humidity_array) / count($humidity_array);
        $average_moisture = array_sum($moisture_array) / count($moisture_array);

        $db_conn->insert_device_data($current_device,
                                     $average_temp,
                                     $average_humidity,
                                     $average_moisture,
                                     $current_date);
    }

    

    //reset the log file to get new and updated logs
    unlink($filepath);
?>