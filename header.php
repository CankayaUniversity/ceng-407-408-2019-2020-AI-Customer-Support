<?php

session_start();

ini_set('display_errors', 1);
error_reporting(-1);

include 'helpers/SEOHelper.php';
include 'helpers/Functions.php';

$conne = new Mysql();
$conn = $conne->dbConnect();

if (isset($_SESSION['user_Username'])) {
    $sUsername = $_SESSION['user_Username'];
    $userid = $_SESSION['user_UserID'];
    Functions::getNCount($userid);
} else {
    $sUsername = null;
}
$isAdmin = 0;
if (isset($_SESSION["user_isAdmin"])) {
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
            $description_meta = htmlspecialchars_decode($r["description_meta"]);
            $keywords_meta = $r["keywords_meta"];
        }
    }
    else if(preg_match('/category/', $_SERVER['REQUEST_URI'])) {
        
        if (isset($_GET['category'])) {
            $category_slug = $_GET['category'];
        }
        $result = $conne->selectFreeRun("SELECT * FROM categories WHERE cat_slug='$category_slug'");
        foreach ($result as $key => $value) {
            $title_meta = $value["cat_name"];
            $description_meta = $value["cat_description"];
            $keywords_meta = $value["cat_keywords"];
        }
    }
    else if(preg_match('/author/', $_SERVER['REQUEST_URI'])) {
        if (isset($_GET['author'])) {
            $author = $_GET['author'];
        }
        $result = $conne->selectFreeRun("SELECT * FROM users WHERE username='$author'");
        foreach ($result as $key => $value) {
            $fullname = $value["firstname"]." " .$value["surname"];
            $title_meta = $fullname."'s Profile Page";
            $description_meta = $fullname."'s Profile Page";
            $keywords_meta = $fullname;
        }
    }
    else if(preg_match('/profile/', $_SERVER['REQUEST_URI'])) {
      $metaUserID = $_SESSION["user_UserID"];
      $result = $conne->selectFreeRun("SELECT * FROM users WHERE user_id='$metaUserID'");
      foreach ($result as $key => $value) {
          $fullname = $value["firstname"]." " .$value["surname"];
          $title_meta = $fullname."'s Profile Page";
          $description_meta = $fullname."'s Profile Page";
          $keywords_meta = $fullname;
      }
  }
    ?>
    <meta name="keywords" content="<?php echo $keywords_meta ?>" />
    <meta name="robots" content="<?php echo SEOHelper::getDescriptions('robots') ?>" />
    <meta name="description" content="<?php echo $description_meta ?>" />
    <title><?php echo $title_meta ?></title>
    <?php } else { ?>
    <meta name="keywords" content="<?php echo SEOHelper::getDescriptions('keywords') ?>" />
    <meta name="robots" content="<?php echo SEOHelper::getDescriptions('robots') ?>" />
    <meta name="description" content="<?php echo SEOHelper::getDescriptions('description') ?>" />
    <title><?php echo SEOHelper::getDescriptions('title') ?></title>
    <?php } ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />


    <!-- Fonts-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>


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
          <a class="nav-link" href="/register.php" role="button" aria-expanded="false" aria-controls="collapseExample">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login.php" role="button" aria-expanded="false" aria-controls="collapseExample">Login</a>
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
<?php
if(isset($_SESSION["user_isVerified"])){
    if($_SESSION["user_isVerified"] == 0){
    echo'<div class="alert alert-warning" id="verify" style="margin-bottom:0px">';
    echo'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
    echo'<center><span><strong>Notice: </strong> Your account is not verified. Please go to your email and verify your account</span></center>';
    echo'</div>';
  }else{
    echo'<script>$("#verify").remove()</script>';
  }
}

?>
<script type="text/javascript" src="/js/site.js"></script>
<script id="notificationTemplate" type="text/html">
    <!-- NOTIFICATION -->
    <a class="dropdown-item dropdown-notification" href="{{href}}">
      <div class="notification-read">
        <i class="fa fa-times" href="#" aria-hidden="true"></i>
      </div>
      <img class="notification-img" src="{{image}}" alt="Icone Notification" />
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
    Functions::getNotifications($userid);
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

