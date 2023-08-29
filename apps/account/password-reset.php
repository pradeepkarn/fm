<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Login"; ?>
<?php import("apps/view/inc/header.php"); ?>
<?php import("apps/view/inc/nav.php"); ?>
<section style="min-height: 100vh; background-image: url(/<?php echo media_root; ?>/nav-bg.jpeg); 
background-position: center;">
    <div class="container">
        <div class="row" style="padding-top: 220px;">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            </head>          
            <main class="form-signin">
            <form action="" method="post">
                <h1 class="h1 mb-3 fw-bold text-center">Reset Password</h1>
                <div class="form-floating">
                <input required type="email" class="form-control mb-1" id="floatingInput" name="email" placeholder="Email">
                <label for="floatingInput">Email</label>
                </div>
                <div class="checkbox mb-3">
                <label>
                    Want to create a new <a href="/<?php echo home; ?>/account/register">account</a> ?
                </label>
                </div>
                <button class="w-100 btn btn-lg btn-outline-secondary mb-1" type="submit">Email Rest Link</button>
                <?php msg('msg_signin'); ?>
                <input type="hidden" name="reset_my_account_pass" value="true">
            </form>
            </main>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</section>
 <?php import("apps/view/inc/footer.php"); ?>