<?php 
include 'helpers/SEOHelper.php';
include 'helpers/Functions.php';

session_start();
$id = $_SESSION["user_UserID"];
$conne = new Mysql();
$conn = $conne->dbConnect();

    $query = $conn->prepare("UPDATE users SET last_login=CURRENT_TIMESTAMP WHERE user_id=:id");
    $query->execute([
        ':id' =>  $id
    ]);
  
session_unset();
session_destroy();

header("location:index.php");
exit();

?>