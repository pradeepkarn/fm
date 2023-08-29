<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
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
            <div class="row">
                <div class="col-md-8">
                <a class="btn btn-dark mx-2" href="/<?php echo home; ?>/admin/subcategories/list/?parent_id=<?php echo $page['parent_id']; ?>">Back</a>
                    <div class="row">
                        <div class="col-md-6 hide">
                            <h3>Parent Category</h3>
                                <?php
                            $catData=multilevel_categories($parent_id=0,$radio=true); ?>
                            <select required class="update_page form-control" name="parent_id" id="cats">
                                <option value="0" selected>Parent</option>
                                <?php echo display_option($nested_categories=$catData,$mark=''); ?>
                            </select>
                            <script>
                                 var exists = false;
                                $('#cats option').each(function(){
                                    if (this.value == '<?php echo $page['parent_id']; ?>') {
                                        $("#cats").val("<?php echo $page['parent_id']; ?>");
                                    }
                                });
                            </script>
                        </div>
                        <div class="col-md-4 hide">
                            <h3>Content Type</h3>
                            <select name="page_content_type" class="update_page form-control mb-2 mt-2">
                                <option <?php if($page['content_type'] == 'page'){ echo "selected"; } ?> value="page">Page</option>
                                <option <?php if($page['content_type'] == 'post'){ echo "selected"; } ?> value="post">Post</option>
                                <option <?php if($page['content_type'] == 'service'){ echo "selected"; } ?> value="service">Service</option>
                                <option <?php if($page['content_type'] == 'slider'){ echo "selected"; } ?> value="slider">Slider</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <h3>Status</h3>
                            <select name="page_status" class="update_page form-control mb-2 mt-2">
                                <option <?php if($page['status'] == 'draft'){ echo "selected"; } ?> value="draft">Draft</option>
                                <option <?php if($page['status'] == 'listed'){ echo "selected"; } ?> value="listed">Listed</option>
                                <option <?php if($page['status'] == 'trash'){ echo "selected"; } ?> value="trash">Trash</option>
                            </select>
                        </div>
                    </div>
                    
                    <h5>Category Name</h5>
                    <input type="text" name="page_title" class="form-control mb-2 update_page" value="<?php echo $page['title']; ?>">
                    <!-- <h5>Title in English </h5>
                    <input type="text" name="page_content_info" class="form-control mb-2 update_page" value="<?php //echo $page['content_info']; ?>"> -->
                    <input type="checkbox" <?php matchData($page['show_title'],1,"checked"); ?> name="page_show_title" class="update_page"> 
                    <?php matchData($page['show_title'],0,"Check to show Page Title"); ?>
                    <?php matchData($page['show_title'],1,"Uncheck to hide Page Title"); ?> &nbsp;
                    <a target="_blank" href='<?php echo "/".home."/{$page['slug']}"; ?>'>View</a> &nbsp;
                    <?php $var = "/".home."/subcategories/delete/".$page['id'];
                $dltlink = "<a style='color: red;' href='{$var}'>Delete Page</a>";
                matchData($page['status'],'trash',$dltlink); ?> &nbsp; 
                <!-- <a data-bs-toggle="modal" data-bs-target="#GalleryModel">Add Image</a> -->
                
                    <h4>Details <i class="fas fa-arrow-down"></i></h4>
                    <textarea name="page_content" class="tiny_textarea form-control mb-2 update_page" rows="10"><?php echo $page['content']; ?></textarea>
                    <h5>Sub Category Name In Arabic</h5>
                    <input type="text" name="page_content_info" class="form-control mb-2 update_page" value="<?php echo $page['content_info']; ?>">
                    <h4>Sub Category Details in arabic <i class="fas fa-arrow-down"></i></h4>
                    <textarea name="page_other_content" class="tiny_textarea form-control mb-2 update_page" rows="10"><?php echo $page['other_content']; ?></textarea>
                    <input type="text" onkeyup="createSlug('page_slug_edit', 'page_slug_edit');" id="page_slug_edit" name="slug" class="form-control mb-2 update_page" value="<?php echo $page['slug']; ?>">
                    <input type="hidden" name="page_id" class="form-control mb-2 update_page" value="<?php echo $page['id']; ?>">
                    <input type="hidden" name="update_page" class="form-control mb-2 update_page" value="update_page">
                    <div class="d-grid mb-5">
                        <button id="update_page_btn" class="btn btn-lg btn-secondary">Update</button>
                    </div>
                </div>
                <div class="col-md-4">

                    <form action="/<?php echo home; ?>/admin/subcategories/edit/<?php echo $page['id']; ?>" method="post" enctype="multipart/form-data">
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
                    <!-- <div class="d-grid">
                    <button class="btn btn-primary mb-1" data-bs-target="#GalleryModel" data-bs-toggle="modal">Select From Gallery</button>
                    </div> -->
                    <p class="hide">Author Name : <?php echo $page['author']; ?></p>
                    <input type="text" name="page_author" class="hide form-control mb-2 update_page" value="<?php echo $page['author']; ?>">
                    <p>Publish Date : <?php echo $page['pub_date']; ?></p>
                    <p>Update Date : <?php echo $page['update_date']; ?></p>
                    Or <a class="hide" target="_blank" href="/<?php echo home; ?>/gallery">copy image name from gallery</a>
                    <input id="banner-input" type="text" name="page_banner" class="form-control mb-2 update_page" value="<?php echo $page['banner']; ?>">
                    <div class="col-md-12 mb-3">
            </div>
                    To add new info <input id="post_cat_radio" type="radio" name="cat">
                    <input id="post_cat_add" type="text" disabled=true name="post_category" class="form-control mb-2 update_page" value="<?php echo $page['post_category']; ?>">
                    Select from old info <input id="post_cat_radio_select" type="radio" name="cat">
                    <select id="post_cat_select" name="post_category" class="form-control update_page">
                    <?php $dbcat = new Mydb('content');
                            $cts = $dbcat->filterDistinctWhr($col="post_category", array('content_group'=>'listing_category'), $ord='',$limit = 100);
                            foreach ($cts as $key => $ctsvl): ?>
                            <option <?php matchData($page['post_category'],$ctsvl['post_category'],'selected'); ?>  value="<?php echo $ctsvl['post_category']; ?>"><?php echo $ctsvl['post_category']; ?></option>
                          <?php endforeach; ?>
                    </select>
                    <script>
                        var activrad = document.getElementById("post_cat_radio");
                        var postcat = document.getElementById("post_cat_add");
                        var postcatselect = document.getElementById("post_cat_select");
                        var postcatselectrad = document.getElementById("post_cat_radio_select");
                        activrad.addEventListener('click',activeElAd);
                        postcatselectrad.addEventListener('click',activeElSel);
                            function activeElAd() {
                                postcat.disabled = false;
                                postcatselect.disabled = true;
                            }
                            function activeElSel() {
                                postcat.disabled = true;
                                postcatselect.disabled = false;
                            }
                    </script>
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

<!-- Gallery -->
<div class="modal fade" id="GalleryModel" tabindex="-1" aria-labelledby="GalleryModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content pk-round">
      <div class="modal-header">
         <a class="btn btn-primary" target="_blank" href="/<?php echo home;?>/gallery/upload">Upload More Image</a>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="result"></div>
          <div class="container">
              <div class="row">
                  <?php 
                  $gldb = new Mydb('pk_media');
                  $gal = $gldb->allData("DESC",99999999);
                  foreach ($gal as $key => $galv):
                  ?>
                  <div class="col-md-2">
                  <center>
                    <input type="hidden" value="/<?php echo media_root; ?>/images/pages/<?php echo $galv['media_file'] ;?>">
                    <img class="pk-pointer" onclick="setThisImage<?php echo $galv['id'] ;?>();" id="galr-img-<?php echo $galv['media_file'] ;?>" class="glry-img" src="/<?php echo media_root; ?>/images/pages/<?php echo $galv['media_file'] ;?>" style="width: 90%; height: 90%; object-fit:scale-down;">
               <script>
                function setThisImage<?php echo $galv['id'] ;?>() {
                   document.getElementById("banner-input").value = `<?php echo $galv['media_file'] ;?>`;
                   document.getElementById("banner-img").src = "/<?php echo media_root; ?>/images/pages/<?php echo $galv['media_file']; ?>";
                }
               </script>
                </center>
                  </div>
                  <?php endforeach; ?>
              </div>
          </div>        
        
      </div>
    </div>
  </div>
</div>
<!-- Gallery End -->






       <!-- Main Area ends-->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>