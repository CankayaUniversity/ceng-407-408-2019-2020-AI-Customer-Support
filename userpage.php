<?php 
include 'header.php';

if (isset($_GET['post'])) {
    $id = $_GET['post'];
}

if($_SESSION["user_Username"] == null){
    echo"<script>
    window.location.replace('index.php')
    </script>";
}

$query = $conn->query("SELECT * FROM users WHERE user_id='$id'",PDO::FETCH_ASSOC);
if ($count = $query -> rowCount()){
    if($count > 0){
        // Email and password match
        $sql = "SELECT user_id,firstname,surname,username,is_verified,is_admin,email
                FROM users WHERE user_id='$id'";
        $q = $conn->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        while($r=$q->fetch()){
            $_SESSION["user_UserID"]=$r['user_id'];
            $_SESSION["user_Username"]=$r['username'];
            $_SESSION["user_Firstname"]=$r['firstname'];
            $_SESSION["user_Surname"]=$r['surname'];
            $_SESSION["user_isAdmin"]=$r['is_admin'];
            $_SESSION["user_isVerified"]=$r['is_verified'];
            $_SESSION["user_Email"]=$r['email'];
        }
    }
}

?>

<hr>
<div class="container bootstrap snippet">
    <div class="row">
        <div class="col-md-3">
            <div class="text-center">
                <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar"> 
            </div>
            <br>
            <ul class="list-group">
                <li class="list-group-item text-muted">Status</li>
                <li class="list-group-item text-right"><span style="float: left"><strong>Questions asked</strong></span> 
                    <?php
                        $sql="SELECT * FROM questions WHERE q_author='$id'";
                        $q = $conn->query($sql);
                        $q->setFetchMode(PDO::FETCH_ASSOC);
                        $count=0;
                        while($r=$q->fetch()){
                            $count++;
                        }
                        echo $count;
                    ?>
                </li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <form id="form1" name="form1" action="profile.php" method="post"><hr>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="first_name">
                                        <h4><p><strong>First name </strong></p></h4>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <p><?php echo $_SESSION["user_Firstname"]; ?></p>
                                </div>                     
                            </div><hr> 
                        </div>                       
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">  
                                    <label for="last_name">
                                        <h4><p><strong>Last name </strong></p></h4>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $_SESSION["user_Surname"]; ?>
                                </div>                            
                            </div><hr>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5"> 
                                    <label for="email">
                                        <h4><p><strong>Email </strong></p></h4>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $_SESSION["user_Email"]; ?>
                                </div>                              
                            </div><hr>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="Username">
                                        <h4><p><strong>Username </strong></p></h4>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $_SESSION["user_Username"]; ?>
                                </div>
                            </div><hr>
                        </div>
                    </from>
                </div>
            </div>
        </div>
    </div>
</div><hr>
<?php include 'footer.php';?>