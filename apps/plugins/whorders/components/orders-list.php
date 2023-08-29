<?php if (is_superuser() || USER['user_group']=="whmanager") : 
if (isset($_GET['filter']) && intval($_GET['filter'])) {
    $user = getData('pk_user',$_GET['filter']);
    $delvia = null;
}
else if (isset($_GET['filter']) && $_GET['filter']=='courier') {
    $delvia = "courier";
    $user = USER;
}
else{
    $user = USER;
    $delvia = null;
}
else:
    $user = USER;
    $delvia = null;
endif;
$status = $_GET['status'];
$ords = wh_orders($status,$user,$delvia);

// print_r($ords->carts);
?>

<section>
    <div class="row">
        <div class="col-md-12">
            <h3 class="my-4">
                Order Dashboard
            </h3>
        </div>
    </div>
</section>
<section>

    <div class="row">
        <div class="col-md-4 stretch-card  my-2">
            <div class="card card-tale bg-secondary text-white">
                <a class="btn btn-dark" href="/<?php echo home; ?>/admin/whorders">Back</a>
               
                <div class="card-body">
                    <p class=""><?php echo $status; ?></p>
                  
                    <h2><?php echo $ords->ordCount; ?> <small>Order<?php echo $ords->ordCount>1?"s":null; ?></small></h2>
                        <p>With <?php echo $ords->cartQty; ?> <small>Quantity</small></p>
                </div>
                <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=<?php echo $status; ?>">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a>
            </div>
        </div>
        <div class="col-md-8">
            <table class="table table-sm table-bordered">
                <style>
                    tbody::before {
                        content: '';
                        display: block;
                        height: 15px;
                        visibility: hidden;

                    }
                </style>

                <?php foreach ($ords->cp as $cp) :
                    $tamt = $cp['amount'] + $cp['discount_amt'];
                ?>
                    <tbody style="border: 1px dotted black;">
                        <tr>
                            <th colspan="4"><span class="text-muted">Order Number : </span><?php echo $cp['unique_id']; ?></th>
                            <th>
                                <span class="text-muted">Order Status : </span><?php echo ucfirst($cp['order_status']); ?>
                                
                        </th>
                            <th>
                            <div class="d-grid">
                                    <a class="btn btn-primary" href="/<?php echo home; ?>/admin/whorders/order-details/?tid=<?php echo $cp['unique_id']; ?>">Open</a>
                                </div>
                        </th>
                        </tr>
                        <tr>
                            <th scope="col">DBID</th>
                            <th scope="col">Gross Amt.</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Net Amt.</th>
                            <th scope="col">Disc. By</th>
                            <th scope="col">Disc. Ref.</th>
                        </tr>
                        <tr>
                            <th><?php echo $cp['id']; ?></th>
                            <td><?php echo $tamt; ?></td>
                            <td><?php echo $cp['discount_amt']; ?></td>
                            <td><?php echo $cp['amount']; ?></td>
                            <td><?php echo $cp['discount_type']; ?></td>
                            <td><?php echo $cp['discount_ref']; ?></td>
                        </tr>
                        <tr>
                            <th>Cust. Name</th>
                            <th>Mobile</th>
                            <th>City</th>
                            <th>Deliver Via</th>
                            <th>Delivery Date</th>
                            <th>Last action</th>
                        </tr>
                        <tr>
                            <td><?php echo $cp['name']; ?></td>
                            <td><?php echo $cp['mobile']; ?></td>
                            <td><?php echo $cp['city']; ?></td>
                            <td><?php echo $cp['deliver_via']; ?></td>
                            <td><?php echo $cp['delivery_date']; ?></td>
                            <td><?php echo $cp['last_action_on']; ?></td>

                        </tr>
                    </tbody>
                <?php endforeach; ?>

            </table>
        </div>
    </div>

</section>