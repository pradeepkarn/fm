<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$plugin_dir = "products";
$content_group = "product";
?>
<?php
$page = new Dbobjects();
$page->tableName = "content";
$page = $page->pk($GLOBALS['url_last_param']);
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

                                <h3 class="text-dark"><?php echo ucwords($content_group); ?> Name</h3>
                                <input type="text" name="page_title" class="form-control mb-2 update_page" value="<?php echo $page['title']; ?>">
                                <!-- <h1>Vendor search</h1> -->

                                <?php
                               
                                $sale_price =  round(($page['price'] - $page['discount_amt']), 2);
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <b>Rent/Hr</b>
                                        <input type="text" name="price" class="form-control mb-2 update_page" value="<?php echo  $page['price']; ?>">
                                    </div>
                                    <div class="col">
                                        <b>Vat %</b>
                                        <input type="text" name="tax" class="form-control mb-2 update_page" value="<?php echo $page['tax']; ?>">
                                    </div>
                                    <div class="col">
                                        <b>Sale Price</b> <br>
                                        <b>= <?php echo round($sale_price+($sale_price*0.15),2); ?></b>
                                    </div>
                                   

                                </div>
                                <div class="row hide">

                                    <div class="col-3">
                                        <b>Stock Qty</b>
                                        <input type="text" name="qty" class="form-control mb-2 update_page" value="<?php echo $page['qty']; ?>">
                                    </div>

                                </div>

                              
                                <input type="checkbox" <?php matchData($page['show_title'], 1, "checked"); ?> name="page_show_title" class="update_page">
                                <?php matchData($page['show_title'], 0, "Check to show Page Title"); ?>
                                <?php matchData($page['show_title'], 1, "Uncheck to hide Page Title"); ?> &nbsp;
                                <a target="_blank" href='<?php echo "/" . home . "/product/?pid={$page['id']}"; ?>'>View</a> &nbsp;
                                <?php $var = "/" . home . "/page/delete/" . $page['id'];
                                $dltlink = "<a style='color: red;' href='{$var}'>Delete Page</a>";
                                matchData($page['status'], 'trash', $dltlink); ?> &nbsp;
                               

                                <h4>Details <i class="fas fa-arrow-down"></i></h4>
                                <textarea name="page_content" class=" form-control mb-2 update_page" rows="10"><?php echo $page['content']; ?></textarea>
                               
                                <input type="text" onkeyup="createSlug('page_slug_edit', 'page_slug_edit');" id="page_slug_edit" name="slug" class="form-control mb-2 update_page" value="<?php echo $page['slug']; ?>">
                                <input type="hidden" name="page_id" class="form-control mb-2 update_page" value="<?php echo $page['id']; ?>">
                                <input type="hidden" name="update_page" class="form-control mb-2 update_page" value="update_page">
                              
                               
                                <div class="d-grid mb-5">
                                    <button id="update_page_btn" class="mt-3 btn btn-lg btn-secondary">Update</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a class="btn btn-dark mb-4" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>">Back</a>
                                <form action="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/edit/<?php echo $page['id']; ?>" method="post" enctype="multipart/form-data">
                                    <h3>Featured Image</h3>
                                    <div class="card mb-2">
                                        <img id="banner-img" style="max-height: 200px; width: 100%; object-fit: contain;" src="/<?php echo media_root; ?>/images/pages/<?php echo $page['banner']; ?>" alt="">
                                    </div>
                                    <h4>Change Featured Image</h4>
                                    <input required id="select-banner-img" accept="image/*" type="file" name="banner" class="update_page form-control mb-2">
                                    <input type="hidden" name="update_banner" value="update_banner">
                                    <input type="hidden" name="update_banner_page_id" value="<?php echo $page['id']; ?>">
                                    <input type="hidden" name="update_banner_page_slug" value="<?php echo $page['slug']; ?>">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-secondary">Change Image</button>
                                    </div>
                                </form>
                                <textarea class="hide update_page" id="base64-textarea" name="banner_base64"></textarea>
                                <!-- <div class="d-grid">
                    <button class="btn btn-primary mb-1" data-bs-target="#GalleryModel" data-bs-toggle="modal">Select From Gallery</button>
                    </div> -->
                                <input id="banner-input" type="text" name="page_banner" class="hide form-control mb-2 update_page" value="<?php echo $page['banner']; ?>">
                                <!-- Attribute color -->
                                <style>
                                    .related-product {
                                        max-height: 200px;
                                        overflow-y: scroll;
                                    }
                                </style>
                            

                                <div id="colr-loading" class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                </h4>

                                <div class="related-product">
                                    <?php
                                    ajaxActive("#colr-loading");
                                    
                                    ?>
                               
                                   
                                    <div id="res"></div>
                                </div>
                                <br>
                                <!-- Attribute  images -->

                                <div id="res-delt"></div>
                                <div id="more-img-res"></div>
                                <div style="max-height: 100px; overflow-y: scroll;">
                                    <hr>
                                    <ol>
                                        <?php
                                        $db = new Model('content_details');
                                        $imgs  = $db->filter_index(array('content_group' => 'product_more_img', "content_id" => $page['id'], "is_active" => 1));
                                        if ($imgs == false) {
                                            $imgs = array();
                                        }
                                        foreach ($imgs as $key => $fvl) : ?>
                                            <li>
                                                <div class="row container my-2">

                                                    <div class="col">
                                                        <img style="width: 50px; height: 50px; object-fit: cover;" src="/<?php echo media_root; ?>/images/pages/<?php echo $fvl['content']; ?>" alt="">
                                                    </div>
                                                    <div class="col my-auto">
                                                        <?php echo $fvl['color']; ?>
                                                    </div>
                                                    <div class="col text-end my-auto text-danger">
                                                        <i id="delete-this-img<?php echo $fvl['id']; ?>" class="fas fa-trash pk-pointer"></i>
                                                        <input class="delete-data<?php echo $fvl['id']; ?>" type="hidden" name="content_details_delete_id" value="<?php echo $fvl['id']; ?>">
                                                    </div>
                                                </div>
                                            </li>
                                            <?php pkAjax("#delete-this-img{$fvl['id']}", "/admin/$plugin_dir/delete-content-details", ".delete-data{$fvl['id']}", "#res-delt"); ?>
                                        <?php endforeach;  ?>
                                        </ul>
                                </div>
                                <hr>
                                <h4>Add more image </h4>
                                <form action="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/add-more-img" id="add-more-img-form">
                                    <div class="progress">
                                        <div class="progress-bar"></div>
                                    </div>
                                    <input type="hidden" name="content_id" value="<?php echo $page['id']; ?>">
                                    <input type="hidden" name="content_group" value="product_more_img">
                                    <label for="">Image *</label>
                                    <input accept=".jpg,.png,.jpeg" type="file" name="add_more_img" class="form-control">
                                    <!-- <label for="">Image color *</label> -->
                                    <div id="more-img-with_clr"></div>
                                   
                                </form>
                                <button id="add-more-img-btn" class="btn btn-primary btn-sm my-1">Add More Image</button>
                                <?php pkAjax_form("#add-more-img-btn", "#add-more-img-form", "#more-img-with_clr", "click", true) ?>
                                <!-- <p><b>Vendor Name: </b><?php // echo getTableRowById("pk_user", $page['created_by'])['name']; ?>
                                    <br>
                                    <b>Vendor Mobile: </b><?php // echo getTableRowById("pk_user", $page['created_by'])['mobile']; ?>
                                </p> -->
                                <input type="text" name="page_author" class="hide form-control mb-2 update_page" value="<?php echo $page['author']; ?>">


                               

                                <p>Publish Date : <?php echo $page['pub_date']; ?></p>
                                <p>Update Date : <?php echo $page['update_date']; ?></p>

                                
                               

                                
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
                                url: "/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/edit/<?php echo $page['id']; ?>/update",
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
<script src="/<?php echo static_root; ?>/js/index.js"></script>
<?php import("apps/admin/inc/footer.php"); ?>