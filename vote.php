<?php
include_once("inc/Conn.php");
include_once("helpers/helperDev.php");
session_start();

$conne = new Mysql();
$conn = $conne->dbConnect();

if($_SESSION["user_UserID"] == NULL){
    echo  "You must be logged in to vote.";
    return;
} else {
    $user_id = $_SESSION['user_UserID'];
}

$action = $_POST["action"];
$q_id = $_POST['q_id'];
if(!empty($q_id) && !empty($user_id)) {
    $sql="SELECT * FROM like_data WHERE user_id = '$user_id' AND q_id ='$q_id'";
    $ps = $conn->query($sql);
    $checkLikeData = $ps->rowCount();
}

if($action == "like"){
    if($checkLikeData === 0) {
        $sql = "UPDATE questions SET q_like=q_like+1 WHERE q_id='$q_id'";
        $gonder = $conn->prepare($sql);
        $gonder->execute();
        $logLikeData = "INSERT INTO like_data(q_id,user_id,status) VALUES ('$q_id', '$user_id', '1')";
        $conn->exec($logLikeData);
    }else {
        echo "This cannot be done! You can only vote one question once!";
    }
}
else if($action == "dislike"){
    if($checkLikeData === 0) {
        $query = "UPDATE questions SET q_dislike=q_dislike+1 WHERE q_id=".$q_id."";
        $conn->exec($query);
        $logLikeData = "INSERT INTO like_data(q_id,user_id,status) VALUES ('$q_id', '$user_id', '0')";
        $conn->exec($logLikeData);
    } else {
        echo "This cannot be done! You can only vote one question once!";
    }
   
}
?>