<?php

session_start();

/* ini_set('display_errors', 1);
error_reporting(-1); */

include '../inc/Conn.php';

$conne = new Mysql();
$conn = $conne->dbConnect();

if (isset($_SESSION['user_Username'])) {
    header('Location: index.php');
} else {
    $sUsername = null;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin Panel Login - Customer AI Support</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/site.css" rel="stylesheet">

</head>

<script>

$(document).ready(function(){
  $('#login_button').click(function(){
    var email = $('#email_label').val();
    var password = $('#password_label').val();
    var action = 1;
    if(email != '' && password != '')
    {
      $.ajax({
        url:"action.php",
        method:"POST",
        data: {email:email, password:password, action:action},
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
  
  </script>
