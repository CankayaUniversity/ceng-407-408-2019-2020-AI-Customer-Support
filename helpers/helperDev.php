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

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $environment = 'dev';
} else {
    $environment = 'live';
}
