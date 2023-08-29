<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-col" class="col-md-2 bg-dark">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <!-- Main Area -->
            <div id="content-col" class="col-md-10">
            <?php import("apps/admin/pages/page-nav.php"); ?>
            
            <form action="/<?php echo home; ?>/gallery/upload" method="post" enctype="multipart/form-data">
            <?php csrf_token(); ?>
        <div class="row py-5">
            <div class="col-md-6">
                <input type="text" required placeholder="Media Title" name="media_title" class="form-control">
            </div>
            <div class="col-md-4">
                <input type="file" name="media_file" class="form-control">
            </div>
            <div class="col-md-2">
                <div class="d-grid">
                <button class="btn btn-primary"> UPLOAD <i class="fas fa-upload"></i> </button>
                </div>
            </div>
            </div>
        </form>
            <!-- Main Area Ends -->
            </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>