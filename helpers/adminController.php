<?php
include '../inc/Conn.php';
class adminController
{
    public static function getAllUsers() {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $query = $conn->query("SELECT * FROM users");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $r= $query->fetchAll();
        return $r;
    }
}