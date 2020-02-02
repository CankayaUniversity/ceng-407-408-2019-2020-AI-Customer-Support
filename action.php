<?php
include_once("inc/Conn.php");
include_once("helpers/helperDev.php");
session_start();

$conne = new Mysql();
$conn = $conne->dbConnect();

$action = $_POST["action"];
$Email = $_POST['email'];
$Password = trim($_POST['password']);
$options = array("cost"=>4);
$hashPassword = password_hash($Password,PASSWORD_BCRYPT,$options);

if($action == "login") {
  $query = $conn->query("SELECT * FROM users WHERE email='$Email'",PDO::FETCH_ASSOC)->fetch();
  if (isset($query)){
      if(password_verify($Password,$query['password_'])){
          $_SESSION["user_UserID"]=$query['user_id'];
          $_SESSION["user_Username"]=$query['username'];
          $_SESSION["user_Firstname"]=$query['firstname'];
          $_SESSION["user_Surname"]=$query['surname'];
          $_SESSION["user_isAdmin"]=$query['is_admin'];
          $_SESSION["user_isVerified"]=$query['is_verified'];
          $_SESSION["user_Email"]=$Email;
          echo 1;
    }else {
        // Email and password does not match
        echo -1;
    }
  }
}

if ($action == "register") {
  if($Email == NULL || $Email == ''){
    header('Location: index.php');
  }

  $Username = $_POST['username'];
  $Firstname = $_POST['firstname'];
  $Lastname = $_POST['lastname']; 
  $ConfirmPassword = $_POST['confirmpass'];
  $UserIp = helperDev::get_client_ip();
  if($ConfirmPassword == $Password){
    $sqlAddUser = "INSERT IGNORE INTO users(firstname,surname,email,username,password_,ip_address,is_verified,is_admin)
    VALUES ('$Firstname','$Lastname','$Email','$Username','$hashPassword','$UserIp',0,0);";
    $conn->exec($sqlAddUser);
    $query = $conn->query("SELECT * FROM users WHERE email='$Email'",PDO::FETCH_ASSOC)->fetch();
    if (isset($query)){
      if(password_verify($Password,$query['password_'])){
          $_SESSION["user_UserID"]=$query['user_id'];
          $_SESSION["user_Username"]=$query['username'];
          $_SESSION["user_Firstname"]=$query['firstname'];
          $_SESSION["user_Surname"]=$query['surname'];
          $_SESSION["user_isAdmin"]=$query['is_admin'];
          $_SESSION["user_isVerified"]=$query['is_verified'];
          $_SESSION["user_Email"]=$Email;
          echo 1;
      }else {
        echo -1;// Email and password does not match
      }
    }
  }
}

if($_SESSION["user_UserID"] == NULL){
    echo  "You must be logged in to vote.";
    return;
} else {
    $user_id = $_SESSION['user_UserID'];
}

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