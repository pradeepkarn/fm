<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php if(getAccessLevel()<=5): ?>
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (getAccessLevel()<=5)?"10":"12"; ?>">
            <!-- conetent starts -->
            <?php import("apps/admin/pages/page-nav.php"); ?>
            <section id="page" class="mt-2">




                <?php $page = "locations"; ?>
                <?php import("apps/admin/components/$page/locations.php"); ?>  
                <?php import("apps/admin/components/$page/location-list.php"); ?>  
                
    
            </section>
            <!-- content ends -->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>