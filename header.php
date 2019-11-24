<?php 
session_start();
include '/helpers/helperMeta.php';
include '/helpers/helperDev.php';
include '/inc/config.php';
//var_dump($_SESSION);
?>

<!doctype html>
<html lang="en-US">

<head>
    <!-- META TAGS -->

    <meta name="keywords" content="<? echo getDescriptions('keywords') ?>" />
    <meta name="robots" content="<? echo getDescriptions('robots') ?>" />
    <meta name="description" content="<? echo getDescriptions('description') ?>" />

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Customer Support</title>

    <link rel="shortcut icon" href="images/favicon.png" />

    <!-- Fonts-->
    <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

    <!-- Style Sheet-->
    <script src="js/jquery.min.js"></script>
    <link rel='stylesheet' id='responsive-css-css' href='css/res.css' type='text/css' media='all' />
    <link rel='stylesheet' id='main-css-css' href='css/site.css' type='text/css' media='all' />
    <link href="css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <script type="text/javascript" src="js/site.js"></script>
    </head>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-inverse navbar-custom" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="#">AI Customer Support</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <? if ($_SESSION["user_Username"] == null) : ?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" href="#registerModal" role="button" aria-expanded="false" aria-controls="collapseExample">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" href="#loginModal" role="button" aria-expanded="false" aria-controls="collapseExample">Login</a>
                </li>
                <? endif; ?>
                <? if ($_SESSION["user_Username"] != null) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="#"><? echo $_SESSION["user_Username"] ?> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <? endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- The Login Modal -->
<div class="modal fade seminor-login-modal" data-backdrop="static" id="loginModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body seminor-login-modal-body">
                <h5 class="modal-title text-center">LOGIN TO MY ACCOUNT</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                </button>
                <form class="seminor-login-form">
                    <div class="form-group">
                        <input type="email" class="form-control" id="email_label" required autocomplete="off">
                        <label class="form-control-placeholder" for="email">Email address</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password_label" required autocomplete="off">
                        <label class="form-control-placeholder" for="password">Password</label>
                    </div>
                    <div class="form-group">
                        <label class="container-checkbox">
                            Remember Me On This Computer
                            <input type="checkbox" checked="checked" required>
                            <span class="checkmark-box"></span>
                        </label>
                    </div>
                    <div class="btn-check-log">
                        <button type="submit" id="login_button" class="btn-check-login">LOGIN</button>
                    </div>
                    <div class="forgot-pass-fau text-center pt-3">
                        <a href="/reset_pass" class="text-secondary">Forgot Your Password?</a>
                    </div>
                    <div class="create-new-fau text-center pt-3">
                            <a href="#" class="text-primary-fau"><span data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Create A New Account</span></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- The Register Modal -->
<div class="modal fade seminor-login-modal" data-backdrop="static" id="registerModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body seminor-login-modal-body">
        <h5 class="modal-title text-center">CREATE AN ACCOUNT</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span><i class="fa fa-times-circle" aria-hidden="true"></i></span>
        </button>
        <form class="seminor-login-form" method="post" name="SignUp">
        <div class="form-group">
            <input type="text" name="Firstname" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">First Name</label>
          </div>
          <div class="form-group">
            <input type="text" name="Lastname" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">Last Name</label>
          </div>
          <div class="form-group">
            <input type="text" name="Username" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">User Name</label>
          </div>
          <div class="form-group">
            <input type="email" name="Email" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">Email address</label>
          </div>
          <div class="form-group">
            <input type="password" name="Password" id ="Password" class="form-control" required autocomplete="off" onkeyup='check();'>
            <label class="form-control-placeholder" for="password">Password</label>
          </div>
          <div class="form-group">
            <input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control" required autocomplete="off" onkeyup='check();'>
            <label class="form-control-placeholder" for="password">Confirm Password</label>
            <span id='message'></span>
          </div>
          <!--
          <div class="form-group">
            <input type="text" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">City</label>
          </div>
          <div class="form-group">
            <label class="select-form-control-placeholder" for="sel1">profession</label>
            <select class="form-control" id="sel1" name="sellist1">
              <option>Select profession</option>
              <option>Students</option>
              <option>Research Scholar</option>
              <option>Professor</option>
              <option>Others</option>
            </select>
          </div>
          -->
          <div class="form-group forgot-pass-fau text-center ">
            <a href="/terms-conditions/" class="text-secondary">
              By Clicking "SIGN UP" you accept our<br>
              <span class="text-primary-fau">Terms and Conditions</span>
            </a>
          </div>
          <div class="btn-check-log">
            <button type="submit" name="SignUp" class="btn-check-login">SIGN UP</button>
          </div>
          <div class="create-new-fau text-center pt-3">
            <a href="#" class="text-primary-fau"><span data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Already Have An Account</span></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function(){  
  $('#login_button').click(function(){  
    var email = $('#email_label').val();  
    var password = $('#password_label').val();  
    if(email != '' && password != '')  
    {
      $.ajax({  
        url:"action.php",  
        method:"POST",  
        data: {email:email, password:password},  
        success:function(response){   
          if(response == '1')  
          {
            $('#loginModal').hide();
            location.reload();    
          }  
          else if (response == '0') 
          {
            alert("Email and password does not match");  
            //location.reload();  
          }
          else if (response == '-1') 
          {
            alert("System-based error");  
            //location.reload();  
          }    
        }  
      });  
    }  
    else  
    {  
      alert("Both Fields are required");  
    }  
  });  
  $('#logout').click(function(){  
    var action = "logout";  
    $.ajax({  
      url:"action.php",  
      method:"POST",  
      data:{action:action},  
      success:function()  
      {  
        location.reload();  
      }  
    });  
  });  
});  

</script>

<?php
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