<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$plugin_dir = "users";
if (isset($_GET['user_group'])) {
    $user_group = $_GET['user_group'];
} else {
    die();
}
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
                                <th>User ID</th>
                                <th>First name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Is active</th>
                            </tr>
                            <tr style="background-color: dodgerblue; color:white;">
                                <th colspan="10">
                                </th>
                            </tr>
                            <?php
                            $bkmrks = new Model('pk_user');
                            $users = $bkmrks->filter_index(['user_group' =>  $user_group]);
                            foreach ($users as $key => $uv) :
                                $uv = obj($uv);
                            ?>
                                <tr>
                                    <td>
                                        <a href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/edit-item/?user_group=<?php echo $user_group; ?>&id=<?php echo $uv->id; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                    <td><?php echo $uv->id; ?></td>
                                    <td><?php echo $uv->first_name; ?></td>
                                    <td><?php echo $uv->last_name; ?></td>
                                    <td><?php echo $uv->email; ?></td>
                                    <td><?php echo $uv->mobile; ?></td>
                                    <td><?php echo $uv->status; ?></td>
                                    <td><?php echo $uv->is_active?'Active':'Inactive'; ?></td>
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