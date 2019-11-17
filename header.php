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

    <title>AI Customer Support</title>

    <link rel="shortcut icon" href="images/favicon.png" />

    <!-- Fonts-->
    <script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

    <!-- Style Sheet-->
    <link rel='stylesheet' id='bootstrap-css-css' href='css/bootstrap.css' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive-css-css' href='css/res.css' type='text/css' media='all' />
    <link rel='stylesheet' id='main-css-css' href='css/site.css' type='text/css' media='all' />

</head>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">AI Customer Support</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>