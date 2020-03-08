<?php
header('Content-Type: application/json');

include '../inc/Conn.php';

$conne = new Mysql();
$conn = $conne->dbConnect();

$getAllQuestions = $conne->selectFreeRun("SELECT COUNT(CASE WHEN is_solved= -1 THEN 1 END) AS notanswered, COUNT(CASE WHEN is_solved= 1 THEN 1 END) AS solved, COUNT(CASE WHEN is_solved=0 THEN 1 END) AS notsolved FROM questions");

$data["solved"] = $getAllQuestions[0]["solved"];
$data["notsolved"] = $getAllQuestions[0]["notsolved"];
$data["notanswered"] = $getAllQuestions[0]["notanswered"];

echo json_encode($data);
