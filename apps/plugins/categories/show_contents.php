<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<style>
    /* .list-none li{
    font-weight: bold;
} */
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
            <div id="content-col" class="col-md-10">
                <?php import("apps/admin/pages/page-nav.php"); ?>
                <!-- Main -->

                <section>
                    <div class="my-4 d-flex justify-content-end">
                        <a class="btn btn-primary" href="/<?php echo home; ?>/admin/categories/add-new-item">Add New Category</a>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>All Categories</h3>
                            <table class="table-sm table table-bordered">
                                <thead>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Thumbnail</th>
                                    <th>Category Name</th>
                                    
                                    <th>Edit</th>
                                    <th>Trash</th>
                                </thead>
                                <tbody>
                                    <?php

                                    $dbcats = new Model('content');
                                    $chckarr['content_group'] = "fm_category";
                                    $cats = $dbcats->filter_index($chckarr);

                                    foreach ($cats as $key => $ctv) {
                                        if ((new Model('content'))->filter_index(array('id' => $ctv['parent_id'], 'content_group' => 'fm_category')) == false) {
                                            $dbcats->update($ctv['id'], array('parent_id' => 0));
                                        }
                                    }

                                    $db = new Model('content');
                                    $pgqry['content_group'] = "fm_category";
                                    $pgqry['parent_id'] = 0;
                                    $prods = $db->filter_index($pgqry, $ord = "DESC", $limit = 500);
                                    if ($prods != false) {
                                        foreach ($prods as $pk => $pv) {
                                            $sale_price = $pv['sale_price'] == "" ? 0 : $pv['sale_price'];
                                            $is_sale = (($pv['sale_price']) != "" && ($pv['sale_price']) > 0) ? true : false;
                                            $net_price = $pv['price'] - $sale_price;

                                            $subcat = new Model('content');
                                            $sbcats = $subcat->filter_index(array('parent_id' => $pv['id'], 'content_group' => 'fm_category'));
                                            if ($sbcats == false) {
                                                $sbcats = array();
                                            }
                                    ?>
                                            <tr>
                                                <td><?php echo $pv['id']; ?></td>
                                                <td <?php matchData($pv['status'], 'published', 'class="bg-success text-white"');
                                                    matchData($pv['status'], 'trash', 'class="bg-secondary text-white"');
                                                    matchData($pv['status'], 'draft', 'class="bg-warning"');
                                                    ?>><?php echo $pv['status']; ?></td>
                                                <td><img style="height: 50px;" src="/<?php echo media_root; ?>/images/pages/<?php echo $pv['banner']; ?>"></td>
                                                <td><?php echo $pv['title']; ?></td>
                                               




                                                <td class="hide"><?php echo (getData("content", $pv['parent_id']) != false) ? getData("content", $pv['parent_id'])['title'] : "NA"; ?></td>


                                                <td><a href="/<?php echo home; ?>/admin/categories/edit/<?php echo $pv['id']; ?>">Edit</a></td>
                                                <td><a data-bs-toggle="modal" data-bs-target="#deltModal<?php echo $pv['id']; ?>" href="javascript:void(0);" class="text-danger">Delete</a></td>
                                                <div class="modal" id="deltModal<?php echo $pv['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $pv['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">

                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h3 class="bg-danger p-3 text-white">Be careful, this action can not be un done!</h3>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="/<?php echo home; ?>/admin/categories" method="post">
                                                                    <input type="hidden" name="delete_category" value="delete_category">
                                                                    <input type="hidden" name="parent_id_del" value="<?php echo $pv['id'] ?>">
                                                                    <button class="btn btn-danger">Delete</button>
                                                                </form>
                                                                <a class="hide btn btn-danger" href="/<?php echo home; ?>/admin/categories/delete/<?php echo $pv['id']; ?>">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                    <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <!-- main end -->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>