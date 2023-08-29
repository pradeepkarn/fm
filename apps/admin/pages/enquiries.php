<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php
if (isset($_POST['dlt_enq_id']) && isset($_POST['trash_my_enq'])) {
    //print_r($_POST);
    $dltitm = new Dbobjects();
    $dltitm->tableName = "contact";
    $dltitm->pk($_POST['dlt_enq_id']);
    $dltitm->delete();
}
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
            <?php if (getAccessLevel() <= 5) : ?>
                <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                    <?php import("apps/admin/inc/sidebar.php"); ?>
                </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (getAccessLevel() <= 5) ? "10" : "12"; ?>">
                <!-- Main Area -->
              

                <div class="row mt-5">
                    <div class="col-md-12">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['obj_group'])){echo $_GET['obj_group']=='all'?'active':null; }else{ echo "active"; } ?>" href="/<?php echo home; ?>/admin/enquiries/?obj_group=all">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['obj_group'])){echo $_GET['obj_group']=='rent-equipments'?'active':null; } ?>" href="/<?php echo home; ?>/admin/enquiries/?obj_group=rent-equipments">Rent Equipment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['obj_group'])){echo $_GET['obj_group']=='transportations'?'active':null; } ?>" href="/<?php echo home; ?>/admin/enquiries/?obj_group=transportations">Transportations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if(isset($_GET['obj_group'])){echo $_GET['obj_group']=='maintenance'?'active':null; } ?>" href="/<?php echo home; ?>/admin/enquiries/?obj_group=maintenance">Maintenance</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <table class="table-sm table table-bordered">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Message</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Message Type</th>
                                <!-- <th>Edit</th> -->
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php $db = new Dbobjects();
                                $db->tableName = "contact";
                                $contacts = $db->all($ord = "DESC", $limit = 500);
                                if (isset($_GET['obj_group'])) {
                                    switch ($_GET['obj_group']) {
                                        case 'rent-equipments':
                                            $contacts = $db->filter(['obj_group'=>$_GET['obj_group']],$ord = "DESC", $limit = 500);
                                            break;
                                        case 'transportations':
                                            $contacts = $db->filter(['obj_group'=>$_GET['obj_group']],$ord = "DESC", $limit = 500);
                                            break;
                                        case 'maintenance':
                                            $contacts = $db->filter(['obj_group'=>$_GET['obj_group']],$ord = "DESC", $limit = 500);
                                            break;
                                        default:
                                        $contacts = $db->all($ord = "DESC", $limit = 500);
                                            break;
                                    }
                                }
                                
                                $pdqry = null;
                                foreach ($contacts as $pk => $pv) {
                                    if ($pv['status'] != "trash") {
                                ?>

                                        <tr>

                                            <td><?php echo $pv['id']; ?></td>
                                            <td><?php echo $pv['name']; ?></td>
                                            <td><?php echo $pv['message']; ?></td>
                                            <td><?php echo $pv['email']; ?></td>
                                            <td><?php echo $pv['mobile']; ?></td>
                                            <td><?php echo $pv['company']; ?></td>
                                            <td><?php echo $pv['status']; ?></td>
                                            <td><?php echo $pv['type']; ?></td>
                                            <!-- <td><a href="edit_contact/<?php //echo $pv['id']; 
                                                                            ?>">Edit</a></td>  -->
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="dlt_enq_id" value="<?php echo $pv['id']; ?>">
                                                    <input type="hidden" name="trash_my_enq" value="<?php echo $pv['id']; ?>">
                                                    <button class="btn btn-sm" type="submit"><i class="fas fa-trash text-danger"></i> </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php }
                                }
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