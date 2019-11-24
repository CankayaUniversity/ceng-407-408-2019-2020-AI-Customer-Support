<?php
include_once("inc/config.php");

$email = $_POST['email'];
$password = $_POST['password'];

$query = $conn->query("SELECT * FROM users WHERE email='$email' && password_='$password'",PDO::FETCH_ASSOC);
if ($count = $query -> rowCount()){
    if($count > 0){
        // Email and password match
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