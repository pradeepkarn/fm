<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); 
$plugin_dir = "coupons";
$cp = colpon_detail($_GET['id']);
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
            <h4>Search Product</h4>
                <div class="row">
                    <div class="col-md-8">
                            <style>
                                .my-input:focus{
                                    border: 1px solid dodgerblue;
                                    /* background-color:  rgb(32,32,32); */
                                    color: dodgerblue;
                                    outline: none !important;
                                }
                                #search-book{
                                    text-indent:10px; 
                                    color: dodgerblue; 
                                    border: 1px solid dodgerblue; 
                                    height:50px; width:100%;
                                }
                                /* .s-div{
                                    list-style:none; 
                                    position:absolute; 
                                    width:100%; 
                                    display:none; 
                                    height:300px; 
                                    overflow-y:scroll;
                                    background-color: black;
                                    color: white;
                                } */
                            </style>

                   
                
                    
                   <div class="row">
                    <div class="col-md-12">
                   
                        <div id="res"></div>
                        <div  style="position: relative;">
                        <label for="">Copon Code</label>
                        <input id="search-book" class="edit-this-coupon my-input getEmpList" type="search" name="code" value="<?php echo $cp['code']; ?>" aria-label="Search">
                        <input type="hidden" name="ignore_id" class="getEmpList" value="<?php echo $cp['id']; ?>">
                        <div  role="search" style="position:relative;">
                        </div>
                        <?php pkAjax("#search-book","/admin/$plugin_dir/get-coupon-list-ajax",".getEmpList","#res",'keyup'); 
                            ajaxActive($qry=".progress");
                            ?>                    
                    </div>
                    </div>
                   <div class="col my-3">
                        <label for="">Discount Value</label>
                        <input type="number" scope="any" name="discount_value" value="<?php echo $cp['discount_value']; ?>" class="edit-this-coupon form-control py-3 inc-dec-op-hide">
                        
                        
                    </div>
                    <div class="col my-3">
                        <label for="">Min. Purchase amt</label>
                        <input type="number" scope="any" name="min_purchase_amt" value="<?php echo $cp['min_purchase_amt']; ?>" class="edit-this-coupon form-control py-3 inc-dec-op-hide">
                        
                        
                    </div>
                   <div class="col my-3">
                       
                        <label for="">Discount type</label>
                        <select name="discount_type" class="edit-this-coupon form-select py-3">
                            <option <?php echo $cp['discount_type']=="%"?"selected":null; ?> value="%">Percent(%)</option>
                            <option <?php echo $cp['discount_type']=="amt"?"selected":null; ?> value="amt">Amount(Flat)</option>
                        </select>                        
                    </div>
                    <div class="col-md-12">
                        <label for="">Copon Name</label>
                        <input type="text" name="name" value="<?php echo $cp['name']; ?>" class="edit-this-coupon form-control py-3">
                        <input type="hidden" name="coupon_group" value="<?php echo $cp['coupon_group']; ?>" class="edit-this-coupon form-control py-3">
                        <label for="">Copon Detail</label>
                        <textarea name="details" rows="3" class="edit-this-coupon form-control py-3"><?php echo $cp['details']; ?></textarea>
                    </div>
                   </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Create Date</label>
                        <input name="created_at" value="<?php echo $cp['created_at']; ?>" type="datetime-local" class="edit-this-coupon form-control my-3">
                        <label for="">End Date</label>
                        <input name="expiry_date" value="<?php echo $cp['expiry_date']; ?>" type="datetime-local" class="edit-this-coupon form-control my-3">
                      
                        <div class="d-grid">
                            <button id="edit-this-coupon" class="btn btn-primary btn-lg">Update</button>
                            <input type="hidden" class="edit-this-coupon" name="cpid" value="<?php echo $_GET['id']; ?>">
                            <?php pkAjax('#edit-this-coupon',"/admin/$plugin_dir/edit-this-coupon-ajax",".edit-this-coupon","#res"); ?>
                        </div>
                        <div class="progress my-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-prime" role="progressbar" aria-label="Animated striped example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
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