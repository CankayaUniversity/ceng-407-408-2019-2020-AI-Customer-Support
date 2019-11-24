<?php

/* *** Check config file *** */

$file_pointer = 'inc/config.php';

if (file_exists($file_pointer)) {
    // echo "The file $file_pointer exists!";
} else {
    echo "The file $file_pointer does not exists, please contact with atakde :)";
    exit(0);
}

/* *** Check environment *** */

if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'localhost:80') {
    $environment = 'dev';
} else {
    $environment = 'live';
}
