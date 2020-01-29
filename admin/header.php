<?php
    session_start();

    ini_set('display_errors', 1);
    error_reporting(-1); 

    include '../inc/Conn.php';

    $conne = new Mysql();
    $conn = $conne->dbConnect();

    if (isset($_SESSION['user_Username'])) {
        $sUsername = $_SESSION['user_Username'];
        $userid = $_SESSION['user_UserID'];
    } else {
        $sUsername = null;
    }
?>