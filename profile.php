<?php 
include 'header.php';
session_start();
if($_SESSION["user_Surname"] == null){
    echo"<script>
    window.location.replace('index.php')
    </script>";

 

}
$id=  $_SESSION["user_UserID"];


if( isset($_POST['Username_']) )
{
    $username= $_POST['Username_'];
  
    $query = $conn->query("UPDATE users SET username='$username' WHERE user_id=$id",PDO::FETCH_ASSOC);
    $query->setFetchMode(PDO::FETCH_ASSOC);
                           
}

if( isset($_POST['last_name']) )
{
   
    $lastname = $_POST['last_name'];
  
    $query = $conn->query("UPDATE users SET surname='$lastname' WHERE user_id=$id",PDO::FETCH_ASSOC);
    $query->setFetchMode(PDO::FETCH_ASSOC);
                           
}


if( isset($_POST['first_name']) )
{
   
    $firstname= $_POST['first_name'];
  
    $query = $conn->query("UPDATE users SET firstname='$firstname' WHERE user_id=$id",PDO::FETCH_ASSOC);
    $query->setFetchMode(PDO::FETCH_ASSOC);
                           
}

if( isset($_POST['email']) )
{
   
    $email= $_POST['email'];

    $query = $conn->query("UPDATE users SET email='$email' WHERE user_id=$id",PDO::FETCH_ASSOC);
    $query->setFetchMode(PDO::FETCH_ASSOC);
                           
}



?>

    <hr>
    <div class="container bootstrap snippet">
        <div class="row">
        </div>
        <div class="row">
            <div class="col-sm-3">
                <!--left col-->


                <div class="text-center">
                    <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
                    <h6>
                        
                        </h6>
                    
                </div>
                <br>

                <ul class="list-group">
                    <li class="list-group-item text-muted">Status</li>
                    <li class="list-group-item text-right"><span style="float: left"><strong>Threads</strong></span>
                        11</li>
                    <li class="list-group-item text-right"><span style="float: left"><strong>Likes</strong></span>
                        12</li>
                    <li class="list-group-item text-right"><span style="float: left"><strong>Dislikes</strong></span>
                        13</li>
                </ul>

                <div class="panel panel-default">
                </div>

            </div>
            <!--/col-3-->
            <div class="col-sm-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                    <form id="form1" name="form1" action="profile.php" method="post">
                        <hr>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="first_name">
                                    <h4>First name : <? echo $_SESSION["user_Firstname"]; ?> </h4>
                                </label>
                                <input type="text" class="form-control" name="first_name" id="first_name" title="enter your first name if any.">
                            </div>
                            <hr>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="last_name">
                                    <h4>Last name : <? echo $_SESSION["user_Surname"]; ?></h4>
                                </label>
                                <input type="text" class="form-control" name="last_name" id="last_name"  title="enter your last name if any.">
                            </div>
                            <hr>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="email">
                                    <h4>Email : <? echo $_SESSION["user_Email"]; ?></h4>
                                </label>
                                <input type="email" class="form-control" name="email" id="email"  title="enter your email.">
                            </div>
                            <hr>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="Username">
                                    <h4>Username : <? echo $_SESSION["user_Username"]; ?></h4>
                                </label>
                                <input type="text" class="form-control" name="Username_" id="Username_" title="enter your username.">
                            </div>
                           
                            <hr>
                        </div>

                        <div class="form-group">
                            
                            <div class="col-xs-12">
                            
                            <button class="btn btn-lg btn-success pull-right" id="slideEdit" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Edit</button>
                            
                            <button class="btn btn-lg btn-success pull-right" id="slideSave" name ="slideSave" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            </div>
                        </div>
                      
                        </from>
                    </div>

                  
                    <!--/tab-pane-->
                </div>
              
            </div>
        </div>
</div> <hr>

<!-- <script>
$(document).ready(function(){
    $("#first_name").slideUp();
    $("#last_name").slideUp();
    $("#Username_").slideUp();
    $("#email").slideUp();
    $("#Password_").slideUp();
    $("#slideSave").slideUp();

  $("#slideEdit").click(function(){
    $("#first_name").slideToggle("fast");
    $("#last_name").slideToggle("fast");
    $("#Username_").slideToggle("fast");
    $("#email").slideToggle("fast");
    $("#Password_").slideToggle("fast");
    $("#slideSave").slideToggle("fast");
    $("#slideEdit").slideToggle("fast");
    
  });
  
});
</script> -->
<?php include 'footer.php';?>