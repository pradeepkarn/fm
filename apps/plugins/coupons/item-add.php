<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); 
$plugin_dir = "coupons";
$cpcode = strtoupper(bin2hex(random_bytes(4)));
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
                        <input id="search-book" value="<?php echo $cpcode; ?>" class="add-this-coupon my-input getEmpList" type="search" name="code" aria-label="Search">
                        <div  role="search" style="position:relative;">
                   
                        </div>
                        <?php pkAjax("#search-book","/admin/$plugin_dir/get-coupon-list-ajax",".getEmpList","#res",'keyup'); 
                            ajaxActive($qry=".progress");
                            ?>                    
                    </div>
                    </div>
                   <div class="col my-3">
                        <label for="">Discount Value</label>
                        <input type="number" scope="any" name="discount_value" class="add-this-coupon form-control py-3 inc-dec-op-hide">
                        
                        
                    </div>
                   <div class="col my-3">
                        <label for="">Min. Purchase amt</label>
                        <input type="number" scope="any" name="min_purchase_amt" value="100" class="add-this-coupon form-control py-3 inc-dec-op-hide">
                        
                        
                    </div>
                   <div class="col my-3">
                       
                        <label for="">Discount type</label>
                        <select name="discount_type" class="add-this-coupon form-select py-3">
                            <option value="%">Percent(%)</option>
                            <option value="amt">Amount(Flat)</option>
                        </select>                        
                    </div>
                    <div class="col-md-12">
                        <label for="">Copon Name</label>
                        <input type="text" name="name" class="add-this-coupon form-control py-3">
                        <input type="hidden" name="coupon_group" value="general" class="add-this-coupon form-control py-3">
                        <label for="">Copon Detail</label>
                        <textarea name="details" rows="3" class="add-this-coupon form-control py-3"></textarea>
                    </div>
                   </div>
                    </div>
                    <div class="col-md-4">
                        <label for="">Create Date</label>
                        <input name="created_at" value="<?php echo date("Y-m-01 H:i:s"); ?>" type="datetime-local" class="add-this-coupon form-control my-3">
                        <label for="">End Date</label>
                        <input name="expiry_date" value="<?php echo date("Y-m-t H:i:s"); ?>" type="datetime-local" class="add-this-coupon form-control my-3">
                      
                        <div class="d-grid">
                            <button id="add-this-coupon" class="btn btn-primary btn-lg">Add</button>
                            <input type="hidden" class="add-this-coupon" name="content_group" value="<?php echo $_GET['coupon_group']; ?>">
                            <?php pkAjax('#add-this-coupon',"/admin/$plugin_dir/add-this-coupon-ajax",".add-this-coupon","#res"); ?>
                        </div>
                        <div class="progress my-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-prime" role="progressbar" aria-label="Animated striped example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
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
    <?php pkAjax_form("#add-new-cat-btn","#add-new-product-btn-form","#res",'click','post',true); ?>
    <?php ajaxActive(".progress"); ?>  







       <!-- Main Area ends-->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>