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
                <h4 class="card-title mt-3 text-center">Login With</h4>
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
                        <h5>Enter your email address here</h5>
                    </div> 
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email_label" class="form-control input_user" placeholder="Email address" type="email">
                    </div> 
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button name="ResetPass" type="submit" class="btn login_btn">Login</button>
                    </div>
                </form>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    Don't have an account? 
                    <a href="register.php" class="ml-2">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<?php
if(isset($_POST['ResetPass']) && isset($_POST['email_label']) && $_POST['email_label'] != '') {
    require './vendor/autoload.php';
    $Email = $_POST['email_label'];
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    $mail->isSMTP();
    $mail->isHTML(true);
    $mail->Host = mailConfig::SMTP_HOST;

    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
    );

    $mail->Port = mailConfig::SMTP_PORT;
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    $mail->Username = mailConfig::SMTP_USER;
    $mail->Password = mailConfig::SMTP_PASSWORD;
    
    $mail->setFrom('aics@support.com', 'AICS');
    $mail->addReplyTo('noreply@example.com','AICS');
    $mail->addAddress($Email);

    if($conne->selectRowCount("SELECT * FROM users WHERE email = '$Email'") != 0){
        $cryptokey = Functions::RandomString();
        $conne->freeRun("UPDATE users SET resetPassAuth = '$cryptokey' WHERE email = '$Email'");
    }else{
        echo '<script>alert("This mail adress is not registered to our system");</script>';
        die();
    }

    $emailTemplate = file_get_contents("emails/reset-password.html");
    $emailTemplate = str_replace("{action_link}", "http://www.atakde.site/verifypass.php?key=".$cryptokey, $emailTemplate);
    $emailTemplate = str_replace("{type_of_action}", "reset password", $emailTemplate);
    
    $mail->Subject = 'Reset Password';
    $mail->Body = $emailTemplate;
    
    if (!$mail->send()) {
        echo 'Mailer Error: '. $mail->ErrorInfo;
    } else {
        echo '<script>alert("Mail has been sent to your email address.");</script>';
    }

}
?>