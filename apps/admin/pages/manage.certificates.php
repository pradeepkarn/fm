<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php if (!isset($_GET['user_id'])) {
    die;
} ?>
<style>
    .services-list{
            background-color: rgb(240,242,247);
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
                                    <div class="col-10"><h3>Certificate Managements</h3></div>
                                    <?php $usrdta = getTableRowById('pk_user',$_GET['user_id']);
                                    ?>
                                </div>  
                               
                                </div>
                                <div class="card-header">
                                <?php // import("apps/admin/pages/booking-flow-nav.php"); ?>
                                </div>
                                <div class="card-body">
                                <div id="res"></div>
                                    <form id="form-docs-upload" action="/<?php echo home; ?>/admin/docs-upload" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                    <div class="mb-3 col-md-4">
                                  <label for="all-courese" class="form-label">Select Course</label>
                                  <select class="form-control" name="object_id" id="all-courese">
                                    <option value="">No Course Selected</option>
                                    <?php
                                     $crsobj = new Model('service');
                                     $crs = $crsobj->filter_index(array('content_group'=>'course'),$ord='DESC',$limit=10000,"id");
                                     foreach ($crs as $key => $cv) : ?>
                                       <option value="<?php echo $cv['id']; ?>">(Course ID : <?php echo $cv['id']; ?>) <?php echo $cv['title']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div> 
                                <div class="mb-3 col-md-4">
                                  <label for="all-courese" class="form-label">Schedule Date</label>
                                  <input type="date" class="form-control" name="schedule_date">
                                </div> 
                                <div class="mb-3 col-md-4">
                                  <label for="all-courese" class="form-label">Expiry Date</label>
                                  <input type="date" class="form-control" name="expiry_date">
                                </div> 
                                    <div id="upload-docs-container"  class="col-md-10 mb-3">
                            <button id="add-more" type="button" class="btn btn-primary mb-1 btn-sm"><i class="fas fa-plus pk-pointer"></i> Add More Documents</button>
                            <textarea name="docs_name[]" placeholder="Course Details" class="form-control mb-1"></textarea>
                            <input type="hidden" name="object_group" value="<?php echo $_GET['obj_grp']; ?>">
                            <input type="file" class="mb-1 form-control" name="docs[]">
                            </div>
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $usrdta['id']; ?>">
                            </form>
                            <button id="upload-docs" class="btn btn-primary">Upload</button>
                            <?php pkAjax_form("#upload-docs","#form-docs-upload","#res"); ?>
                                    <!-- certificates -->
                <table class="table table-bordered"> 
                    <tbody>
                        
                    <?php 
                         $dcs = new Model('pk_docs');
                         $arr['user_id'] = $usrdta['id'];
                         $arr['obj_group'] = $_GET['obj_grp'];
                         $docs = $dcs->filter_index($arr, $ord='DESC',$limit = 999999,$change_order_by_col="id");
                        if($docs!=false): ?>
                        <tr>
                            <th>Docs ID</th>
                            <th>Details</th>
                            <th>Schedule Date</th>
                            <th>Expiry Date</th>
                            <th>Uploaded For</th>
                            <th class="text-center">File Type</th>
                            <th class="text-center">QR Code</th>
                            <th class="text-center">View Docs</th>
                            <th class="text-center">Delete</th>
                        </tr>
                       <?php  foreach ($docs as $key => $docsv) : ?>
                        <tr>
                            <td>
                                <?php echo $docsv['id']; ?>
                            </td>
                            <td>
                                <?php echo $docsv['details']; ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y',strtotime($docsv['schedule_date'])); ?>
                            </td>
                           
                            <td>
                                <?php echo date('d-m-Y',strtotime($docsv['expiry_date'])); ?>
                            </td>
                            <td>
                                <?php echo $docsv['obj_group']; ?>
                            </td>
                            <td class="text-center">
                                <?php $flar = explode(".",$docsv['media_file']); echo end($flar); ?>
                            </td>
                           <td class="text-center">
                            <style>
                               div#res<?php echo $docsv['id']; ?> img {
                                height: 100px; 
                                width: 100px; 
                                object-fit: contain;
                                }
                            </style>
                                <div id="res<?php echo $docsv['id']; ?>">
                                 <button class="btn btn-primary" id="viewqrcode<?php echo $docsv['id']; ?>">Generate <i class="fa-solid fa-qrcode"></i></button>
                                </div>
                                
                                <input type="hidden" class="generate-qr-code<?php echo $docsv['id']; ?>" name="qrcode_docs_link" value="<?php echo $docsv['media_file']; ?>">
                                <input type="hidden" class="generate-qr-code<?php echo $docsv['id']; ?>" name="qrcode_docs_id" value="<?php echo $docsv['id']; ?>">
                                <input type="hidden" class="generate-qr-code<?php echo $docsv['id']; ?>" name="qrcode_docs_details" value="<?php echo $docsv['details']; ?>">
                                <?php pkAjax("#viewqrcode{$docsv['id']}","/admin/generate-qr-code",".generate-qr-code{$docsv['id']}","#res{$docsv['id']}"); ?>
                            </td>
                            <td class="text-center">
                                <a class="text-decoration-none" target="_blank" href="/<?php echo media_root; ?>/docs/<?php echo $docsv['media_file']; ?>"><i class="fas fa-eye"></i></a> 
                            </td>
                            <td class="text-center">
                                <input class="data-delete<?php echo $docsv['id']; ?>" type="hidden" name="docs" value="<?php echo $docsv['media_file']; ?>">
                                <input class="data-delete<?php echo $docsv['id']; ?>" type="hidden" name="docs-id" value="<?php echo $docsv['id']; ?>">
                                <button id="delete-docs<?php echo $docsv['id']; ?>" class="text-decoration-none text-danger btn"><i class="fas fa-trash"></i></button>
                                <?php pkAjax("#delete-docs{$docsv['id']}","/admin/docs/delete/{$docsv['id']}/{$docsv['media_file']}",".data-delete{$docsv['id']}","#res","click","post"); ?>
                            </td>
                        </tr>
                        <?php endforeach;
                        endif;
                        ?>
                    </tbody>    
                </table>
              
                <!-- certificate ends -->
                                </div>
                            </div>
                
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
<script>
    $( document ).ready(function() {
        $("#add-more").click(function () {
            $("#upload-docs-container").append('<textarea name="docs_name[]" placeholder="Course Details" class="form-control mb-1"></textarea><input type="file" class="mb-1 form-control" name="docs[]">');
        });
    });
</script>
<?php import("apps/admin/inc/footer.php"); ?>