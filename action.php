<?php
include_once("inc/config.php");
session_start();
$email = $_POST['email'];
$password = $_POST['password'];

$query = $conn->query("SELECT * FROM users WHERE email='$email' && password_='$password'",PDO::FETCH_ASSOC);
if ($count = $query -> rowCount()){
    if($count > 0){
        // Email and password match
        $sql = "SELECT user_id,firstname,surname,username,is_verified,is_admin 
                FROM users WHERE email='$email' && password_='$password'";
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
	}else{
        // System-based error
		echo -1;
	}
}
else{
    // Email and password does not match
    echo 0;
}

if (isset($_POST['SignUp'])) {

  date_default_timezone_set('Europe/Istanbul');
  $CreateDate = date('Y-m-d H:i:s');
  $LastLogin = date('Y-m-d H:i:s');
  $Username = $_POST['Username'];
  $Email = $_POST['Email'];
  $Password = $_POST['Password'];
  $Firstname = $_POST['Firstname'];
  $Lastname = $_POST['Lastname']; 
  $ConfirmPassword = $_POST['ConfirmPassword'];

  if($ConfirmPassword == $Password){

    $sqlAddUser = "INSERT INTO users(firstname,surname,email,username,password_,create_date,last_login,is_verified,is_admin)
    VALUES ('$Firstname','$Lastname','$Email','$Username','$Password','$CreateDate','$LastLogin',0,0);";
    $conn->exec($sqlAddUser);
  ?>
    <script>
    window.location.replace('index.php')
    </script>
  <?
  }
  else{
  ?>
    <script>
    alert('Please check your password again')
    </script>
  <?
  }
}


?>