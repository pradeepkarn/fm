<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php 
if (isset($_POST['review_id']) && isset($_POST['status'])) {
    $db = new Mydb('review');
    $db->pkData($_POST['review_id']);
    $db->updateData(['status'=>$_POST['status']]);
}
?>
<style>
.list-none li{
    font-weight: bold;
}
.menu-col{
    min-height: 300px !important;
}
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php if(getAccessLevel()<=5): ?>
            <div id="sidebar-col" class="col-md-2 bg-dark">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (getAccessLevel()<=5)?"10":"12"; ?>">
                <!-- Main Area -->
            <?php import("apps/admin/pages/page-nav.php"); ?>
            <div class="row">
        <div class="col-md-12">
            <table class="table-sm table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Delete</th>
                </thead>
                <tbody>
            <?php $db = new Dbobjects();
                $db->tableName = "review";
                $contacts = $db->all($ord = "DESC",$limit = 500);
                 $pdqry = null;
                foreach ($contacts as $pk => $pv) { 
                    
                        $prod = get_service_by_id($pv['service_id']);
                    ?>
                
                <tr>
                    
                    <td><?php echo $pv['id']; ?></td> 
                    <td><?php echo $pv['name']; ?></td> 
                    <td><?php echo $pv['message']; ?></td> 
                    <td><?php echo $pv['email']; ?></td> 
                    <td>
                    <form action="" method="post">
                        <select name="status" class="form-control">
                            <option <?php matchData($pv['status'],'cancelled', 'selected'); ?> value="cancelled">Cancelled</option>
                            <option <?php matchData($pv['status'],'pending', 'selected'); ?> value="pending">Pending</option>
                            <option <?php matchData($pv['status'],'approved', 'selected'); ?> value="approved">Approved</option>
                            <option <?php matchData($pv['status'],'trash', 'selected'); ?> value="trash">Trash</option>
                            <input type="hidden" name="review_id" value="<?php echo $pv['id']; ?>">
                        </select>
                        <div class="d-grid">
                        <button class="btn btn-sm btn-primary my-2" type="submit">Update</button>
                        </div>
                    </form>
                    </td>
                    <td><a target="_blank" href="/<?php echo home; ?>/book-service/?serviceid=<?php echo $prod['id']; ?>">
                        <i class='fas fa-eye'></i>
                        </a></td> 
                    <td>  
                    <form action="" method="post">
                        <input type="hidden" name="dlt_enq_id" value="<?php echo $pv['id']; ?>">
                        <input type="hidden" name="trash_my_enq" value="<?php echo $pv['id']; ?>">
                        <input type="checkbox" name="delete_review" value="<?php echo $pv['id']; ?>">
                        <button class="btn btn-sm" type="submit"><i class="fas fa-trash text-danger"></i> </button>
                    </form>  
                </td> 
                </tr>
            <?php } 
                ?>
                </tbody>
            </table>
        </div>
    </div>

                <!-- Main Area Ends -->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>