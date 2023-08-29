<?php if (is_superuser()) :
    if (isset($_GET['filter']) && intval($_GET['filter'])) {
        $user = getData('pk_user', $_GET['filter']);
        $delvia = null;
    } else if (isset($_GET['filter']) && $_GET['filter'] == 'courier') {
        $delvia = "courier";
        $user = USER;
    } else {
        $user = USER;
        $delvia = null;
    }
else :
    $user = USER;
    $delvia = null;
endif;
$status = $_GET['status'];
$ords = parcel_bookings($status);

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
                <a class="btn btn-dark" href="/<?php echo home; ?>/admin/orders">Back</a>
                <div id="res"></div>
                <div class="card-body">
                    <p class=""><?php echo $status; ?></p>

                    <h2><?php echo $ords->ordCount; ?> <small>Order<?php echo $ords->ordCount > 1 ? "s" : null; ?></small></h2>

                </div>
                <div class="row">
                    <div class="col-md-12 my-1">
                        <label for="">From</label>
                        <input type="date" name="from_date" class="form-control">
                    </div>
                    <div class="col-md-12 my-1">
                        <label for="">To</label>
                        <input type="date" name="from_date" class="form-control">
                    </div>
                    <div class="col-md-12 my-1">
                        <button class="btn btn-dark">Download Report</button>
                    </div>
                </div>
                <!-- <a class="btn btn-light" href="/<?php // echo home; 
                                                        ?>/admin/generate-report/?status=<?php // echo $status; 
                                                                                            ?>">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a> -->
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
                <div id="res"></div>
                <?php foreach ($ords->cp as $cp) :
                    $tamt = $cp['user_amount'];
                    $user = getData('pk_user', $cp['user_id']);

                ?>
                    <tbody style="border: 1px dotted black;">
                        <tr>
                            <th colspan="5"><span class="text-muted">Order Number : </span><?php echo $cp['unique_id']; ?></th>

                            <?php if (strtolower($cp['status']) == 'new order') { ?>
                                <th class="">
                                    <span class="text-muted">Order Status : </span><?php echo ucfirst($cp['status']); ?> <br>
                                    <button id="change_order_status_select<?php echo $cp['id']; ?>" class="btn btn-primary btn-sm">Accept</button>
                                    <input type="hidden" class="ds<?php echo $cp['id']; ?>" name="order_id" value="<?php echo $cp['id']; ?>">
                                    <input type="hidden" class="ds<?php echo $cp['id']; ?>" name="status" value="accepted">
                                    <?php pkAjax("#change_order_status_select{$cp['id']}", "/admin/orders/change-booking-status-update-ajax", ".ds{$cp['id']}", "#res", 'click'); ?>
                                </th>
                            <?php } ?>

                            <th>
                                <div class="d-grid">
                                    <a class="btn btn-primary" href="/<?php echo home; ?>/admin/orders/order-details/?tid=<?php echo $cp['unique_id']; ?>">Open</a>
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2" scope="col">DBID</th>
                            <th colspan="2" scope="col">User Price</th>
                            <th colspan="2" scope="col">Selected Driver Price</th>

                        </tr>
                        <tr>
                            <th colspan="2"><?php echo $cp['id']; ?></th>
                            <td colspan="2"><?php echo $cp['user_amount']; ?>/-</td>
                            <td colspan="2"><?php echo $cp['driver_amount'] > 0 ? "{$cp['driver_amount']}/-" : "Not assigned"; ?></td>

                        </tr>
                        <tr>
                            <th>Cust. Name</th>
                            <th>Mobile</th>

                            <th>Pick up date</th>

                            <th>Delivery Date</th>

                        </tr>

                        <tr>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['mobile']; ?></td>


                            <td><?php echo $cp['pickup_date']; ?></td>
                            <td><?php echo $cp['delivery_date']; ?></td>

                        </tr>
                        <tr>
                            <th colspan="2">Consignment Dimension (LxBxH)</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Delivery Method</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo "{$cp['length']}{$cp['length_unit']}X{$cp['width']}{$cp['width_unit']}X{$cp['height']}{$cp['height_unit']}" ?>
                            </td>
                            <td><?php echo "{$cp['from_address']}"; ?></td>
                            <td><?php echo "{$cp['to_address']}"; ?></td>
                            <td><?php echo "{$cp['delivery_method']}"; ?></td>
                        </tr>
                    </tbody>

                <?php endforeach; ?>

            </table>
        </div>
    </div>

</section>