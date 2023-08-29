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
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header shadow">
                                <h3>My Profile</h3>
                            </div>
                            <div class="card-body">
                            <?php if (authenticate()==true): 
                                    $adr = getAddress($_SESSION['user_id']);
                                    $ac = new Account();
                                    $user = $ac->getLoggedInAccount();
                                    if($user!=false){ ?>
                                   <p>Name: <b><?php echo $user['name']; ?></b></p>
                                    <p>Mobile: <?php echo $user['mobile']; ?></p>
                                    <p>Email: <?php echo $user['email']; ?></p>
                                    <a href="/<?php echo home; ?>/admin/edit-account" class="btn btn-outline-success"><i class="fa-solid fa-file-pen"></i> Edit</a>
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