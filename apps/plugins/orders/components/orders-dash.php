<?php if (is_superuser()) : ?>
    <?php
    if (isset($_POST['salesman']) && intval($_POST['salesman'])) {
        $user = getData('pk_user', $_POST['salesman']);
        $delvia = null;
    } else if (isset($_POST['salesman']) && $_POST['salesman'] == 'courier') {
        $delvia = "courier";
        $user = USER;
    } else {
        $user = USER;
        $delvia = null;
    }
    $new_orders = parcel_bookings('new order');
    $processing = parcel_bookings('processing');
    $accepted = parcel_bookings('accepted');
    $assigned = parcel_bookings('assigned');
    $pending = parcel_bookings('pending');
    $delivered = parcel_bookings('delivered');
    $completed = parcel_bookings('completed');
    $cancelled = parcel_bookings('cancelled');
    $returned = parcel_bookings('returned');

    // print_r($processing->carts);
    ?>

<?php else : ?>
    <?php
    $user = USER;
    // $new_order = parcel_bookings('new order');
    // $processing = parcel_bookings('processing');
    // $accepted = parcel_bookings('accepted');
    // $assigned = parcel_bookings('assigned');
    // $pending = parcel_bookings('pending');
    // $delivered = parcel_bookings('delivered');
    // $completed = parcel_bookings('completed');
    // $cancelled = parcel_bookings('cancelled');
    // $returned = parcel_bookings('returned');
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
<?php endif; ?>


<section>

    <div class="row">
        <?php
        $status = $GLOBALS['bk_sts'];
        $card_color = ['bg-primary text-white', 'bg-secondary text-white', 'bg-warning text-dark', 'bg-info text-dark', 'bg-success text-white', 'bg-danger text-white', 'bg-danger text-dark', 'bg-dark text-white', 'bg-success text-white'];
        $i=0;
        foreach ($status as $key => $st) { 
            $order = parcel_bookings($st);
            ?>
       
        <div class="col-md-4 stretch-card  my-2">
            <div class="card card-tale <?php echo isset($card_color[$i])?$card_color[$i]:"bg-primary text-white"; ?>">
                <a class="btn btn-light" href="/<?php echo home; ?>/admin/orders/order-list/?status=<?php echo $st; ?>">Open</a>
                <div class="card-body">
                    <p class="text-upper"><?php echo $st; ?></p>
                    <h2><?php echo  $order->ordCount; ?> <small>Order<?php echo  $order->ordCount > 1 ? "s" : null; ?></small></h2>
                </div>
                <!-- <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=processing">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a> -->

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
            </div>
        </div>
        <?php 
    $i++;    
    }
        ?>
 

    </div>

</section>