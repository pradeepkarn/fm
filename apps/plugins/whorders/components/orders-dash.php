
<?php 
$pluign_dir = "whorders";
if (is_superuser() || USER['user_group']=="whmanager") : ?>
    <?php
if (isset($_POST['salesman']) && intval($_POST['salesman'])) {
    $user = getData('pk_user',$_POST['salesman']);
    $delvia = null;
}
else if (isset($_POST['salesman']) && $_POST['salesman']=='courier') {
    $delvia = "courier";
    $user = USER;
}

else{
    $user = USER;
    $delvia = null;
}
$new = wh_orders('new',$user,$delvia);
$accepted = wh_orders('accepted',$user,$delvia);
$dispatched = wh_orders('dispatched',$user,$delvia);
$ready = wh_orders('ready',$user,$delvia);
$rejected = wh_orders('rejected',$user,$delvia);
$pennding = wh_orders('pending',$user,$delvia);

// print_r($processing->carts);
?>
<section>
    <form action="" method="post">
    <div class="row">
        <div class="col-md-6">
            <h5 class="my-4">
                Warehouse Dashboard
            </h5>
        </div>
        <div class="col-md-4">
            <h5 class="my-4">
                Filter by All/Salesman/Courier
            </h5>
            <select name="salesman" class="form-select">
                <option value="all">All</option>
                <option <?php if(isset($_POST['salesman']) && $_POST['salesman']=="courier"){echo "selected";} ?> value="courier">Courier</option>
                <?php foreach (getSalesmanList() as $sm) { ?>
                   <option <?php if(isset($_POST['salesman']) && $_POST['salesman']==$sm['id']){echo "selected";} ?> value="<?php echo $sm['id']; ?>"><?php echo $sm['name']; ?> (ID:<?php echo $sm['id']; ?>)</option>
                <?php } ?>
                
            </select>
        </div>
        <div class="col-md-2">
            <h5 class="my-4">
                Filter
            </h5>
           <button type="submit" class="btn btn-primary">Go</button>
        </div>
    </div>
    </form>
</section>
<?php else: ?>
<?php
$user = USER;
$new = wh_orders('new',$user);
$accepted = wh_orders('accepted',$user);
$dispatched = wh_orders('dispatched',$user);
$ready = wh_orders('ready',$user);
$rejected = wh_orders('rejected',$user);
$pennding = wh_orders('pennding',$user);
?>
    <section>
    <div class="row">
        <div class="col-md-12">
            <h3 class="my-4">
                Warehouse Dashboard
            </h3>
        </div>
    </div>
</section>
<?php endif; ?>


<section>

        <div class="row">
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-secondary text-white">
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/<?php echo $pluign_dir; ?>/order-list/?status=new<?php if(isset($_POST['salesman'])){echo "&filter={$_POST['salesman']}"; } ?>">Open</a>
                    <div class="card-body">
                        <p class="">New</p>
                        <h2><?php echo $new->ordCount; ?> <small>Order<?php echo $new->ordCount>1?"s":null; ?></small></h2>
                        <p>With <?php echo $new->cartQty; ?> <small>Quantity</small></p>
                    </div>
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=new">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-info text-dark">
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/<?php echo $pluign_dir; ?>/order-list/?status=accepted<?php if(isset($_POST['salesman'])){echo "&filter={$_POST['salesman']}"; } ?>">Open</a>
                    <div class="card-body">
                        <p class="">Accepted</p>
                        <h2><?php echo $accepted->ordCount; ?> <small>Order<?php echo $accepted->ordCount>1?"s":null; ?></small></h2>
                        <p>With <?php echo $accepted->cartQty; ?> <small>Quantity</small></p>
                    </div>
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=accepted">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-success text-white">
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/<?php echo $pluign_dir; ?>/order-list/?status=dispatched<?php if(isset($_POST['salesman'])){echo "&filter={$_POST['salesman']}"; } ?>">Open</a>
                    <div class="card-body">
                        <p class="">Dispatched</p>
                       <h2><?php echo $dispatched->ordCount; ?> <small>Order<?php echo $dispatched->ordCount>1?"s":null; ?></small></h2>
                        <p>With <?php echo $dispatched->cartQty; ?> <small>Quantity</small></p>
                    </div>
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=dispatched">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a>
                </div>
            </div>
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-warning text-dark">
                     <a class="btn btn-light" href="/<?php echo home; ?>/admin/<?php echo $pluign_dir; ?>/order-list/?status=pending<?php if(isset($_POST['salesman'])){echo "&filter={$_POST['salesman']}"; } ?>">Open</a>
                    <div class="card-body">
                        <p class="">Pending</p>
                        <h2><?php echo $pennding->ordCount; ?> <small>Order<?php echo $pennding->ordCount>1?"s":null; ?></small></h2>
                        <p>With <?php echo $pennding->cartQty; ?> <small>Quantity</small></p>
                    </div>
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=pending">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a>
                   
                </div>
            </div>
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-danger text-white">
                     <a class="btn btn-light" href="/<?php echo home; ?>/admin/<?php echo $pluign_dir; ?>/order-list/?status=rejected<?php if(isset($_POST['salesman'])){echo "&filter={$_POST['salesman']}"; } ?>">Open</a>
                    <div class="card-body">
                        <p class="">Rejected</p>
                        <h2><?php echo $rejected->ordCount; ?> <small>Order<?php echo $rejected->ordCount>1?"s":null; ?></small></h2>
                        <p>With <?php echo $rejected->cartQty; ?> <small>Quantity</small></p>
                        
                    </div>
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=rejected">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a>
                </div>
            </div>
            
            <div class="col-md-4 stretch-card  my-2">
                <div class="card card-tale bg-primary text-white">
                     <a class="btn btn-light" href="/<?php echo home; ?>/admin/<?php echo $pluign_dir; ?>/order-list/?status=ready<?php if(isset($_POST['salesman'])){echo "&filter={$_POST['salesman']}"; } ?>">Open</a>
                    <div class="card-body">
                        <p class="">Ready</p>
                        <h2><?php echo $ready->ordCount; ?> <small>Order<?php echo $ready->ordCount>1?"s":null; ?></small></h2>
                        <p>With <?php echo $ready->cartQty; ?> <small>Quantity</small></p>
                    </div>
                    <a class="btn btn-light" href="/<?php echo home; ?>/admin/generate-report/?status=ready">Download Report <i class="fa-solid fa-file-csv"></i> <i class="fa-solid fa-download"></i> </a>
                </div>
            </div>
            
        </div>

</section>