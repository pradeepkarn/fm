<?php
$cart = cart_by_status('cart');
$hold = cart_by_status('hold');
$processing = cart_by_status('processing');
$completed = cart_by_status('completed');
$cancelled = cart_by_status('cancelled');
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
                <div class="card card-tale bg-info text-white">
                <a class="btn btn-light" href="/<?php echo home; ?>/admin/orders">Open</a>
                    <div class="card-body">
                        <p class="">Cart</p>
                        <h2><?php echo $cart->count; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-warning text-dark">
                     <a class="btn btn-light" href="/<?php echo home; ?>/admin/orders">Open</a>
                    <div class="card-body">
                        <p class="">Hold</p>
                        <h2><?php echo $hold->count; ?></h2>
                        
                    </div>
                   
                </div>
            </div>
      
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-success text-white">
                     <a class="btn btn-light" href="/<?php echo home; ?>/admin/orders">Open</a>
                    <div class="card-body">
                        <p class="">Processing</p>
                        <h2><?php echo $processing->count; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-primary text-white">
                     <a class="btn btn-light" href="/<?php echo home; ?>/admin/orders">Open</a>
                    <div class="card-body">
                        <p class="">Completed</p>
                        <h2><?php echo $completed->count; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-danger text-white">
                     <a class="btn btn-light" href="/<?php echo home; ?>/admin/orders">Open</a>
                    <div class="card-body">
                        <p class="">Cancelled</p>
                        <h2><?php echo $cancelled->count; ?></h2>
                    </div>
                </div>
            </div>
        </div>

</section>