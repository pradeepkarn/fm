<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php
$page = new Dbobjects();
$page->tableName = "content";
$page = $page->pk($GLOBALS['url_last_param']);
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


                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="row">
                                    <div class="col-md-6 hide">
                                        <h3>Parent Category</h3>
                                        <?php
                                        $catData = multilevel_categories($parent_id = 0, $radio = true); ?>
                                        <select required class="update_page form-control" name="parent_id" id="cats">
                                            <option value="0" selected>Parent</option>
                                            <?php echo display_option($nested_categories = $catData, $mark = ''); ?>
                                        </select>
                                        <script>
                                            var exists = false;
                                            $('#cats option').each(function() {
                                                if (this.value == '<?php echo $page['parent_id']; ?>') {
                                                    $("#cats").val("<?php echo $page['parent_id']; ?>");
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="col-md-4 hide">
                                        <h3>Content Type</h3>
                                        <select name="page_content_type" class="update_page form-control mb-2 mt-2">
                                            <option <?php if ($page['content_type'] == 'page') {
                                                        echo "selected";
                                                    } ?> value="page">Page</option>
                                            <option <?php if ($page['content_type'] == 'post') {
                                                        echo "selected";
                                                    } ?> value="post">Post</option>
                                            <option <?php if ($page['content_type'] == 'service') {
                                                        echo "selected";
                                                    } ?> value="service">Service</option>
                                            <option <?php if ($page['content_type'] == 'slider') {
                                                        echo "selected";
                                                    } ?> value="slider">Slider</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Status</h3>
                                        <select name="page_status" class="update_page form-control mb-2 mt-2">
                                            <option <?php if ($page['status'] == 'draft') {
                                                        echo "selected";
                                                    } ?> value="draft">Draft</option>
                                            <option <?php if ($page['status'] == 'listed') {
                                                        echo "selected";
                                                    } ?> value="listed">Listed</option>
                                            <option <?php if ($page['status'] == 'trash') {
                                                        echo "selected";
                                                    } ?> value="trash">Trash</option>
                                        </select>
                                    </div>
                                </div>

                                <h5>Category Name</h5>
                                <input type="text" name="page_title" class="form-control mb-2 update_page" value="<?php echo $page['title']; ?>">
                                <!-- <h5>Title in English </h5>
                    <input type="text" name="page_content_info" class="form-control mb-2 update_page" value="<?php //echo $page['content_info']; 
                                                                                                                ?>"> -->
                                <input type="checkbox" <?php matchData($page['show_title'], 1, "checked"); ?> name="page_show_title" class="update_page">
                                <?php matchData($page['show_title'], 0, "Check to show Page Title"); ?>
                                <?php matchData($page['show_title'], 1, "Uncheck to hide Page Title"); ?> &nbsp;
                                <a target="_blank" href='<?php echo "/" . home . "/{$page['slug']}"; ?>'>View</a> &nbsp;
                                <?php $var = "/" . home . "/page/delete/" . $page['id'];
                                $dltlink = "<a style='color: red;' href='{$var}'>Delete Page</a>";
                                matchData($page['status'], 'trash', $dltlink); ?> &nbsp;
                                <!-- <a data-bs-toggle="modal" data-bs-target="#GalleryModel">Add Image</a> -->

                                <h4>Details <i class="fas fa-arrow-down"></i></h4>
                                <textarea name="page_content" class=" form-control mb-2 update_page" rows="10"><?php echo $page['content']; ?></textarea>
                                <!-- <h5>Category Name In Arabic</h5> -->
                                <!-- <input type="text" name="page_content_info" class="form-control mb-2 update_page" value="<?php echo $page['content_info']; ?>"> -->
                                <!-- <h4>Category Details in arabic <i class="fas fa-arrow-down"></i></h4> -->
                                <!-- <textarea name="page_other_content" class=" form-control mb-2 update_page" rows="10"><?php echo $page['other_content']; ?></textarea> -->
                                <input type="text" onkeyup="createSlug('page_slug_edit', 'page_slug_edit');" id="page_slug_edit" name="slug" class="form-control mb-2 update_page" value="<?php echo $page['slug']; ?>">
                                <input type="hidden" name="page_id" class="form-control mb-2 update_page" value="<?php echo $page['id']; ?>">
                                <input type="hidden" name="update_page" class="form-control mb-2 update_page" value="update_page">
                                <div class="d-grid mb-5">
                                    <button id="update_page_btn" class="btn btn-lg btn-secondary">Update</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a class="btn btn-dark mx-2" href="/<?php echo home; ?>/admin/categories">Back</a>
                                <form action="/<?php echo home; ?>/admin/categories/edit/<?php echo $page['id']; ?>" method="post" enctype="multipart/form-data">
                                    <h3>Featured Image</h3>
                                    <div class="card mb-2">
                                        <img id="banner-img" style="max-height: 200px; width: 100%; object-fit: contain;" src="/<?php echo media_root; ?>/images/pages/<?php echo $page['banner']; ?>" alt="">
                                    </div>
                                    <h4>Change Featured Image</h4>
                                    <input accept="image/*" type="file" name="banner" class="form-control mb-2">
                                    <input type="hidden" name="update_banner" value="update_banner">
                                    <input type="hidden" name="update_banner_page_id" value="<?php echo $page['id']; ?>">
                                    <input type="hidden" name="update_banner_page_slug" value="<?php echo $page['slug']; ?>">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-secondary">Change Image</button>
                                    </div>
                                </form>
                                <p class="bg-warning text-dark">
                                    <?php msg_ssn(); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>



                <script>
                    $(document).ready(function() {
                        $('#update_page_btn').click(function(event) {
                            event.preventDefault();
                            tinyMCE.triggerSave();
                            $.ajax({
                                url: "/<?php echo home; ?>/admin/categories/edit/<?php echo $page['id']; ?>/update",
                                method: "post",
                                data: $('.update_page').serializeArray(),
                                dataType: "html",
                                success: function(resultValue) {
                                    $('#alertResult').html(resultValue)
                                }
                            });
                        });
                    });
                </script>
                <div id="alertResult"></div>

             





                <!-- Main Area ends-->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>