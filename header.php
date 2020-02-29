<?php

session_start();

ini_set('display_errors', 1);
error_reporting(-1); 

include 'helpers/helperMeta.php';
include 'helpers/homeController.php';
include 'helpers/helperDev.php';

$conne = new Mysql();
$conn = $conne->dbConnect();

if (isset($_SESSION['user_Username'])) {
    $sUsername = $_SESSION['user_Username'];
    $userid = $_SESSION['user_UserID'];
    HomeController::getNCount($userid);
} else {
  $sUsername = null;
}
$isAdmin = 0;
if(isset($_SESSION["user_isAdmin"])) {
  $isAdmin = $_SESSION["user_isAdmin"];
}

?>

<!doctype html>
<html lang="en-US">
<head>
    <!-- META TAGS -->

    <?php if (preg_match('/post|category|author|profile/', $_SERVER['REQUEST_URI'])) {
    if(preg_match('/post/', $_SERVER['REQUEST_URI'])){
        
        if (isset($_GET['post'])) {
            $post_slug = $_GET['post'];
        }
        $query = $conn->query("SELECT * FROM questions WHERE slug='$post_slug'",PDO::FETCH_ASSOC);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($r=$query->fetch()){
            $title_meta = $r["title_meta"];
            $description_meta = $r["description_meta"];
            $keywords_meta = $r["keywords_meta"];
        }
    }
    else if(preg_match('/category/', $_SERVER['REQUEST_URI'])) {
        
        if (isset($_GET['category'])) {
            $category_slug = $_GET['category'];
        }
        $query = $conn->query("SELECT * FROM categories WHERE cat_id='$category_slug'",PDO::FETCH_ASSOC);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($r=$query->fetch()){
            $title_meta = $r["cat_name"];
            $description_meta = $r["cat_description"];
            $keywords_meta = $r["cat_keywords"];
        }
    }
    else if(preg_match('/author/', $_SERVER['REQUEST_URI'])) {
        if (isset($_GET['author'])) {
            $author = $_GET['author'];
        }
        $query = $conn->query("SELECT * FROM users WHERE username='$author'",PDO::FETCH_ASSOC);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($r=$query->fetch()){
          $fullname = $r["firstname"]." ";
          $fullname.=$r["surname"];
            $title_meta = $fullname."'s Profile Page";
            $description_meta = "Eklenecek";
            $keywords_meta = $fullname;
        }
    }
    else if(preg_match('/profile/', $_SERVER['REQUEST_URI'])) {
      $metaUserID = $_SESSION["user_UserID"];
      $query = $conn->query("SELECT * FROM users WHERE user_id='$metaUserID'",PDO::FETCH_ASSOC);
      $query->setFetchMode(PDO::FETCH_ASSOC);
      while($r=$query->fetch()){
        $fullname = $r["firstname"]." ";
        $fullname.=$r["surname"];
          $title_meta = $fullname."'s Profile Page";
          $description_meta = "Eklenecek"; //TODO
          $keywords_meta = $fullname;
      }
  }
    ?>
    <meta name="keywords" content="<?php echo $keywords_meta ?>" />
    <meta name="robots" content="<?php echo helperMeta::getDescriptions('robots') ?>" />
    <meta name="description" content="<?php echo $description_meta ?>" />
    <title><?php echo $title_meta ?></title>
    <?php } else { ?>
    <meta name="keywords" content="<?php echo helperMeta::getDescriptions('keywords') ?>" />
    <meta name="robots" content="<?php echo helperMeta::getDescriptions('robots') ?>" />
    <meta name="description" content="<?php echo helperMeta::getDescriptions('description') ?>" />
    <title>AI Customer Support</title>
    <?php } ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />


    <!-- Fonts-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

    <!-- Style Sheet-->
    <script src="/js/jquery.min.js"></script>
    <link rel='stylesheet' id='responsive-css-css' href='/css/res.css' type='text/css' media='all' />
    <link rel='stylesheet' id='main-css-css' href='/css/site.css' type='text/css' media='all' />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript" src="/js/site.js"></script>

</head>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-inverse navbar-custom" id="navbar">
  <div class="container">
    <a class="navbar-brand" href="/index.php">AI Customer Support</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <div class="btn-group">
          <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="header-category">Categories</span>
          </button>
          <div class="dropdown-menu">
            <?php foreach ($conne->selectAll('categories') as $key) { ?>
            <?php $cat_slug = "/category/".$key["cat_slug"]; ?>
            <a class="dropdown-item" href="<?php echo $cat_slug ?>"><?php echo $key['cat_name']; ?></a>
            <?php } ?>
          </div>
        </div>
        <?php if ($isAdmin == 1): ?>
        <li class="nav-item">
          <a class="nav-link" role="button" href="/admin/index.php" aria-expanded="false" aria-controls="collapseExample">Admin Panel</a>
        </li>
        <?php endif; ?>
        <?php if ($sUsername == null): ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" href="#registerModal" role="button" aria-expanded="false" aria-controls="collapseExample">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" href="#loginModal" role="button" aria-expanded="false" aria-controls="collapseExample">Login</a>
        </li>
        <?php endif;?>
        <?php if ($sUsername !== null): ?>
          <li class="nav-item">
          <div class="dropdown nav-button notifications-button hidden-sm-down">
            <a class="btn btn-secondary dropdown-toggle" href="#" id="notifications-dropdown" onclick="resetNoti();" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i id="notificationsIcon" class="fa fa-bell-o" aria-hidden="true"></i>
              <span id="notificationsBadge" class="badge badge-danger"><i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i></span>
            </a>
            <!-- NOTIFICATIONS -->
            <div class="dropdown-menu notification-dropdown-menu" aria-labelledby="notifications-dropdown">
              <h6 class="dropdown-header">Notifications</h6>
              <!-- LOADING -->
              <a id="notificationsLoader" class="dropdown-item dropdown-notification" href="#">
                <p class="notification-solo text-center"><i id="notificationsIcon" class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i> Notifications are loading... </p>
              </a>
              <div id="notificationsContainer" class="notifications-container">
              </div>
              <!-- NO NOTIFICATION -->
              <a id="notificationAucune" class="dropdown-item dropdown-notification" href="#">
                <p class="notification-solo text-center">No New Notification</p>
              </a>
              <!-- ALL -->
              <a class="dropdown-item dropdown-notification-all" href="#">
                See all notifications
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/logout.php">Logout</a>
        </li>
        <?php endif;?>
      </ul>
    </div>
  </div>
</nav>
<!-- The Login Modal -->
<div class="modal fade seminor-login-modal" data-backdrop="static" id="loginModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body seminor-login-modal-body">
        <h5 class="modal-title text-center">LOGIN MY ACCOUNT!</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span><i class="fa fa-times-circle" aria-hidden="true"></i></span>
        </button>
        <form class="seminor-login-form">
          <div class="form-group">
            <input type="email" class="form-control" id="email_label" aria-describedby="emailHelp" placeholder="Email" required autocomplete="off">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="password_label"  placeholder="Password" required autocomplete="off">
          </div>
          <div class="form-group">
            <label class="container-checkbox">
              Remember Me On This Computer
              <input type="checkbox" checked="checked" required>
              <span class="checkmark-box"></span>
            </label>
          </div>
          <div class="btn-check-log">
            <button type="submit" id="login_button" onclick="loginProcess()" class="btn-check-login">LOGIN</button>
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
        <form class="seminor-login-form" name="SignUp">
          <div class="form-group">
            <input type="text" name="Firstname" id="Firstname" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="Firstname">First Name</label>
          </div>
          <div class="form-group">
            <input type="text" name="Lastname" id="Lastname" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="Lastname">Last Name</label>
          </div>
          <div class="form-group">
            <input type="text" name="Username" id="Username" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="Username">User Name</label>
          </div>
          <div class="form-group">
            <input type="email" name="Email" id="Email" class="form-control" required autocomplete="off">
            <label class="form-control-placeholder" for="Email">Email address</label>
          </div>
          <div class="form-group">
            <input type="password" name="Password" id ="Password" class="form-control" required autocomplete="off" onkeyup='check();'>
            <label class="form-control-placeholder" for="Password">Password</label>
          </div>
          <div class="form-group">
            <input type="password" name="ConfirmPassword" id="ConfirmPassword" class="form-control" required autocomplete="off" onkeyup='check();'>
            <label class="form-control-placeholder" for="ConfirmPassword">Confirm Password</label>
            <span id='message'></span>
          </div>
          <div class="form-group forgot-pass-fau text-center ">
            <a href="/terms-conditions/" class="text-secondary">
              By clicking "SIGN UP" you accept our<br>
              <span class="text-primary-fau">Terms and Conditions</span>
            </a>
          </div>
          <div class="btn-check-log">
            <button type="submit" name="SignUp" id="SignUp" onclick="registerProcess()" class="btn-check-login">SIGN UP</button>
          </div>
          <div class="create-new-fau text-center pt-3">
            <a href="#" class="text-primary-fau"><span data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Already have an account?</span></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="/js/site.js"></script>
<script id="notificationTemplate" type="text/html">
    <!-- NOTIFICATION -->
    <a class="dropdown-item dropdown-notification" href="{{href}}">
      <div class="notification-read">
        <i class="fa fa-times" aria-hidden="true"></i>
      </div>
      <img class="notification-img" src="https://placehold.it/48x48" alt="Icone Notification" />
      <div class="notifications-body">
        <p class="notification-texte">{{texte}}</p>
        <p class="notification-date text-muted">
          <i class="fa fa-clock-o" aria-hidden="true"></i> {{date}}
        </p>
      </div>
    </a>
</script>
<?php
if (isset($userid)) {
    HomeController::getNotifications($userid);
}
?>

<script>
function resetNoti(){ 
  var user_id = <?php echo $userid; ?>;
  var action = "resetNoti";
  $.ajax({
    url: "/action.php",
    method: "POST",
    data: {
      action: action,
      user_id: user_id,
    },
    success: function(response) {
      if (response) {
      }
    }
  });
}
</script>

