<?php
include_once("inc/Conn.php");
include_once("helpers/helperDev.php");
session_start();

$conne = new Mysql();
$conn = $conne->dbConnect();

if($_SESSION["user_UserID"] == NULL){
    echo  "You must be logged in to vote.";
    return;
}

$action = $_POST["action"];
$q_id = $_POST['q_id'];

if($action == "like"){
    $query = $conn->query("UPDATE questions SET q_like=q_like+1 WHERE q_id=$q_id"); 
}
else if($action == "dislike"){
    $query = $conn->query("UPDATE questions SET q_dislike=q_dislike+1 WHERE q_id=$q_id"); 
}
?>