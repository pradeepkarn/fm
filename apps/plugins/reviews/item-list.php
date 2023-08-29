<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$plugin_dir = "reviews";
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
                        <div id="res"></div>
                        <table class="table table-hover">
                            <tr>

                                <th>Action</th>
                                <th>Rating Point</th>
                                <th>Message</th>
                                <th>Cust. Name</th>
                                <th>Cust. Mobile</th>
                                <th>Salon Name</th>
                                <th>Vendor Name</th>
                                <th>Vendor Mobile</th>


                            </tr>
                            <tr style="background-color: dodgerblue; color:white;">
                                <th colspan="10">
                                </th>
                            </tr>
                            <?php
                            $bkmrks = new Model('bookmarks');
                            $reviews = $bkmrks->filter_index(['content_group' => 'star-rating']);
                            foreach ($reviews as $key => $pv) :
                                $bk = obj($pv);
                                $user = obj(getData('pk_user', $bk->user_id));

                                $salon = obj(getData('content', $bk->content_id));
                                $vendor = obj(getData('pk_user', $salon->created_by));
                                $star = showStars($rating = $bk->detail);
                            ?>
                                <tr>
                                    <td>
                                        <a href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/edit-item/?id=<?php echo $bk->id; ?>" class="btn btn-warning btn-sm">Take action</a>
                                    </td>
                                    <td>
                                        <b><?php echo $bk->detail . " " . $star; ?></b>
                                    </td>
                                    <td><?php echo $user->name; ?></td>
                                    <td><?php echo $bk->message; ?></td>
                                    <td><?php echo $user->mobile; ?></td>
                                    <td><?php echo $salon->title; ?></td>
                                    <td><?php echo $vendor->name; ?></td>
                                    <td><?php echo $vendor->mobile; ?></td>


                                    <!-- <td class="text-end">
                                        <button id="remove-this-coupon<?php echo $pv['id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                                        <input type="hidden" class="remove-this-coupon<?php echo $pv['id']; ?>" name="remove_id" value="<?php echo $pv['id']; ?>">
                                        <?php // pkAjax("#remove-this-coupon{$pv['id']}", "/admin/$plugin_dir/remove-this-coupon-ajax", ".remove-this-coupon{$pv['id']}", "#res"); 
                                        ?>
                                    </td> -->
                                </tr>
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