<?php 
include "header.php";
$authkey = $_GET["key"];
if ($conne->selectRowCount("SELECT * FROM users WHERE resetPassAuth = '$authkey'") == 0)
    echo "<script>window.location.replace('index.php');</script>";

?>
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="lock_card">
            <div class="d-flex justify-content-center">
                <div class="lock_logo_container">
                <img src="https://img.icons8.com/ios/100/000000/lock.png"/ class="lock_logo">
                <img src="../images/mascot.png" class="verify_logo" alt="Logo_login">
                </div>
            </div>
            <div class="lock_card-header">
                <br><br><br>
                <center><h3 class="card-title mt-3 text-center">Reset Password</h3>
                <h5>Please create a new password.<h5>
                </center>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form method="post">
                <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fas fa-key"></i> </span>
                        </div>
                        <input name="password_label" class="form-control input_pass" placeholder="Password" type="password">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fas fa-key"></i> </span>
                        </div>
                        <input name="verify_password_label" class="form-control input_pass" placeholder="Verify Password" type="password">
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button name="ResetPass" type="submit" class="btn login_btn">Reset Password</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<?php
if(isset($_POST['ResetPass']) && isset($_POST['password_label']) && $_POST['password_label'] != '' && isset($_POST['verify_password_label']) && $_POST['verify_password_label'] != '') {
    $Password = $_POST['password_label'];
    $verifyPassword = $_POST['verify_password_label'];
    if($Password == $verifyPassword){
        $options = array("cost" => 4);
        $hashPassword = password_hash($Password, PASSWORD_BCRYPT, $options);
        $conne->freeRun("UPDATE users SET password_ = '$hashPassword' WHERE resetPassAuth = '$authkey'");
        $query = $conn->query("SELECT * FROM users WHERE resetPassAuth = '$authkey'", PDO::FETCH_ASSOC)->fetch();
        if (isset($query)) {
            if (password_verify($Password, $query['password_'])) {
                $_SESSION["user_UserID"] = $query['user_id'];
                $_SESSION["user_Username"] = $query['username'];
                $_SESSION["user_Firstname"] = $query['firstname'];
                $_SESSION["user_Surname"] = $query['surname'];
                $_SESSION["user_isAdmin"] = $query['is_admin'];
                $_SESSION["user_isVerified"] = $query['is_verified'];
                $_SESSION["user_Email"] = $Email;
                $conne->freeRun("UPDATE users SET resetPassAuth = '' WHERE resetPassAuth = '$authkey'");
                echo "<script>window.location.replace('index.php');</script>";
                die();
            } else {
                $error = true ;
                echo "<script>$('#error').show().delay(5000).fadeOut();</script>";
            }
        }
    }
    
}
?>