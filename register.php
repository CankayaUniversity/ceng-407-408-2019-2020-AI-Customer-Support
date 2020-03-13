<?php 
include "header.php";
?>
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="../images/mascot.png" class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form>
                    <h4 class="card-title mt-3 text-center">Create Account</h4>
                    <p class="text-center">Get started with your free account</p>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="Firstname" class="form-control input_user" placeholder="First name" type="text">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input id="Lastname" class="form-control input_user" placeholder="Lastname" type="text">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fas fa-user"></i> </span>
                        </div>
                        <input id="Username" class="form-control input_user" placeholder="Username" type="text">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fas fa-envelope"></i> </span>
                        </div>
                        <input id="Email" class="form-control input_user" placeholder="Email Address" type="email">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fas fa-lock"></i> </span>
                        </div>
                        <input id="Password" class="form-control input_user" placeholder="Create password" type="password">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input id="ConfirmPassword" class="form-control input_user" placeholder="Repeat password" type="password">
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" onclick="registerProcess()" class="btn login_btn"> Create Account  </button>
                    </div>
                </form>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                Have an account? <a href="#" class="ml-2">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>