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
    $sqlAddUser = "INSERT IGNORE INTO users(firstname,surname,email,username,password_,ip_address,is_verified,is_admin,image_link)
    VALUES ('$Firstname','$Lastname','$Email','$Username','$hashPassword','$UserIp',0,0,'images/avatar.png');";
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

if($_SESSION["user_UserID"] == NULL && $action == NULL){
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
        $values[] = array('type' => 'int', 'val' => $q_id);
        $values[] = array('type' => 'int', 'val' => $user_id);
        $values[] = array('type' => 'int', 'val' => '1');
        $conne->insertInto("like_data",$values);
    }else {
        echo "This cannot be done! You can only vote one question once!";
    }
}
else if($action == "dislike"){
    if($checkLikeData === 0) {
        $query = "UPDATE questions SET q_dislike=q_dislike+1 WHERE q_id=".$q_id."";
        $conn->exec($query);
        $values[] = array('type' => 'int', 'val' => $q_id);
        $values[] = array('type' => 'int', 'val' => $user_id);
        $values[] = array('type' => 'int', 'val' => '0');
        $conne->insertInto("like_data",$values);
    } else {
        echo "This cannot be done! You can only vote one question once!";
    }
}

if($action =="deleteUser") {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    $statement = $conn->prepare($query);
    $statement->execute();
    echo "Deleted User!";
}

if($action == "deleteQuestion") {
  $q_id = $_POST['q_id'];
  $query = "DELETE FROM questions WHERE q_id = '$q_id'";
  $statement = $conn->prepare($query);
  $statement->execute();
  echo "Deleted Question!";
}

if($action == "deleteCategory") {
  $cat_id = $_POST['cat_id'];
  $query = "DELETE FROM categories WHERE cat_id = '$cat_id'";
  $statement = $conn->prepare($query);
  $statement->execute();
  echo "Deleted Category!";
}

if($action == "addCategory") {
  $cat_name = $_POST['cat_name'];
  $cat_description = $_POST['cat_description'];
  $cat_slug = str_replace(' ', '-', strtolower($cat_name));
  $cat_keywords = str_replace(' ', ',', $cat_name);
  $query = "INSERT INTO categories(cat_name,cat_description,cat_keywords,cat_slug) VALUES('$cat_name','$cat_description','$cat_keywords','$cat_slug')";
  $statement = $conn->prepare($query);
  $statement->execute();
  echo "Added Category!";
}

if($action == "addUser") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $options = array("cost"=>4);
  $hashPassword = password_hash("123123",PASSWORD_BCRYPT,$options);
  $query = "INSERT INTO users(firstname,surname,email,username,password_,is_verified,is_admin) VALUES('test','test','$email','$username','$hashPassword',1,1)";
  $statement = $conn->prepare($query);
  $statement->execute();
  echo "Added Category!";
}
?>