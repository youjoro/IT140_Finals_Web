<?php
    $test_arr = array();

    $test_arr['name'] = array();

    array_push($test_arr['name'], [
        'Device_id' => 111,
        'Temperature' => 222,
        'Moisture' => 333,
        'Humidity' => 444,
        'Date' => 555,
    ]);

    array_push($test_arr['name'], [
        'Device_id' => 111,
        'Temperature' => 222,
        'Moisture' => 333,
        'Humidity' => 444,
        'Date' => 555,
    ]);

    foreach ($test_arr as $arr){
        $arr_test = array();
        foreach($arr as $data){
            array_push($arr_test, $data['Temperature']);
        }
    }
?>