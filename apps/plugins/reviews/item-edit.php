<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$id = 0;
if (isset($_GET['rid'])) {
    $id = $_GET['rid'];
}
$plugin_dir = "reviews";
$bkmrks = new Model('bookmarks');
$reviews = $bkmrks->filter_index(['content_group' => 'star-rating', 'id' => $id]);
if (count($reviews) == 1) :
    $bk = obj($reviews[0]);
    $user = obj(getData('pk_user', $bk->user_id));
    $salon = obj(getData('content', $bk->content_id));
    $vendor = obj(getData('pk_user', $salon->created_by));
    $star = showStars($rating = $bk->detail);
endif;
?>
<?php

// if (isset($_POST['update_banner'])) {
//     $contentid = $_POST['update_banner_page_id'];
//     $banner=$_FILES['banner'];
//     $banner_name = uniqid("banner_").time().USER['id'];
//     // print_r($_FILES);
//     change_my_banner($contentid,$banner,$banner_name);
//     msg_ssn();
// }

?>
<style>
    .list-none li {
        font-weight: bold;
    }

    .menu-col {
        min-height: 300px !important;
    }
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <!-- Main Area -->
            <div id="content-col" class="col-md-10 pb-5">
                <?php import("apps/admin/pages/page-nav.php"); ?>
                <h4>Bookings</h4>
                <a class="btn btn-dark my-2" href="/<?php echo home . "/admin/" . $plugin_dir; ?>">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <?php
                            if (count($reviews) == 1) :
                                $bk = obj($reviews[0]);
                                $user = obj(getData('pk_user', $bk->user_id));
                                $salon = obj(getData('content', $bk->content_id));
                                $vendor = obj(getData('pk_user', $salon->created_by));
                                $star = showStars($rating = $bk->detail);
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>

            <?php ajaxActive(".progress"); ?>


            <!-- Main Area ends-->
        </div>
    </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>