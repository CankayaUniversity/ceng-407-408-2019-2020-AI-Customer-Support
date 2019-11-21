<?php 
include '/helpers/helperMeta.php';
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

    <script type="text/javascript" src="js/site.js"></script>

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
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" href="#registerModal" role="button" aria-expanded="false" aria-controls="collapseExample">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" href="#loginModal" role="button" aria-expanded="false" aria-controls="collapseExample">Login</a>
                </li>
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
                        <input type="email" class="form-control" required autocomplete="off">
                        <label class="form-control-placeholder" for="name">Email address</label>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" required autocomplete="off">
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
                        <button type="submit" class="btn-check-login">LOGIN</button>
                    </div>
                    <div class="forgot-pass-fau text-center pt-3">
                        <a href="/reset_pass" class="text-secondary">Forgot Your Password?</a>
                    </div>
                    <div class="create-new-fau text-center pt-3">
                            <a href="#" class="text-primary-fau"><span data-toggle="modal" data-target="#sem-reg" data-dismiss="modal">Create A New Account</span></a>
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
        <form class="seminor-login-form">
          <div class="form-group">
            <input type="name" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">User Name</label>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">Email address</label>
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
          <div class="form-group">
            <input type="tel" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">Phone Number</label>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">Organization</label>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">Designation</label>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="name">City</label>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="password">Password</label>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="password">Confirm Password</label>
          </div>
          <div class="form-group forgot-pass-fau text-center ">
            <a href="/terms-conditions/" class="text-secondary">
              By Clicking "SIGN UP" you accept our<br>
              <span class="text-primary-fau">Terms and Conditions</span>
            </a>
          </div>
          <div class="btn-check-log">
            <button type="submit" class="btn-check-login">SIGN UP</button>
          </div>
          <div class="create-new-fau text-center pt-3">
            <a href="#" class="text-primary-fau"><span data-toggle="modal" data-target="#sem-login" data-dismiss="modal">Already Have An Account</span></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
