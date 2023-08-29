<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<style>
.list-none li{
    font-weight: bold;
}
.menu-col{
    min-height: 250px !important;
}
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php if(PASS): ?>
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (PASS)?"10":"12"; ?>">
            <?php import("apps/admin/pages/page-nav.php"); ?>
                <div class="row">
                <?php if(PASS): ?>
                    <div class="col-md-4 mb-2">
                        <div class="card menu-col shadow">
                        <div class="card-header">
                        <h3><i class="fa-solid fa-boxes-stacked"></i> Manage Plugins </h3>
                        </div>
                        <div class="card-body" style="background-color:rgba(0,255,0,0.3); background-image: url(/<?php echo media_root; ?>/settings.png);">
                            <ul class="list-none">
                                
                                <?php if(is_superuser()==true): ?>
                                    <li><a href="/<?php echo home; ?>/admin/categories">Categories</a></li>
                                  
                                <?php endif; ?>
                                <!-- <li>Manage Categories</li> -->
                            </ul>
                        </div>
                    </div>
                    </div>
                    <?php endif; ?>
                    <?php if(is_superuser()==true): ?>
                    <div class="col-md-4 mb-2">
                        <div class="card menu-col shadow">
                        <div class="card-header">
                        <h3><i class="fa-solid fa-envelopes-bulk"></i> Manage Users</h3>
                        </div>
                        <div class="card-body" style="background-color:rgba(0,255,0,0.3); background-image: url(/<?php echo media_root; ?>/settings.png);">
                            <ul class="list-none">
                             
                                <li class=""><a href="/<?php echo home; ?>/admin/users/?user_group=user">Users</a></li>
                               
                            </ul>
                        </div>
                    </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>