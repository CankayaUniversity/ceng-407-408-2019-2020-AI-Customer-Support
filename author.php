<?php 
include 'header.php';

if (isset($_GET['author'])) {
    $username = $_GET['author'];
}

$r = $conn->query("SELECT * FROM users WHERE username='$username'",PDO::FETCH_ASSOC)->fetch();
$user_id=$r['user_id'];
$username=$r['username'];
$firstname=$r['firstname'];
$surname=$r['surname'];
$is_admin=$r['is_admin'];
$is_verified=$r['is_verified'];
$email=$r['email']; 

?><br>
<div class="margin-botton">
    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center">
                        <img src="/images/avatar.png" class="avatar img-circle img-thumbnail" alt="avatar"> 
                    </div>
                    <br>
                    <ul class="list-group">
                        <li class="list-group-item text-muted">Status</li>
                        <li class="list-group-item text-right"><span style="float: left"><strong>Questions asked</strong></span> 
                            <?php
                                $sql="SELECT * FROM questions WHERE q_author='$user_id'";
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
                                            <p><?php echo $firstname; ?></p>
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
                                            <?php echo $surname; ?>
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
                                            <?php echo $email; ?>
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
                                            <?php echo $username; ?>
                                        </div>
                                    </div><hr>
                                </div>
                            </from>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>