<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Register"; ?>
<?php import("apps/view/inc/header.php"); ?>
<?php import("apps/view/inc/nav.php"); ?>
<section style="min-height: 100vh; background-image: url(/<?php echo media_root; ?>/nav-bg.jpeg); 
background-position: center;">
    <div class="container">
        <div class="row" style="padding-top: 120px;">
            <div class="col-md-2"></div>
            <div class="col-md-8">

            </head>                
            <main class="form-signin">
            <form action="" method="post">
                <!-- <img class="mb-4" src="/<?php //echo media_dir;?>/logo/logo.png" alt="" width="auto" height="57"> -->
                <h1 class="h1 mb-3 fw-bold text-center">Registration</h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input required type="email" class="form-control mb-1" id="floatingInput" name="email" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control mb-1" id="floatingPassword" name="mobile" placeholder="Password">
                            <label for="floatingPassword">Mobile</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input required type="password" class="form-control mb-1" id="floatingPassword" name="password" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input required type="password" class="form-control mb-1" id="floatingPassword" name="cnfpassword" placeholder="Confirm Password">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                    </div>
                </div>
                
                <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> <a href="#">I accept the Terms & Conditions</a> <br>
                    Already have an account ? <a href="/<?php echo home; ?>/account/login">Login</a>
                </label>
                </div>
                <input type="hidden" name="create_new_account">
                <button class="w-100 btn btn-lg custom-bg mb-1" type="submit">Register</button>
                <?php msg('msg_signup'); ?>
            </form>
            </main>


            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>
 <?php import("apps/view/inc/footer.php"); ?>