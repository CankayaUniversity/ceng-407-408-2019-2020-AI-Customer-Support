<?php include "header.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12"><hr></div>
        <div class="col-md-12">
            <h3>Register</h3>
            <form id="form1" name="form1" action="kayitisle.php" method="post">
                <div class="form-group">
                    <label for="InputEmail1">Name</label>
                    <input type="text" name="isim" id="isim" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label for=InputEmail1">Surname</label>
                    <input type="text" name="soyisim" id="soyisim" class="form-control" placeholder="Surname" required>
                </div>
                <div class="form-group">
                    <label for="InputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="InputPassword1">Password</label>
                    <input type="password" class="form-control" minlength="5" name="pass" id="pass" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>