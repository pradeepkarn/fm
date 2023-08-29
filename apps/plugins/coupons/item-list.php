<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); 
$plugin_dir = "coupons";
?>
<?php 
    
    // if (isset($_POST['update_banner'])) {
    //     $contentid = $_POST['update_banner_page_id'];
    //     $banner=$_FILES['banner'];
    //     $banner_name = uniqid("banner_").time().USER['id'];
    //     // print_r($_FILES);
    //     change_my_banner($contentid,$banner,$banner_name);
    //     msg_ssn();
    // }
  
 ?>
<style>
.list-none li{
    font-weight: bold;
}
.menu-col{
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
                
                        <th>Edit</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Expiry</th>
                        <th>Group</th>
                        <th>Details</th>
                        <th class="text-end">Dis. Amt.</th>
                        <th class="text-end">Dis. Type</th>
                        <th class="text-end">Min. Purch. Amt.</th>
                        <th class="text-end">Action</th>
                     
                    </tr>
                    <tr style="background-color: dodgerblue; color:white;">
                        <th colspan="9">
                            Coupons 
                        </th>
                        <th class="text-end" colspan="1">
                        <a href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/add-new-item/?coupon_group=general"  class="btn btn-light btn-sm">Add More <i class="fas fa-plus"></i></a>
                        </th>
                    </tr>
                    <?php 
                    $cp = colpon_list($group=null);
                    foreach ($cp as $key => $pv) : 
                   
                    ?>
                         <tr>
                            <td>
                                <a href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/edit-item/?id=<?php echo $pv['id']; ?>"  class="btn btn-warning btn-sm">Edit</a>    
                            </td>
                            <td><?php echo $pv['name']; ?></td>
                            <td class="text-center" style="background-color:#CCCCCC; border:2px dotted black;"><?php echo $pv['code']; ?></td>
                            <td><?php echo $pv['expiry_date']; ?></td>
                            <td><?php echo $pv['coupon_group']; ?></td>
                            <td><?php echo $pv['details']; ?></td>
                            <td class="text-end"><?php echo $pv['discount_value']; ?></td>
                            <td class="text-end"><?php echo $pv['discount_type']; ?></td>
                            <td class="text-end"><?php echo $pv['min_purchase_amt']; ?></td>
                            <td class="text-end">
                                <button id="remove-this-coupon<?php echo $pv['id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                                <input type="hidden" class="remove-this-coupon<?php echo $pv['id']; ?>" name="remove_id" value="<?php echo $pv['id']; ?>">
                                <?php pkAjax("#remove-this-coupon{$pv['id']}","/admin/$plugin_dir/remove-this-coupon-ajax",".remove-this-coupon{$pv['id']}","#res"); ?>
                            </td>
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
    <?php pkAjax_form("#add-new-cat-btn","#add-new-product-btn-form","#res",'click','post',true); ?>
    <?php ajaxActive(".progress"); ?>  







       <!-- Main Area ends-->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>