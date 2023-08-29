<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Login"; ?>
<?php import("apps/view/inc/header.php"); ?>
<?php import("apps/view/inc/nav.php"); ?>
<section style="min-height: 100vh; background-image: url(/<?php echo media_root; ?>/nav-bg.jpeg); 
background-position: center;">
    <div class="container">
        <div class="row" style="padding-top: 120px;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            </head>          
            <main class="form-signin">
            <form action="" method="post">
                <!-- <img class="mb-4" src="/<?php //echo media_dir;?>/logo/logo.png" alt="" width="auto" height="57"> -->
                <h1 class="h1 mb-3 fw-bold text-center">Sign In</h1>

                <div class="form-floating">
                <input type="text" class="form-control mb-1" id="floatingInput" name="email" placeholder="Email or username">
                <label for="floatingInput">Email or username</label>
                </div>
                <div class="form-floating">
                <input type="password" class="form-control mb-1" id="floatingPassword" name="password" placeholder="Password">
                <label for="floatingPassword">Password</label>
                </div>

                <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me <br>
                    Want to create a new <a href="/<?php echo home; ?>/signup">account</a> ? <br>
                    Forgot password <a href="/<?php echo home; ?>/account/password-reset">Reset Here</a> 
                </label>
                </div>
                <button class="w-100 btn btn-lg btn-outline-secondary mb-1" type="submit">Sign in</button>
                <?php msg('msg_signin'); ?>
                <input type="hidden" name="login_my_account" value="true">
            </form>
            </main>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</section>
 <?php import("apps/view/inc/footer.php"); ?>