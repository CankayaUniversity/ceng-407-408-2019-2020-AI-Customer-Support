<?php

include_once("../inc/Conn.php");

$conne = new Mysql();
$conn = $conne->dbConnect(); 

if( $_GET["question"] !== NULL && !empty($_GET["question"]) && $_GET["questionID"] !== NULL && !empty($_GET["questionID"]) ) {
    $question = $_GET["question"];
    $id = $_GET["questionID"];
    $runPython =exec('python3 /var/www/html/python/analyse.py ' . $question . " 2>&1");
    if( $runPython !== NULL && !empty($runPython) ) {
        $sql = "INSERT INTO comments (c_post_id, c_description, c_author) VALUES ('".$id."', '".$runPython."', 4)";
        $gonder = $conn->prepare($sql);
        $gonder->execute();
    }
}
?>