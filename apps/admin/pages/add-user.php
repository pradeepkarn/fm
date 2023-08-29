<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$json = file_get_contents(RPATH . '/apps/std-code.json');
$dialcodes = json_decode($json);
$user_group = "employee";
if (isset($_GET['user_group']) && $_GET['user_group'] != "") {
    $user_group = $_GET['user_group'];
}
?>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php if (getAccessLevel() <= 5) : ?>
                <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                    <?php import("apps/admin/inc/sidebar.php"); ?>
                </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (getAccessLevel() <= 5) ? "10" : "12"; ?>">
                <!-- conetent starts -->
                <?php import("apps/admin/pages/page-nav.php"); ?>
                <section id="page" class="mt-2">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header shadow">
                                    <id id="res"></id>
                                    <h3 class="text-upper">Add <?php echo $user_group; ?></h3>
                                </div>
                                <div class="card-body">
                                    <?php if (is_superuser() != true) :
                                        return;
                                    endif; ?>

                                    <div class="row">
                                        <style>
                                            #mobile {
                                                padding-left: 60px !important;
                                            }
                                        </style>
                                        <div class="col-md-12">
                                            <form action="" autocomplete="off" method="post" id="pi-data-form">
                                                <?php csrf_token(); ?>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Name</label>
                                                <input type="text" name="name" class="mb-1 form-control p-details">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">City</label>
                                                <input type="text" name="city" class="mb-1 form-control p-details">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="">Dial Code</label>
                                                <select required id="dial-code" name="dial_code" class="form-select">
                                                    <?php
                                                    foreach ($dialcodes as $key => $dc) { ?>
                                                        <option <?php if ($dc->dial_code == '+966') {
                                                                    echo 'selected';
                                                                } ?> value="<?php echo $dc->dial_code; ?>"><?php echo $dc->name; ?></option>
                                                    <?php   } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4" style="position:relative;">
                                                <label for="">Mobile</label>
                                                <div style="position: absolute; padding: 5px 0 5px 10px;" id="dial-span">+966</div>
                                                <input style="padding-left: 60px !important;" type="number" id="mobile" name="mobile" class="mb-1 form-control p-details inc-dec-op-hide">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Email</label>
                                                <input type="email" name="email" class="mb-1 form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Username</label>
                                                <input type="text" name="username" class="mb-1 form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Password</label>
                                                <input type="text" name="password" class="mb-1 form-control">
                                            </div>
                                            <div class="col-12">
                                                <input type="hidden" name="add_new_user" value="ok">
                                                <input type="hidden" name="admin_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                <input type="hidden" name="user_group" value="<?php echo $user_group; ?>">
                                                <button id="add-pi" type="button" class="mt-3 btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Add</button>
                                            </div>
                                        </div>
                                        <script>
                                            let dialCodes = document.getElementById('dial-code');
                                            let dialSpan = document.getElementById('dial-span');
                                            dialSpan.innerText = dialCodes.value
                                            dialCodes.addEventListener('change', () => {
                                                dialSpan.innerText = dialCodes.value
                                            })
                                        </script>
                                        </form>
                                        <?php pkAjax("#add-pi", "/admin/add-vendor-ajax", "#pi-data-form", "#res"); ?>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
            </div>
</section>


<!-- content ends -->

</div>
</div>
</div>
</section>
<?php ajaxLoadModal("#ajaxLoadModal"); ?>
<?php import("apps/admin/inc/footer.php"); ?>