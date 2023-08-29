<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$plugin_dir = "promotions";
$promobj = new Model('promo_category');
$promo = $promobj->show($_GET['promo_id']);
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
                <h4>Update Promotion</h4>
                <div class="row">
                    <div class="col-md-8">
                        <form id="formSave" action="/<?php echo home; ?>/admin/promotions/update-promotion-ajax" method="post">
                        <div class="mb-3">
                            <input type="file" class="form-control" name="promoimage">
                        </div>
                        <div class="mb-3">
                            <label for="promoName" class="form-label">Promotion Group Name</label>
                            <input type="text" class="form-control" id="promoName" name="promo_name" value="<?php echo $promo['name']; ?>">
                            <input type="hidden" class="form-control" id="promoid" name="promo_id" value="<?php echo $promo['id']; ?>">
                        </div>
                       
                    <button id="btnsave" type="button" class="btn btn-primary my-3">Update</button>
                        </form>
                        <?php 
                        pkAjax_form("#btnsave","#formSave","#res");
                        ?>
                    
                    
                   
                    </div>
                    <div class="col-md-4">
                        <img style="height: 200px; width:100%; object-fit:contain;" src="/<?php echo media_root; ?>/images/pages/<?php echo $promo['image']; ?>">
                        <h3 class="text-center"><?php echo $promo['name']; ?></h3>
                        <div id="res"></div>
                        <div class="progress my-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-prime" role="progressbar" aria-label="Animated striped example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
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