<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
if (isset($_GET['user_group']) && isset($_GET['id'])) {
    $user_group = $_GET['user_group'];
} else {
    die();
}
$plugin_dir = "users";
$usrobj = new Model('pk_user');
$user = obj($usrobj->filter_index(['user_group' =>  $user_group,'id'=>$_GET['id']])[0]);
$json = file_get_contents(RPATH . '/apps/std-code.json');
$dialcodes = json_decode($json);
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
                <h4>User management</h4>

                <div class="row">
                    <div class="col-md-8">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header shadow">
                                        <id id="res"></id>
                                        <h3 class="text-upper">Add <?php echo $user_group; ?></h3>
                                        <div id="lodspinn" class="spinner-border text-primary" role="status">
                                        </div>
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
                                                <form action="/<?php echo home; ?>/admin/users/update-user-ajax" method="post" id="add-user-form">
                                                    <?php csrf_token(); ?>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="">First Name</label>
                                                    <input type="text" name="first_name" value="<?php echo $user->first_name; ?>" class="mb-1 form-control p-details">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Last Name</label>
                                                    <input type="text" name="last_name" value="<?php echo $user->last_name; ?>" class="mb-1 form-control p-details">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Company Name</label>
                                                    <input type="text" name="company_name" value="<?php echo $user->company; ?>" class="mb-1 form-control p-details">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Company VAT</label>
                                                    <input type="text" name="company_vat" value="<?php echo $user->company_vat; ?>" class="mb-1 form-control p-details">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Company CR</label>
                                                    <input type="text" name="company_cr" value="<?php echo $user->company_cr; ?>" class="mb-1 form-control p-details">
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="">Dial Code</label>
                                                    <select required id="dial-code" name="dial_code" class="form-select">
                                                        <?php
                                                        foreach ($dialcodes as $key => $dc) { ?>
                                                            <option <?php if ($dc->dial_code == $user->isd_code) {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $dc->dial_code; ?>"><?php echo $dc->name; ?></option>
                                                        <?php   } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4" style="position:relative;">
                                                    <label for="">Contact</label>
                                                    <div style="position: absolute; padding: 5px 0 5px 10px;" id="dial-span"><?php echo $user->isd_code; ?></div>
                                                    <input style="padding-left: 60px !important;" type="number" id="mobile" name="mobile" value="<?php echo $user->mobile; ?>" class="mb-1 form-control p-details inc-dec-op-hide">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Email</label>
                                                    <input type="email" name="email" value="<?php echo $user->email; ?>" class="mb-1 form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Username</label>
                                                    <input type="text" name="username" value="<?php echo $user->username; ?>" class="mb-1 form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Password</label>
                                                    <input type="text" name="password" class="mb-1 form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Profile Image</label>
                                                    <input type="file" accept="image/*" name="profile_img" class="mb-1 form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Companay VAT</label>
                                                    <input type="file" accept="application/pdf" name="comp_vat_doc" class="mb-1 form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Companay CR</label>
                                                    <input type="file" accept="application/pdf" name="comp_cr_doc" class="mb-1 form-control">
                                                </div>
                                                <?php
                                                if ($user_group == 'driver') { ?>
                                                    <div class="col-md-6">
                                                        <label for="">Driver Doc</label>
                                                        <input type="file" accept="application/pdf" name="driver_doc" class="mb-1 form-control">
                                                    </div>
                                                <?php  }
                                                ?>
                                                <div class="col-12">
                                                    <input type="hidden" name="add_new_user" value="ok">
                                                    <input type="hidden" name="admin_user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                    <input type="hidden" name="user_group" value="<?php echo $user_group; ?>">

                                                    <button id="add-user-btn" type="button" class="mt-3 btn btn-success">
                                                        <i class="fa-solid fa-floppy-disk"></i> Update
                                                    </button>

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
                                            <?php
                                            ajaxActive('#lodspinn');
                                            pkAjax_form("#add-user-btn", "#add-user-form", "#res");
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <a class="btn btn-dark my-2" href="/<?php echo home . "/admin/" . $plugin_dir; ?>/list/?user_group=<?php echo $user_group; ?>">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <?php ajaxActive(".progress"); ?>


            <!-- Main Area ends-->
        </div>
    </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>