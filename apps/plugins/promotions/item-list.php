<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$plugin_dir = "promotions";
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="/<?php echo home; ?>/admin/promotions/add-new-promotion" class="btn btn-primary me-md-2" type="button">Add Promotion Group</a>
                            </div>
                        </div>
                        <div id="res"></div>
                        <table class="table table-hover">
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Promotion Type</th>
                                <th>Action</th>
                            </tr>
                            
                            <?php
                            $obj = new Model('promo_category');
                            $promocat = $obj->index();
                            foreach ($promocat as $pcat): 
                                $content_group = $pcat['name'];
                            $hd = show_promotions($pcat['id']); ?>
                              <tr style="background-color: dodgerblue; color:white;">
                                <th colspan="3">
                                <img style="height: 50px; width:50px; object-fit:cover; border-radius:50%;" src="/<?php echo media_root; ?>/images/pages/<?php echo $pcat['image']; ?>">
                                    <?php echo $content_group; ?>
                                    <a href="/<?php echo home; ?>/admin/promotions/edit-promotion/?promo_id=<?php echo $pcat['id']; ?>">
                                    <i class="fas fa-pen"></i>
                                    </a>
                                </th>
                                <th colspan="1">
                                    <a href="/<?php echo home; ?>/admin/promotions/add-new-item/?id=<?php echo $pcat['id']; ?>&promo=<?php echo $content_group; ?>" class="btn btn-light btn-sm">Add More <i class="fas fa-plus"></i></a>
                                </th>
                            </tr>
                            <?php 
                            foreach ($hd as $key => $pv) :
                                $prod = getData('content', $pv['content_id']);
                                if ($pv['image']==null) {
                                    $pv['image'] = $prod['banner'];
                                }
                            ?>
                          
                                <tr>
                                    <td><img style="height: 50px;" src="/<?php echo media_root; ?>/images/pages/<?php echo $pv['image']; ?>"></td>
                                    <td><?php echo $prod['title']; ?></td>
                                    <td><?php echo $pv['content_group']; ?></td>
                                    <td>
                                        <button id="remove-this-product<?php echo $pv['id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                                        <input type="hidden" class="remove-this-product<?php echo $pv['id']; ?>" name="remove_id" value="<?php echo $pv['id']; ?>">
                                        <?php pkAjax("#remove-this-product{$pv['id']}", "/admin/promotions/remove-this-product-in-promotions-ajax", ".remove-this-product{$pv['id']}", "#res"); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                           
                        </table>
                    </div>
                </div>

            </div>

            <script>
                // function selectImagee(btnId,inputfileId) {
                //   var btnId = document.getElementById(btnId);
                //   var inputfileId = document.getElementById(inputfileId);
                //   btnId.addEventListener('click',()=>{
                //     inputfileId.click();
                //   });
                // }
                // selectImagee("selectImageBtn","banner-img");
            </script>
            <div id="res"></div>
            <?php pkAjax_form("#add-new-cat-btn", "#add-new-product-btn-form", "#res", 'click', 'post', true); ?>
            <?php ajaxActive(".progress"); ?>







            <!-- Main Area ends-->
        </div>
    </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>