<?php 
include "header.php";
if ($sUsername != null){
    echo "<script>window.location.replace('index.php');</script>";
}
?>
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="../images/mascot.png" class="brand_logo" alt="Logo_login">
                </div>
            </div>
            <div class="user_card-header">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <div class="d-flex justify-content-center">
                <a class="btn btn-primary social-login-btn social-facebook" href="#"><i class="fa fa-facebook"></i></a>
                <a class="btn btn-primary social-login-btn social-twitter" href="#"><i class="fa fa-twitter"></i></a>
                <a class="btn btn-primary social-login-btn social-google" href="#"><i class="fa fa-google-plus"></i></a>
            </div>
                </div>
            <div class="d-flex justify-content-center form_container">
                <form method="post">
                    <div class="login-or">
                        <hr class="hr-or">
                        <span class="span-or"> OR </span>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email_label" class="form-control input_user" placeholder="Email address" type="email">
                    </div> 
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fas fa-key"></i> </span>
                        </div>
                        <input name="password_label" class="form-control input_pass" placeholder="Password" type="password">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                            <label class="custom-control-label" for="customControlInline">Remember me</label>
                        </div>
                    </div>
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button name="LoginSystem" type="submit" class="btn login_btn">Login</button>
                        </div>
                </form>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    Don't have an account? <a href="register.php" class="ml-2">Sign Up</a>
                </div>
                <div class="d-flex justify-content-center links">
                    <a href="#">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<?php
if(isset($_POST['LoginSystem']) && isset($_POST['email_label']) && $_POST['email_label'] != '' && $_POST['password_label'] != '' && isset($_POST['password_label'])) {
    $Email = $_POST['email_label'];
    $Password = trim($_POST['password_label']);
    $options = array("cost" => 4);
    $hashPassword = password_hash($Password, PASSWORD_BCRYPT, $options);

    $query = $conn->query("SELECT * FROM users WHERE email='$Email'", PDO::FETCH_ASSOC)->fetch();
    if (isset($query)) {
        if (password_verify($Password, $query['password_'])) {
            $_SESSION["user_UserID"] = $query['user_id'];
            $_SESSION["user_Username"] = $query['username'];
            $_SESSION["user_Firstname"] = $query['firstname'];
            $_SESSION["user_Surname"] = $query['surname'];
            $_SESSION["user_isAdmin"] = $query['is_admin'];
            $_SESSION["user_isVerified"] = $query['is_verified'];
            $_SESSION["user_Email"] = $Email;
            echo "<script>window.location.replace('index.php');</script>";
            die();
        } else {
            echo "<script>alert('Your email and password does not match.');</script>";
        }
    }
}
?>