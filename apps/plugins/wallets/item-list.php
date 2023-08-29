<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
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

                <div class="row">
                    <div class="col-md-12">
                        <h3><?php echo ucfirst($wallet_group); ?> Wallet List</h3>
                        <div id="res"></div>
                        <table class="table table-hover">
                            <tr>

                                <th>Wallet ID</th>
                                <th>User id</th>
                                <th>Email</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Total amoount</th>
                                <th>Pending amount</th>
                                <th>Paid amount</th>
                                <th>Open</th>
                            </tr>
                            <tr>

                                <th>1203</th>
                                <th>150</th>
                                <th>email@example.com</th>
                                <th>John</th>
                                <th>Doe</th>
                                <th>1500</th>
                                <th>500</th>
                                <th>1000</th>
                                <th>
                                    <a class="btn btn-success btn-sm" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/wallet-edit/?wallet_id=123&user_id=123&wallet_group=<?php echo $wallet_group; ?>">Open</a>
                                </th>
                            </tr>
                            <tr>

                                <th>1203</th>
                                <th>150</th>
                                <th>email@example.com</th>
                                <th>John</th>
                                <th>Doe</th>
                                <th>1500</th>
                                <th>500</th>
                                <th>1000</th>
                                <th>
                                    <a class="btn btn-success btn-sm" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/wallet-edit/?wallet_id=123&user_id=123&wallet_group=<?php echo $wallet_group; ?>">Open</a>
                                </th>
                            </tr>
                            <tr>

                                <th>1203</th>
                                <th>150</th>
                                <th>email@example.com</th>
                                <th>John</th>
                                <th>Doe</th>
                                <th>1500</th>
                                <th>500</th>
                                <th>1000</th>
                                <th>
                                    <a class="btn btn-success btn-sm" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/wallet-edit/?wallet_id=123&user_id=123&wallet_group=<?php echo $wallet_group; ?>">Open</a>
                                </th>
                            </tr>
                            <tr>

                                <th>1203</th>
                                <th>150</th>
                                <th>email@example.com</th>
                                <th>John</th>
                                <th>Doe</th>
                                <th>1500</th>
                                <th>500</th>
                                <th>1000</th>
                                <th>
                                    <a class="btn btn-success btn-sm" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/wallet-edit/?wallet_id=123&user_id=123">Open</a>
                                </th>
                            </tr>


                        </table>
                    </div>
                </div>

            </div>

           
            <div id="res"></div>
          

        </div>
    </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>