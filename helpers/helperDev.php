<?php
$file_pointer = 'inc/config.php';

if (file_exists($file_pointer)) {
   // echo "The file $file_pointer exists!";
} else {
    echo "The file $file_pointer does not exists, please contact with atakde :)";
    exit(0);
}
