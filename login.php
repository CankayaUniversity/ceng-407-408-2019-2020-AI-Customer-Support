<?php include "header.php"; ?>

<div class="container">
    <div class="row">
        <form id="form1" name="form1" action="girisisle.php" method="post">
            <div class="col-md-12">
                <hr>
            </div>

            <div class="form-group">
                <label for="InputEmail1">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="" required>
            </div>
            <div class="form-group">
                <label for="InputEmail1">Password</label>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" value="" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>

        </form>
    </div>
</div>