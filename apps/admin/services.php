<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Courses"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<style>
    .services-list{
            background-color: rgb(240,242,247);
        }
        a.edit-service:hover{
            color: black !important;
        }
        input[type="text"].form-control,input[type="number"].form-control,select.form-control,div.tox-tinymce{
            border: 1px solid black;
        }
</style>
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
            <?php import("apps/admin/pages/page-nav.php"); ?>
                <section class="services-list">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                <div class="row">
                                    <div class="col-10"><h3>Courses</h3></div>
                                    <?php if (getAccessLevel()<=5): ?>
                                    <div class="col-2 text-end"><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addServiceModal"><i class="fa-solid fa-plus"></i> Add New</button></div>
                                    <?php endif; ?>
                                    <!-- <div class="col-md mb-2 hide">
                    <select name="rows_ord" class="filter-my-data form-control">
                        <option value="DESC">Descending</option>
                        <option value="ASC">Ascending</option>
                    </select>
                </div> -->
                <div class="pagination">
                  
                    <?php $enqs = new Model('service'); 
                    if ($enqs->filter_index(['content_group'=>'course'],$ord='',$limit = 9999999,$change_order_by_col="id")!=false) {
                        $nubenqs = count($enqs->filter_index(['content_group'=>'course'],$ord='',$limit = 9999999,$change_order_by_col="id")); ?>
                        <?php $i=0; $page = 1; while($i < $nubenqs){ ?>
                            <a class="<?php if(isset($_GET['startfrom_numrows'])){ echo($_GET['startfrom_numrows']==$i.',5')?"active":""; } ?>" href="/<?php echo home; ?>/admin/services/?startfrom_numrows=<?php echo $i; ?>,5"><?php echo $page; ?></a>
                      <?php  $i+=5; $page++; } ?>
                   <?php  }
                    ?>
                 
                    </div>
                <?php // pkAjax(".filter-my-data","/admin/filter-serv/",".filter-my-data","#resenq","change","get"); ?>
                
                                </div>    
                                
                                </div>
                                <div id="resenq" class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>CID</th>
                                                <th>Author</th>
                                                <th>View</th>
                                                <th>Title</th>
                                                <th>Lessons</th>
                                                <th>Price</th>
                                                <th>Sale Price</th>
                                                <th>Enrollment Limit</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <?php if (getAccessLevel()<=5): ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                         
                                            $limit = 5;
                                            if (isset($_GET['startfrom_numrows'])) {
                                                $limit = $_GET['startfrom_numrows'];
                                               } 
                                            $crsobj = new Model('service');
                                            $servs = $crsobj->filter_index(array('content_group'=>'course'),$ord='DESC',$limit,"id");
                                            if ($servs!=false) {
                                               foreach ($servs as $key => $sv) {
                                                $created_by = getTableRowById("pk_user",$sv['created_by']);
                                                $rls = (new Model('service'))->filter_index(array('content_group'=>'release','if_release_cid'=>$sv['id']),$ord='DESC',$limit = 99999);
                                                   $rlscount = ($rls!=false)?count($rls):0;
                                                   ?>
                                                <tr class="border-dark">
                                                    <?php $imgpath = RPATH."/media/images/categories/".$sv['image']; $img = file_exists($imgpath); ?>
                                                    <td><img class="<?php echo ($img==true)?"":"hide"; ?>" style="height: 50px; width: 50px; object-fit: cover;" src="/<?php echo media_root; ?>/images/categories/<?php echo $sv['image']; ?>" alt=""></td>
                                                    <td><?php echo $sv['id']; ?></td>
                                                    <td><?php echo "{$created_by['name']}<br>(ID: {$created_by['id']})"; ?></td>
                                                    <td> <a target="_blank" class="text-deco-none" href="/<?php echo home; ?>/courses/?cid=<?php echo $sv['id']; ?>"> <i class="text-success fas fa-eye"></i></a> </td>                                                    
                                                    <td><?php echo $sv['title']; ?></td>
                                                    <td><a class="text-deco-none" href="/<?php echo home; ?>/admin/releases/?cid=<?php echo $sv['id']; ?>"><?php echo $rlscount; ?> Lessons</a> </td>                                                    
                                                    <td><?php echo $sv['price']; ?></td>
                                                    <td><?php echo $sv['sale_price']; ?></td>
                                                    <td><?php echo $sv['max_booking']; ?></td>
                                                    <td class="text-capt"><?php echo $sv['category']; ?></td>
                                                    <td><?php echo ($sv['activation']==1) ? "Active" : "Inactive"; ?></td>
                                                    <?php if (getAccessLevel()<=5): ?>
                                                    <td class="text-center">
                                                        <button data-bs-toggle="dropdown" id="dropdownMenuButton1" class="btn btn-success"><i class="pk-pointer fa-solid fa-ellipsis-vertical"></i> </button>
                                                        <ul class="dropdown-menu bg-success" aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item text-white edit-service" data-bs-toggle="modal" data-bs-target="#addServiceModal_<?php echo $sv['id']; ?>" href="#">Edit</a></li>
                                                            <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                                                        </ul>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                                <?php if (getAccessLevel()<=5): ?>
                                                <!--Modal area  -->
                                            <div class="modal fade" id="addServiceModal_<?php echo $sv['id']; ?>" tabindex="-1" aria-labelledby="addServiceModalLabel_<?php echo $sv['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="img-res<?php echo $sv['id']; ?>"></div>
                                                                    
                                                                    <form id="image-upload-form<?php echo $sv['id']; ?>" action="/<?php echo home;?>/admin/courses/update-course" method="post">
                                                                        <?php csrf_token(); ?>
                                                                        <input type="file" name="update_my_service_admin_image">
                                                                        <input type="hidden" name="service_id" value="<?php echo $sv['id']; ?>">
                                                                        <input id="upload-img-btn<?php echo $sv['id']; ?>" type="submit" class="btn btn-success" value="UPLOAD">
                                                                    </form>
                                                                    <?php pkAjax_form("#upload-img-btn{$sv['id']}","#image-upload-form{$sv['id']}","#img-res{$sv['id']}",$event='click'); ?>
                                                                    <div style="display: none;" id="loadid_<?php echo $sv['id']; ?>"><b>Please wait...</b></div>
                                                                    <?php ajaxLoad("#loadid_{$sv['id']}"); ?>
                                                                </div>
                                                            </div>
                                                            <form method="post" id="update-service-form<?php echo $sv['id']; ?>">
                                                                <?php csrf_token(); ?>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div id="res"></div>
                                                                        <div class="mb-3">
                                                                        <label for="serviceTitle" class="form-label">Title</label>
                                                                        <input name="service_title" value="<?php echo $sv['title']; ?>" required onblur="checkDate();" type="text" class="form-control" id="serviceTitle<?php echo $sv['id']; ?>" placeholder="Title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                    Category <input id="post_cat_radio_select<?php echo $sv['id']; ?>" checked type="radio" name="cat">
                    <select id="post_cat_select<?php echo $sv['id']; ?>" name="category" class="form-control update_page">
                    <?php $dbcat = new Mydb('service');
                            $cts = $dbcat->filterDistinct($col="category", $ord='',$limit = 100);
                            foreach ($cts as $key => $ctsvl): ?>
                            <option <?php echo ($ctsvl['category']==$sv['category'])?"selected":""; ?> value="<?php echo $ctsvl['category']; ?>"><?php echo $ctsvl['category']; ?></option>
                          <?php endforeach; ?>
                    </select>
                    </div>
                    <?php if (getAccessLevel()<=1) {?>
                        <div class="col-md-12">
                    Want to create a new category ? <input id="post_cat_radio<?php echo $sv['id']; ?>" type="radio" name="cat">
                    <input id="post_cat_add<?php echo $sv['id']; ?>" type="text" disabled=true name="category" class="form-control mb-2">
                    </div>
                    <script>
                        var activrad<?php echo $sv['id']; ?> = document.getElementById("post_cat_radio<?php echo $sv['id']; ?>");
                        var postcat<?php echo $sv['id']; ?> = document.getElementById("post_cat_add<?php echo $sv['id']; ?>");
                        var postcatselect<?php echo $sv['id']; ?> = document.getElementById("post_cat_select<?php echo $sv['id']; ?>");
                        var postcatselectrad<?php echo $sv['id']; ?> = document.getElementById("post_cat_radio_select<?php echo $sv['id']; ?>");
                        activrad<?php echo $sv['id']; ?>.addEventListener('click',activeElAd<?php echo $sv['id']; ?>);
                        postcatselectrad<?php echo $sv['id']; ?>.addEventListener('click',activeElSel<?php echo $sv['id']; ?>);
                            function activeElAd<?php echo $sv['id']; ?>() {
                                postcat<?php echo $sv['id']; ?>.disabled = false;
                                postcatselect<?php echo $sv['id']; ?>.disabled = true;
                            }
                            function activeElSel<?php echo $sv['id']; ?>() {
                                postcat<?php echo $sv['id']; ?>.disabled = true;
                                postcatselect<?php echo $sv['id']; ?>.disabled = false;
                            }
                    </script>
                   <?php } ?>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                <label for="serviceDescription<?php echo $sv['id']; ?>" class="form-label">Description</label>
                                                <textarea name="service_desc" class="form-control tiny_textarea" id="serviceDescription<?php echo $sv['id']; ?>" rows="3"><?php echo $sv['description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                <label for="pricePerSpace<?php echo $sv['id']; ?>" class="form-label">Price</label>
                                                <input name="service_price" value="<?php echo $sv['price']; ?>" type="number" step="any" class="form-control" id="pricePerSpace<?php echo $sv['id']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                <label for="salePricePerSpace<?php echo $sv['id']; ?>" class="form-label">Sale Price</label>
                                                <input name="sale_price" value="<?php echo $sv['sale_price']; ?>" type="number" step="any" class="form-control" id="salePricePerSpace<?php echo $sv['id']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                <label for="seatRemaining<?php echo $sv['id']; ?>" class="form-label">Enrollment Limit</label>
                                                <input name="max_booking" value="<?php echo $sv['max_booking']; ?>" type="number" step="any" class="form-control" id="seatRemaining<?php echo $sv['id']; ?>">
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12">
                                            <h3 class="text-danger text-center" id="msg"></h3>
                                            </div>
                                            
                                                <div class="mb-3 col-md-3 hide">
                                                <label for="serviceSlotDuration<?php echo $sv['id']; ?>" class="form-label">Service Slot Duration</label>
                                            
                                                <input type='time' name="service_duration" value="<?php echo $sv['service_duration']; ?>" min='00:00:01' class="form-control" max='23:59:59' id="serviceSlotDuration<?php echo $sv['id']; ?>">
                                                <input style="display: none;" type="radio" required checked name="service_duration_type" value="hour">   
                                            <input style="display: none;" type="radio" required name="service_duration_type" value="minute">
                                            <input type="hidden" value="<?php echo $sv['id']; ?>" name="update_my_service_admin">      
                                            </div>
                                            
                                        </div>
                                    </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i> Cancel</button>
                                <button id="update-service-btn<?php echo $sv['id']; ?>" type="button" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Modal area ends -->
                        <?php endif; ?>
                        <?php 
                        $url = "/admin/courses/update-course";
                        pkAjax("#update-service-btn{$sv['id']}",$url,"#update-service-form{$sv['id']}","#res"); ?>
                    <?php } } ?>
                    
                </tbody>
            </table>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                </section>
                
            </div>
        </div>
    </div>
</section>
<div data-bs-backdrop="static" class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div id="img-res"></div>
            </div>
        </div>
        <div style="display: none;" id="loadsss"><b>Please wait...</b></div>
            <form action="/<?php echo home;?>/admin/courses/add-course" method="post" id="add-service-form">
            <input type="file" name="add_my_service_admin_image">
                <?php csrf_token(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div id="res"></div>
                        <div class="mb-3">
                        <label for="serviceTitle" class="form-label">Title</label>
                        <input name="service_title" required onblur="checkDate();" type="text" class="form-control" id="serviceTitle" placeholder="Course Title">
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                    Category <input id="post_cat_radio_select" checked type="radio" name="cat">
                    <select id="post_cat_select" name="category" class="form-control update_page">
                    <?php $dbcat = new Mydb('service');
                            $cts = $dbcat->filterDistinct($col="category", $ord='',$limit = 100);
                            foreach ($cts as $key => $ctsvl): ?>
                            <option value="<?php echo $ctsvl['category']; ?>"><?php echo $ctsvl['category']; ?></option>
                          <?php endforeach; ?>
                    </select>
                    </div>
                    <?php if (getAccessLevel()<=1) {?>
                        <div class="col-md-12">
                    Want to create a new category ? <input id="post_cat_radio" type="radio" name="cat">
                    <input id="post_cat_add" type="text" disabled=true name="category" class="form-control mb-2">
                    </div>
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
                   <?php } ?>
                 
                    <div class="col-md-12">
                        <div class="mb-3">
                        <label for="serviceDescription" class="form-label">Description</label>
                        <textarea name="service_desc" onblur="checkDate();" class="tiny_textarea form-control" id="serviceDescription" rows="3"></textarea>
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="mb-3">
                        <label for="pricePerSpace" class="form-label">Price</label>
                        <input name="service_price" type="number" step="any" class="form-control" id="pricePerSpace">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                        <label for="pricePerSpace" class="form-label">Sale Price</label>
                        <input name="sale_price" type="number" step="any" class="form-control" id="salePricePerSpace">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                        <label for="seatRemaining" class="form-label">Enrollment Limit</label>
                        <input name="max_booking" type="number" step="any" class="form-control" id="seatRemaining">
                        </div>
                    </div>
                
                    <div class="col-md-12">
                    <h3 class="text-danger text-center" id="msg"></h3>
                    </div>
                    <div class="col-md-4 hide">
                        <input type="hidden" value="1" name="add_new_service_admin">    
                        <input type="hidden" name="content_group" value="course">    
                    </div>
                   
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i> Cancel</button>
        <button id="add-service-btn" type="button" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save</button>
      </div>
    </div>
  </div>
</div>

<?php 
$url = "/admin/services/add-service";
//pkAjax("#add-service-btn",$url,"#add-service-form","#res"); ?>
 <?php ajaxLoad("#loadsss"); ?>
<?php pkAjax_form("#add-service-btn","#add-service-form","#res",$event='click'); ?>
<?php import("apps/admin/inc/footer.php"); ?>