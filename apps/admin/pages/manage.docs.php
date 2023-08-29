<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php if (!isset($_GET['obj_id'])) {
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
                                    <div class="col-10"><h3>Attachments</h3></div>
                                </div>    
                                </div>
                                <div class="card-header">
                                <?php // import("apps/admin/pages/booking-flow-nav.php"); ?>
                                </div>
                                <div class="card-body">
                                <div id="res"></div>
                                    <form id="form-docs-upload" action="/<?php echo home; ?>/admin/docs-upload" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                    <div id="upload-docs-container"  class="col-md-6 mb-3">
                            <button id="add-more" type="button" class="btn btn-primary mb-1 btn-sm"><i class="fas fa-plus pk-pointer"></i> Add More Documents</button>
                            <input type="text" name="docs_name[]" placeholder="Image or Document Details" class="form-control mb-1">
                            <input type="hidden" name="object_group" value="<?php echo $_GET['obj_grp']; ?>">
                            <input type="file" class="mb-1 form-control" name="docs[]">
                            </div>
                            </div>
                            <input type="hidden" name="object_id" value="<?php echo $_GET['obj_id']; ?>">
                            </form>
                            <button id="upload-docs" class="btn btn-primary">Upload</button>
                            <?php pkAjax_form("#upload-docs","#form-docs-upload","#res"); ?>
                                    <!-- certificates -->
                <table class="table table-bordered"> 
                    <tbody>
                    <?php 
                         $myapps = new Model('pk_docs');
                         $arr['obj_id'] = $_GET['obj_id'];
                         $arr['obj_group'] = $_GET['obj_grp'];
                         $docs = $myapps->filterIndex($arr, $ord='DESC',$limit = 999999,$change_order_by_col="id");
                        if($docs!=false): ?>
                        <tr>
                            <th>File Name</th>
                            <th>Docs Details</th>
                            <th>Uploaded For</th>
                            <th>View Docs</th>
                            <th>Delete</th>
                        </tr>
                       <?php  foreach ($docs as $key => $docsv) : ?>
                        <tr>
                            <td>
                                <?php echo $docsv['media_file']; ?>
                            </td>
                            <td>
                                <?php echo $docsv['details']; ?>
                            </td>
                            <td>
                                <?php echo $docsv['obj_group']; ?>
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
            $("#upload-docs-container").append('<input type="text" name="docs_name[]" placeholder="Image Or Document Details" class="form-control mb-1"><input type="file" class="mb-1 form-control" name="docs[]">');
        });
    });
</script>
<?php import("apps/admin/inc/footer.php"); ?>