<?php

include_once("../inc/Conn.php");

$conne = new Mysql();
$conn = $conne->dbConnect(); 

if( $_GET["question"] !== NULL && !empty($_GET["question"]) && $_GET["questionID"] !== NULL && !empty($_GET["questionID"]) ) {
    $question = urldecode($_GET["question"]);
    $id = $_GET["questionID"];
    $runPython =exec('python3 /var/www/html/python/analyse.py ' . $question . " 2>&1");
    if( $runPython !== NULL && !empty($runPython) ) {
        $runPython = htmlspecialchars($runPython,ENT_QUOTES);
        $sql = "INSERT INTO comments (c_post_id, c_description, c_author) VALUES ('".$id."', '".$runPython."', 12)";
        $gonder = $conn->prepare($sql);
        $gonder->execute();

        $sql = "SELECT q_author FROM questions WHERE q_id ='$id'";
        $questionAuthorArray = $conne->selectFreeRun($sql);
        $questionAuthor = $questionAuthorArray[0]["q_author"];

        $n_desc = "Your question($question) is answered.";
        $sql = "INSERT INTO notifications (n_description,n_author,n_post_id, n_notified_id,n_image) VALUES ('$n_desc',12,'$id', '$questionAuthor','/images/noti_icons/comment.png')";
        $conne->freeRun($sql);
    }
}
?>