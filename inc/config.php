<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "customer_support";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'localhost:80') {
    define('ENV', 'dev');
    //$environment = 'dev';
} else {
    define('ENV', 'live');
    //$environment = 'live';
}

/* *** Set default timezone *** */

date_default_timezone_set('America/New_York');

/* *** Find time ago for comments *** */

/* $file_pointer = 'inc/config.php';

if (file_exists($file_pointer)) {
    // echo "The file $file_pointer exists!";
} else {
    echo "The file $file_pointer does not exists, please contact with atakde :)";
    exit(0);
}
 */
?>

