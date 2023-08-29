<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
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
.list-none li{
    font-weight: bold;
}
.menu-col{
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
        <form id="add-new-cat-btn-form" action="/<?php echo home; ?>/admin/categories/add-new-cat-ajax" method="post" enctype="multipart/form-data">
            <div class="row">
            
                <div class="col-md-8">
               
                    
                    <h5 class="text-dark">Category Name</h5>
                    <input type="text" onkeyup="createSlug('page_title', 'page_slug');" id="page_title" required name="page_title" placeholder="Category Name" class="form-control mb-2">
                    <input type="text" placeholder="url-slug" onblur="createSlug(this.id, this.id);" id="page_slug" required  name="slug" class="form-control">
                    <input type="hidden" name="add_new_content" value="add_new_content">           
                
                    <h4>Details <i class="fas fa-arrow-down"></i></h4>
                    <textarea name="content" class=" form-control mb-2 update_page" rows="10"></textarea>
                    <!-- <h3 class="text-dark">Category Name in Arabic</h3>
                    <input type="text" id="page_title_ar" name="page_content_info" placeholder="Book Name" class="form-control mb-2"> -->
                    <!-- <h5>Category Details in arabic <i class="fas fa-arrow-down"></i></h5>
                    <textarea name="page_other_content" class=" form-control mb-2 update_page" rows="10"></textarea> -->
                    
                    <div class="d-grid mb-5">
                        <button id="add-new-cat-btn" class="btn btn-lg btn-secondary">Add Category</button>
                    </div>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                        <div id="uploadProfileImageRes"></div> 
                </div>
                <div class="col-md-4">
                <a class="btn btn-dark mb-4" href="/<?php echo home; ?>/admin/categories">Back</a>
                    <h3>Featured Image</h3>
                    <div class="card mb-2">
                        <img id="banner-img" style="max-height: 200px; width: 100%; object-fit: contain;" src="/<?php echo media_root; ?>/images/pages/page.png" alt="">
                    </div>
                    <input id="selectImageBtn" accept="image/*" type="file" name="banner" class="form-control mb-2">
                 
                    <p class="bg-warning text-dark">
                    <?php msg_ssn(); ?>
                    </p>
                  
                    
                </div>
                  
                </div>
                </form>
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
    <?php pkAjax_form("#add-new-cat-btn","#add-new-cat-btn-form","#res",'click','post',true); ?>
    <?php ajaxActive(".progress"); ?>  









       <!-- Main Area ends-->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>