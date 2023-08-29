<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$id = 0;
if (isset($_GET['rid'])) {
    $id = $_GET['rid'];
}
$plugin_dir = "wallets";
$wallet_group = isset($_GET['wallet_group'])?$_GET['wallet_group']:'driver';
?>

<style>
    .list-none li {
        font-weight: bold;
    }

    .menu-col {
        min-height: 300px !important;
    }

    .wallet-total {
        background-color: dodgerblue;
        color: white;
    }

    .wallet-pending {
        background-color: goldenrod;
        color: black;
    }

    .wallet-paid {
        background-color: lightgreen;
        color: black;
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
                <h4>John's wallet dashboard</h4>
                <a class="btn btn-dark my-2" href="/<?php echo home . "/admin/" . $plugin_dir; ?>/list/?wallet_group=<?php echo $wallet_group; ?>">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-4">

                            <div class="col-md-4">
                                <div class="shadow-sm card h-100 px-3 py-2 bg-primary text-white">
                                    <h3>Total amount = 1500/-</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="shadow-sm card h-100 px-3 py-2 bg-warning text-dark">
                                    <h3>Total pending amount = 500/-</h3>

                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#withdrawMoney">Withdraw</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="shadow-sm card h-100 px-3 py-2 bg-success text-white">
                                    <h3>Total paid amount = 1000/-</h3>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Transaction History</h3>
                        <table class="table table-hover">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Date and Time</th>
                                <th>Status</th>
                            </tr>
                            <tr class="bg-success text-white">
                                <th>1234</th>
                                <th>1000/-</th>
                                <th>2023-07-31 12:10:15</th>
                                <th>Success</th>
                            </tr>
                            <tr class="bg-danger text-white">
                                <th>1234</th>
                                <th>1000/-</th>
                                <th>2023-07-31 12:10:15</th>
                                <th>Failed</th>
                            </tr>
                            <tr class="bg-warning text-dark">
                                <th>1234</th>
                                <th>1000/-</th>
                                <th>2023-07-31 12:10:15</th>
                                <th>Pending</th>
                            </tr>
                        </table>
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