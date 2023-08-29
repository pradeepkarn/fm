<?php import("apps/view/inc/header.php"); ?>

<style>
textarea.save-data form-control{
   resize: none;
}
</style>
  <main id="main">
<?php 
$user_id = $_GET['edit_user_id'];
$userobj = new Model('pk_user');
$user = $userobj->show($user_id);
$data = json_decode($user['application_json_data']);
if ($user['application_json_data']=="") {
    return;
}
?>
    <!-- ======= About Section ======= -->
    <section id="about" class="about" style="margin-top: 50px;">
      <div class="container" data-aos="fade-up">
<?php // echo ($user['application_json_data']); ?>
        <div class="section-header">
          <h2>About Us</h2>
          <p>Apply For <span>Certificate of inspection</span></p>
        </div>
        <form action="/<?php echo home; ?>/apply-cert-ajax" method="post" id="form-save-data">
        <div class="row">
            <div class="col-md-12 my-2">
                <div class="form-floating">
                <input name="col_num" value="<?php echo $data->col_num; ?>" type="text" class="save-data form-control" id="colNumForm">
                <label for="colNumForm">Col No.</label>
                </div>
            </div>
          
        </div>
        <div class="row">
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="ins_date" type="date" class="save-data form-control" id="incrnceDtForm">
                <label for="incrnceDtForm"><?php echo $data->ins_date; ?></label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="acid" value="<?php echo $data->acid; ?>" type="text" class="save-data form-control" id="acidForm">
                <label for="acidForm">ACID</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="importer_num" value="<?php echo $data->importer_num; ?>" type="text" class="save-data form-control" id="impNumForm">
                <label for="impNumForm">Importer Number</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <textarea name="importer_address" class="save-data form-control" id="importerAddressForm"><?php echo $data->importer_address; ?></textarea>
                <label for="importerAddressForm">Address</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="producer" value="<?php echo $data->producer; ?>" type="text" class="save-data form-control" id="producerForm">
                <label for="producerForm">Producer</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <textarea name="producer_address" class="save-data form-control" id="producerAddressForm"><?php echo $data->producer_address; ?></textarea>
                <label for="producerAddressForm">Address</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="exporter" value="<?php echo $data->exporter; ?>" type="text" class="save-data form-control" id="exporterForm">
                <label for="exporterForm">Exporter</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <textarea name="exporter_address" class="save-data form-control" id="exporterAddressForm"><?php echo $data->exporter_address; ?></textarea>
                <label for="exporterAddressForm">Address</label>
                </div>
            </div>
            <div class="col-md-5 my-2">
                <div class="form-floating">
                <input name="invoice_amt" value="<?php echo $data->invoice_amt; ?>" type="text" class="save-data form-control" id="invoiceAMtForm">
                <label for="invoiceAMtForm">Invoice Amount/Currency</label>
                </div>
            </div>
            <div class="col-md-5 my-2">
                <div class="form-floating">
                <input name="invoice_number" value="<?php echo $data->invoice_number; ?>" type="text" class="save-data form-control" id="invNumForm">
                <label for="invNumForm">Invoice Number</label>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="form-floating">
                <input name="invoice_date" type="date" class="save-data form-control" id="invDate">
                <label for="invDate"><?php echo $data->invoice_date; ?></label>
                </div>
            </div>
            <div class="col-md-12 my-2">
                <h4 class="text-center">Transport Details</h4>
            </div>
            <div class="col-md-5 my-2">
                <div class="form-floating">
                <input name="method_of_shipment" value="<?php echo $data->method_of_shipment; ?>" type="text" class="save-data form-control" id="methdOfShpmnt" value="">
                <label for="methdOfShpmnt">Method of shipment</label>
                </div>
            </div>
            <div class="col-md-5 my-2">
                <div class="form-floating">
                <input name="document_number" value="<?php echo $data->document_number; ?>" type="text" class="save-data form-control" id="documentNumForm" value="">
                <label for="documentNumForm">Document Number</label>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="form-floating">
                <input name="document_date" type="date" class="save-data form-control" id="documentDate" value="">
                <label for="documentDate"><?php echo $data->document_number; ?></label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="country_of_shipment" value="<?php echo $data->country_of_shipment; ?>" type="text" class="save-data form-control" id="cntryshpmntForm" value="">
                <label for="cntryshpmntForm">Country of shipment</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="point_of_entry" value="<?php echo $data->point_of_entry; ?>" type="text" class="save-data form-control" id="point_of_entryForm" value="">
                <label for="point_of_entryForm">Point of entry</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="num_n_pkg_typ" value="<?php echo $data->num_n_pkg_typ; ?>" type="text" class="save-data form-control" id="num_n_pkg_typForm" value="">
                <label for="num_n_pkg_typForm">No. and types of packages (Total Cartons)</label>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="form-floating">
                <input name="container_truck_num" value="<?php echo $data->container_truck_num; ?>" type="text" class="save-data form-control" id="container_truck_numForm" value="">
                <label for="container_truck_numForm">Container Truck Numbers</label>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="form-floating">
                <input name="declared_unit_qty" value="<?php echo $data->declared_unit_qty; ?>" type="text" class="save-data form-control" id="dlcrdQtyUnitForm" value="">
                <label for="dlcrdQtyUnitForm">Declared Qty/Unit</label>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="form-floating">
                <input name="country_of_origin" value="<?php echo $data->country_of_origin; ?>" type="text" class="save-data form-control" id="country_of_originForm" value="">
                <label for="country_of_originForm">Country of origin</label>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="form-floating">
                <input name="declared_unit_qty" value="<?php echo $data->declared_unit_qty; ?>" type="text" class="save-data form-control" id="productTypeForm" value="">
                <label for="productTypeForm">Product Type</label>
                </div>
            </div>
            <div class="col-md-4 my-2">
                <div class="form-floating">
                <textarea name="brand_desc" value="<?php echo $data->brand_desc; ?>" class="save-data form-control" id="brandDescForm"></textarea>
                <label for="brandDescForm">Goods Description(Brand/Model)</label>
                </div>
            </div>
            <div class="col-md-2 my-2">
                <div class="form-floating">
                <input name="accridated" value="<?php echo $data->accridated; ?>" type="text" class="save-data form-control" id="accridatedForm" value="">
                <label for="accridatedForm">Accridated/Standars</label>
                </div>
            </div>
            <div class="col-md-3 mx-auto my-2">
                <div id="res"></div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated"></div>
                </div>
                <div class="d-grid">
                <input type="hidden" class="save-data" name="save_my_form" value="1">
                <button class="btn btn-primary btn-lg">Print</button>
                </div>
            </div>
        </div>
        </form>
      </div>
    </section>
   
    <?php pkAjax_form("#submitBtn","#form-print-data","#res",'click',true); ?>
    <?php ajaxActive(".progress"); ?>
    <!-- End About Section -->

  </main><!-- End #main -->
		
<?php import("apps/view/inc/footer.php"); ?>	