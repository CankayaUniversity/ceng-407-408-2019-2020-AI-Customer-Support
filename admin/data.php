<?php
header('Content-Type: application/json');

include '../inc/Conn.php';

$conne = new Mysql();
$conn = $conne->dbConnect();

$getAllQuestions = $conne->selectFreeRun("SELECT COUNT(CASE WHEN is_solved= -1 THEN 1 END) AS notsolved, COUNT(CASE WHEN is_solved= 1 THEN 1 END) AS solved FROM questions");

$data["solved"] = $getAllQuestions[0]["solved"];
$data["notsolved"] = $getAllQuestions[0]["notsolved"];

echo json_encode($data);
