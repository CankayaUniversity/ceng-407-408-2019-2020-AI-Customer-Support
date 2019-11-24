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
?>