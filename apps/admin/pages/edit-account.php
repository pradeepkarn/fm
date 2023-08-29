<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); 
$json = file_get_contents(RPATH.'/apps/std-code.json');
$dialcodes = json_decode($json);
$ug = $_GET['user_group'];
?>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php if(getAccessLevel()<=5): ?>
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (getAccessLevel()<=5)?"10":"12"; ?>">
            <!-- conetent starts -->
            <?php import("apps/admin/pages/page-nav.php"); ?>
            <section id="page" class="mt-2">
                <div class="row">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header shadow">
                            <id id="res"></id>
                                <div class="d-flex">
                                <h3 class="text-upper">Edit Account</h3>
                                <?php if (is_superuser()) { ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#delete-user-modal" class="ms-auto btn btn-danger">Delete</button>
                                
                                <?php
                                if (isset($_GET['edit_user_id'])) { ?>
                                    <input type="hidden" class="delete-user-id" name="delete-user-id" value="<?php echo $_GET['edit_user_id']; ?>">
                                <?php 
                                    csrf_token("class='delete-user-id'");
                                    pkAjax("#delete-user","/admin/user-delete",".delete-user-id","#res");
                                   echo bsmodal($id="delete-user-modal",$title="Delete This User ?",$body="<h3 class='text-danger'>Be carefurll everything related to this user will be deleted.</h3>",$btn_id="delete-user",$btn_text="Delete",$btn_classs="btn btn-danger",$size="modal-sm");
                                }
                                ?>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="card-body">
                            <?php if (authenticate()==true): 
                                $ac = new Account();
                                $user = $ac->getLoggedInAccount();
                                if (isset($_GET['edit_user_id'])) {
                                    $user = (new Model('pk_user'))->show($_GET['edit_user_id']);
                                }
                                    if($user!=false){ ?>
                                    <div class="row">
                <div class="col-md-12">
                    <form action="/<?php echo home;?>/admin/update-personal-info" enctype="multipart/form-data" autocomplete="off" method="post" id="pi-data-form">
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Name</label>
                            <input type="text" name="name" value="<?php echo $user['name']; ?>" class="mb-1 form-control p-details">
                        </div>
                        <div class="col-md-6">
                            <label for="">City</label>
                            <input type="text" name="city" value="<?php echo $user['city']; ?>" class="mb-1 form-control p-details">
                        </div>
                        <div class="col-md-2">
                        <label for="">Dial Code</label>
                            <select required id="dial-code" name="dial_code" class="form-select">
                                <?php
                                foreach ($dialcodes as $key => $dc) { ?>
                                    <option <?php if ($dc->dial_code == $user['isd_code']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $dc->dial_code; ?>"><?php echo $dc->name; ?></option>
                                <?php   } ?>
                            </select>
                        </div>
                        <div class="col-md-4" style="position:relative;">
                            <label for="my_mobile">Mobile</label>
                            <div style="position: absolute; padding: 7px 0 5px 10px;" id="dial-span">+966</div>
                            <input style="padding-left: 60px !important;" type="number" id="my_mobile" name="my_mobile" value="<?php echo $user['mobile']; ?>" class="mb-1 form-control p-details inc-dec-op-hide">
                        </div>
                        <div class="col-md-6">
                            <label for="">Email</label>
                            <input readonly type="email" name="my_email" value="<?php echo $user['email']; ?>" class="mb-1 form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">Username</label>
                            <input readonly type="text" name="my_username" value="<?php echo $user['username']; ?>" class="mb-1 form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="Profile Image">Profile Image</label>
                            <input type="file" id="profile_image" name="profile_image" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="">New Password(Leave it blank if you do not want)</label>
                            <input type="checkbox" name="change_pass" value="ok">
                            <input type="password" name="my_password" class="mb-1 form-control">
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="user_group" value="<?php echo $user['user_group']; ?>">
                            <input type="hidden" name="update_my_profile" value="ok">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <input type="hidden" name="page" value="<?php echo $ug; ?>">
                            <button id="update-pi" type="button" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
                        </div>
                    </div>
                    </form>
                 <?php pkAjax_form("#update-pi","#pi-data-form","#res"); ?>
                    </div>
                 </div>
                 <hr>


                                   <?php  }
                                    endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </section>


            <!-- content ends -->
            
            </div>
        </div>
    </div>
</section>
<script>
            let dialCodes = document.getElementById('dial-code');
            let dialSpan = document.getElementById('dial-span');
            dialSpan.innerText = dialCodes.value
            dialCodes.addEventListener('change', () => {
                dialSpan.innerText = dialCodes.value
            })
        </script>
<?php ajaxLoadModal("#ajaxLoadModal"); ?>
<?php import("apps/admin/inc/footer.php"); ?>