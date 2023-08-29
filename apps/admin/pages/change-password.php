<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>

<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php if(getAccessLevel()<=5): ?>
            <div id="sidebar-col" class="col-md-2 bg-dark">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (getAccessLevel()<=5)?"10":"12"; ?>">
            <!-- conetent starts -->
            <?php import("apps/admin/pages/page-nav.php"); ?>

            <section id="page" class="mt-2">
                <div id="res"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header shadow">
                                <h3>Change Password</h3>
                            </div>
                            <div class="card-body">
                            <?php if (authenticate()==true): 
                                    $ac = new Account();
                                    $user = $ac->getLoggedInAccount();
                                    if($user!=false){ ?>
                                    <h4><?php echo $user['email']; ?></h4>
                                    <hr>
                                    <label for="">Old Password</label>
                                   <input type="password" name="old_pass" class="change-pass form-control mb-1">
                                   <label for="">New Password</label>
                                   <input type="password" name="new_pass" class="change-pass form-control mb-1">
                                   <label for="">Confirm New Password</label>
                                   <input type="password" name="cnf_new_pass" class="change-pass form-control mb-1">
                                   <button id="change-password" class="btn btn-success">Submit</button>
                                   <?php pkAjax("#change-password","/admin/change-my-password",".change-pass","#res"); ?>
                                   <?php  }
                                    endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </section>



            <!-- content ends -->
            
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>