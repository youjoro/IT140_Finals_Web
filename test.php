<?php
    $PATH = '/xampp/htdocs/IT140_Finals_Web/';

    $test = $argv[1];

    $txt = $test;
    $myfile = file_put_contents($PATH."static/static.log", $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

    die();
?>