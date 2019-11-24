<?php 
include 'header.php';
session_start();
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
                        <hr>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="first_name">
                                    <h4>First name</h4>
                                </label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<? echo $_SESSION["user_Firstname"]; ?>" title="enter your first name if any.">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="last_name">
                                    <h4>Last name</h4>
                                </label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<? echo $_SESSION["user_Surname"]; ?>" title="enter your last name if any.">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="email">
                                    <h4>Email</h4>
                                </label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="<? echo $_SESSION["user_Email"]; ?>" title="enter your email.">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="last_name">
                                    <h4>Username</h4>
                                </label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="<? echo $_SESSION["user_Username"]; ?>" title="enter your username.">
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-xs-6">
                                <label for="password">
                                    <h4>Password</h4>
                                </label>
                                <input type="password" class="form-control" id="location" placeholder="********" title="enter a password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                            <button class="btn btn-lg btn-success pull-right" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            </div>
                        </div>
                    </div>
                    <!--/tab-pane-->
                </div>
            </div>
        </div>
</div> <hr>
<?php include 'footer.php';?>