<?php

include_once("inc/Conn.php");

$conne = new Mysql();
$conn = $conne->dbConnect(); 

if( isset($_POST["question"] && !empty($_POST["question"]) && isset($_POST["questionID"] && !empty($_POST["questionID"]) ) {
    
    $question = $_POST["question"];
    $id = $_POST["questionID"];
    $runPython =exec('python3 /var/www/html/python/analyse.py ' . $question . " 2>&1");

    if( $runPython !== NULL && isset($runPython) && !empty($runPython) ) {
        $sql = "INSERT INTO comments (c_post_id, c_description) VALUES ('".$id."', '".$runPython."')";
        $gonder = $conn->prepare($sql);
        $gonder->execute();
    }
}
?>