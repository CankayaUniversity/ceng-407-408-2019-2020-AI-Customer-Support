<?php
include_once("inc/config.php");
include_once("helpers/helperDev.php");
session_start();

$action = $_POST["action"];
$Email = $_POST['email'];
$Password = $_POST['password'];

if($action==1){
  $query = $conn->query("SELECT * FROM users WHERE email='$Email' && password_='$Password'",PDO::FETCH_ASSOC);
  if ($count = $query -> rowCount()){
      if($count > 0){
          // Email and password match
          $sql = "SELECT user_id,firstname,surname,username,is_verified,is_admin 
                  FROM users WHERE email='$Email' && password_='$Password'";
          $q = $conn->query($sql);
          $q->setFetchMode(PDO::FETCH_ASSOC);
          while($r=$q->fetch()){
              $_SESSION["user_UserID"]=$r['user_id'];
              $_SESSION["user_Username"]=$r['username'];
              $_SESSION["user_Firstname"]=$r['firstname'];
              $_SESSION["user_Surname"]=$r['surname'];
              $_SESSION["user_isAdmin"]=$r['is_admin'];
              $_SESSION["user_isVerified"]=$r['is_verified'];
          }
          $_SESSION["user_Email"]=$Email;
      echo 1;
    }else{
          // System-based error
      echo -1;
    }
  }
  else{
      // Email and password does not match
      echo 0;
  }
}

if ($action == 0){
  if($Email == NULL || $Email == ''){
    header('Location: index.php');
    exit(0);
  }

  $Username = $_POST['username'];
  $Firstname = $_POST['firstname'];
  $Lastname = $_POST['lastname']; 
  $ConfirmPassword = $_POST['confirmpass'];
  $UserIp = get_client_ip();

  if($ConfirmPassword == $Password){
    $sqlAddUser = "INSERT INTO users(firstname,surname,email,username,password_,ip_address,is_verified,is_admin)
    VALUES ('$Firstname','$Lastname','$Email','$Username','$Password','$UserIp',0,0);";
    $conn->exec($sqlAddUser);

    $query = $conn->query("SELECT * FROM users WHERE email='$Email' && password_='$Password'",PDO::FETCH_ASSOC);

    if ($count = $query -> rowCount()){
      if($count > 0){
        // Email and password match
        $sql = "SELECT user_id,firstname,surname,username,is_verified,is_admin 
                FROM users WHERE email='$Email' && password_='$Password'";
        $q = $conn->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        while($r=$q->fetch()){
          $_SESSION["user_UserID"]=$r['user_id'];
          $_SESSION["user_Username"]=$r['username'];
          $_SESSION["user_Firstname"]=$r['firstname'];
          $_SESSION["user_Surname"]=$r['surname'];
          $_SESSION["user_isAdmin"]=$r['is_admin'];
          $_SESSION["user_isVerified"]=$r['is_verified'];
        }
        $_SESSION["user_Email"]=$email;
        echo 1;
      }
    }
  }
}
?>