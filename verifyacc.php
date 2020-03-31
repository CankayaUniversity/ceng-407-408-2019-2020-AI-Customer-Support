<?php 
include "header.php";
$authkey = $_GET["key"];
if ($conne->selectRowCount("SELECT * FROM users WHERE AccVerifyAuth = '$authkey'") == 0)
    //echo "<script>window.location.replace('index.php');</script>";
?>
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="lock_card">
            <div class="d-flex justify-content-center">
                <div class="lock_logo_container">
                <img src="https://img.icons8.com/color/144/000000/checkmark.png" class="verifyacc_logo" alt="Logo_login">
                <img src="../images/mascot.png" class="verifyaccMascot_logo" alt="Logo_login">
                </div>
            </div>
            <div class="lock_card-header">
                <center>
                    <h3 class="card-title mt-3 text-center">WELCOME!</h3>
                    <h5>Your account has been verified.<h5>
                </center>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form method="post">
                <center><h6>Continue AICS and ask your first question or search your solution!</h6></center>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button name="VerifyAcc" class="btn login_btn">Continue to AICS</button>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<?php
    $query = $conn->query("SELECT * FROM users WHERE AccVerifyAuth = '$authkey'", PDO::FETCH_ASSOC)->fetch();
    if (isset($query)) {
        $_SESSION["user_UserID"] = $query['user_id'];
        $_SESSION["user_Username"] = $query['username'];
        $_SESSION["user_Firstname"] = $query['firstname'];
        $_SESSION["user_Surname"] = $query['surname'];
        $_SESSION["user_isAdmin"] = $query['is_admin'];
        $_SESSION["user_isVerified"] = $query['is_verified'];
        $_SESSION["user_Email"] = $Email;
    }
    if (isset($_POST['VerifyAcc'])) {
        $conne->freeRun("UPDATE users SET is_verified = 1 WHERE AccVerifyAuth = '$authkey'");
        $conne->freeRun("UPDATE users SET AccVerifyAuth = '' WHERE AccVerifyAuth = '$authkey'");
        echo "<script>window.location.replace('index.php');</script>";
        die();
    }
?>