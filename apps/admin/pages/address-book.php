<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>

<?php if (getAccessLevel()<=10): 
        $adr = getAddress($_SESSION['user_id'],"all");
        $ac = new Account();
        $user = $ac->getLoggedInAccount();
        if($user!=false){
            
        }
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
            <div class="container">
            <div class="row">
            <div class="col-md-8">
            <?php
                if (isset($_SESSION['from_checkout_page'])) { ?>
                 <a class="btn btn-warning mr-2" href="<?php echo $_SESSION['from_checkout_page']; ?>"> <i class="fas fa-arrow-left"></i> Back to Checkout</a> 
                <?php }
            ?>
            <button type="button" class="btn btn-dark btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-address">
                Add New Address
            </button>
            <div id="update-result"></div>
            <div class="accordion" id="accordionPanelsStayOpenExample">
            <?php 
                if ($adr!=false) :
                    foreach ($adr as $key => $adrs):
                ?>
                <form action="" id="address-update-form<?php echo $adrs['id']; ?>">
            <div class="accordion-item  mb-2">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel<?php echo $adrs['id']; ?>" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
            <?php echo $adrs['city']; ?> : <?php echo $adrs['zipcode']; ?>
            </button>
            <div id="panel<?php echo $adrs['id']; ?>" class="accordion-collapse collapse" aria-labelledby="panel<?php echo $adrs['id']; ?>">
      <div class="accordion-body">
                <div class="row">
                    <div class="col-md-4 pb-1">
                        <label for="">Name</label>
                        <input type="text" name="fullname" value="<?php echo $adrs['name']; ?>" placeholder="Firstname" class="form-control">
                    </div>
                    <div class="col-md-4 pb-1">
                    <label for="">Mobile</label>
                        <input type="number" name="mobile" value="<?php echo $adrs['mobile']; ?>" placeholder="Mobile" class="form-control">
                    </div>
                    <div class="col-md-4 pb-1">
                        <label for="">Delete</label>
                    <p class="text-danger">I want delete this address <input onclick="alert('This address will be deleted if you check this box');" type="checkbox" name="deleteaddress" value="<?php echo $adrs['id']; ?>"></p>
                    </div>
                    <div class="col-md-12 pb-1">
                    <label for="">Address</label>
                        <textarea name="locality" class="form-control" placeholder="Address" rows="3"><?php echo $adrs['locality']; ?></textarea>
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">City</label>
                        <input type="text" value="<?php echo $adrs['city']; ?>" name="city" placeholder="City" class="form-control">
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">State</label>
                        <input type="text" name="state" value="<?php echo $adrs['state']; ?>" placeholder="State" class="form-control">
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">Country</label>
                        <input type="text" name="country" value="<?php echo $adrs['country']; ?>" placeholder="Country" class="form-control">
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">Zip Code</label>
                        <input type="text" name="zipcode" value="<?php echo $adrs['zipcode']; ?>" placeholder="Zip Code" class="form-control">
                    </div>
                </div>
                </div>
                <div class="d-grid">
                    <input type="hidden" name="addrsid" value="<?php echo $adrs['id']; ?>">
                    <input type="hidden" name="updateaddress" value="<?php echo $adrs['id']; ?>">
                    <button type="button" class="btn btn-primary" id="update-btn-address<?php echo $adrs['id']; ?>">Update</button>
                </div>
                </div>
            </div>
            </form>
            <script>
        $(document).ready(function() {
            $('#update-btn-address<?php echo $adrs['id']; ?>').on('click',function(event) {
                event.preventDefault();
                $.ajax({
                    url: "/<?php echo home; ?>/dashboard/update-address",
                    method: "post",
                    data: $('#address-update-form<?php echo $adrs['id']; ?>').serializeArray(),
                    dataType: "html",
                    success: function(resultValue) {
                        $('#update-result').html(resultValue)
                        location.reload();
                    }
                });
            });
        });
    </script>
            <?php endforeach; ?>
            <?php endif; ?>
            </div>
            </div>
            </div>
        </div>
<!-- content ends here -->
</section>


  <div class="modal" tabindex="-1" id="modal-address">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="" id="address-new-form">
            <div class="row">
                    <div class="col-md-6 pb-1">
                        <label for="">Name</label>
                        <input type="text" name="fullname" value="" placeholder="Name" class="form-control">
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">Mobile</label>
                        <input type="number" name="mobile" value="" placeholder="Mobile" class="form-control">
                    </div>
                    
                    <div class="col-md-12 pb-1">
                    <label for="">Address</label>
                        <textarea name="locality" class="form-control" placeholder="Address" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">City</label>
                        <input type="text" value="" name="city" placeholder="City" class="form-control">
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">State</label>
                        <input type="text" name="state" value="" placeholder="State" class="form-control">
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">Country</label>
                        <input type="text" name="country" value="" placeholder="Country" class="form-control">
                    </div>
                    <div class="col-md-6 pb-1">
                    <label for="">Zip Code</label>
                        <input type="text" name="zipcode" value="" placeholder="Zip Code" class="form-control">
                    </div>
                </div>
                <input type="hidden" name="addnewaddress" value="addnewaddress">
                <div class="d-grid mt-2">
                <button type="button" id="add-btn-address" class="btn btn-primary">Save</button>
                </div>
                
        </form>
        <script>
        $(document).ready(function() {
            $('#add-btn-address').on('click',function(event) {
                event.preventDefault();
                $.ajax({
                    url: "/<?php echo home; ?>/dashboard/update-address",
                    method: "post",
                    data: $('#address-new-form').serializeArray(),
                    dataType: "html",
                    success: function(resultValue) {
                        $('#update-result').html(resultValue)
                        location.reload();
                    }
                });
            });
        });
    </script>
      </div>
     
    </div>
  </div>
</div>
<?php endif; ?>


            </section>









            <!-- content ends -->
            
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>