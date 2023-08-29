<?php
if (isset($_GET['tid'])) {
    $ord = get_order_by_uinique_id($uid = $_GET['tid'])[0];
    // echo "<pre>";
    // print_r($ord);
    // echo "</pre>";
}
?>
<div class="card">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row d-flex align-items-baseline">
                <div class="col-xl-9">
                    <p style="color: #7e8d9f;font-size: 20px;">Order >> <strong>ID: #<?php echo $ord['unique_id']; ?></strong></p>
                </div>
                <div class="col-md-3 text-end">
                    <a id="printBtn" onclick="myPrint(this)" class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark">
                    <i class="fas fa-print text-primary"></i> Print
                </a>
                    <!-- <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark"><i class="far fa-file-pdf text-danger"></i> Export</a> -->
                </div>
                <hr>
            </div>

            <div class="container">
                <div class="col-md-12">
                    <div class="text-center">
                        <div style="color: #7e8d9f;font-size: 30px;">
                            <strong>
                                Mobile App
                            </strong>
                        </div>
                        <p class="pt-0">Mobile Kart Company</p>
                    </div>

                </div>


                <div class="row">
                    <div class="col-5">
                        <ul class="list-unstyled">
                            <li class="text-muted">To: <span style="color:#5d9fc5 ;"><?php echo $ord['name']; ?></span></li>
                            <li class="text-muted ms-1"><i class="fas fa-location"></i> <?php echo $ord['company']; ?>, <?php echo $ord['city']; ?></li>
                            <li class="text-muted ms-4"><?php echo $ord['house_no']; ?>, Country</li>
                            <li class="text-muted ms-1"><i class="fas fa-phone"></i> <?php echo $ord['mobile']; ?></li>
                        </ul>
                        <p>
                            Deliver By : <strong><?php echo $ord['deliver_via']; ?></strong>
                        </p>
                    </div>
                    <div class="col-7">
                        <div class="float-end">
                        <p class="text-muted">Invoice</p>
                        <ul class="list-unstyled">
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold">ID:</span>#<?php echo $ord['unique_id']; ?></li>
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="fw-bold">Date: </span><?php echo $ord['created_at']; ?></li>
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span class="me-1 fw-bold">Status:</span><span class="text-upper badge bg-warning text-black fw-bold">
                            <?php echo $ord['payment_status']; ?></span></li>
                        </ul>
                        </div>
                    </div>
                </div>

                <div class="row my-2 mx-1 justify-content-center">
                    <table class="table table-striped table-borderless">
                        <thead style="background-color:#84B0CA ;" class="text-white">
                            <tr class="text-end">
                                <th scope="col">#</th>
                                <th scope="col">Description</th>
                                <th scope="col">Color</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total_amt = 0;
                            foreach ($ord['purchased_items'] as $od):
                            $tax_percentage = $od['tax_on_price_wot'];
                            $price_wot = $od['item_price_wot'];

                            $amt = $od['item_price']*$od['color_cart_qty'];
                            $total_amt += $amt;
                            ?>
                               
                            <tr class="text-end">
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $od['item_name']; ?> </td>
                                <td class="text-capt"> <?php echo $od['color']; ?></td>
                                <td><?php echo $od['color_cart_qty']; ?></td>
                                <td><?php echo $od['item_price']; ?></td>
                                <td><?php echo $amt; ?></td>
                            </tr>
                            <?php $i++; endforeach;    ?>
                           <tr class="text-end">
                            <td colspan="6" ><?php echo $total_amt; ?></td>
                           </tr>
                        </tbody>

                    </table>
                </div>
                <div class="row">
                    <!-- <div class="col-xl-8">
                        <p class="ms-3">Add additional notes and payment information</p>

                    </div> -->
                    <div class="col-12">
                        <p class="text-black float-end"><span class="text-black me-3"> Total Amount</span><span style="font-size: 25px;"><?php echo $total_amt; ?></span></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <p class="text-end">Thank you for your purchase</p>
                    </div>
                    <!-- <div class="col-xl-2">
                        <button type="button" class="btn btn-primary text-capitalize" style="background-color:#60bdf3 ;">Pay Now</button>
                    </div> -->
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const myPrint = (obj) =>{
     
        obj.style.display = "none";
        if (obj.style.display=="none") {
            window.print();
        }
    }
    document.addEventListener('mouseover', ()=>{
        document.getElementById("printBtn").style.display = 'inline-block';
    })
    
</script>