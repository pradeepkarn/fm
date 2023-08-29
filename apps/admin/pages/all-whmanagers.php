<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "All Users"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php 
$user_group = "whmanager";
    if (isset($_POST['update_user_id'])) {
        $role = 'subscriber';
        // switch ($_POST['access_level']) {
        //     case '1':
        //         $role = 'superuser';
        //         break;
        //     case '2':
        //         $role = 'admin';
        //         break;
        //     case '5':
        //         $role = 'premium';
        //         break;
        //     case '10':
        //         $role = 'general';
        //         break;
        //     default:
        //         $role = 'general';
        //         break;
        // }
        $db = new Mydb('pk_user');
        $updateuer = $db->pkData($_POST['update_user_id']);
        $arr = null;
        $arr['name'] = $_POST['fullname'];
        $arr['status'] = $_POST['status'];
        $arr['info'] = $_POST['info'];
        if ($updateuer['username']=="admin") {
            $arr['role'] = "superuser";
            $arr['access_level'] = 1;
            $arr['status'] = "verified";
        }
        else{
            $arr['role'] = $role;
        }
        $date = date("Y-m-d h:i:s a");
        $arr['updated_at'] = $date;
        
        $db->updateData($arr);
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
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <?php endif; ?>
            <div id="content-col" class="col-md-<?php echo (getAccessLevel()<=5)?"10":"12"; ?>">
                <!-- Main Area -->
            <?php import("apps/admin/pages/page-nav.php"); ?>
       
            <div class="row">
                <div class="col-md-12 ms-auto mb-2">
                <form action="/<?php echo home; ?>/admin/all-users/">
                <div class="d-flex">
                    <input type="search" name="user_serch_keywords" placeholder="Search user by id or username or name or email or registartion date" class="form-control" placeholder="Search user">
                    <input type="submit" value="Search User" class="ms-3 btn btn-dark">
                </div>
                </form>
                </div>
            <div class="col-md-12">
                <div class="pagination">
                    
                    <?php $enqs = new Model('pk_user'); 
                    if ($enqs->filter_index(array('user_group'=>$user_group),$ord='',$limit = 999999,$change_order_by_col="id")!=false) {
                        $nubenqs = count($enqs->filter_index(array('user_group'=>$user_group),$ord='',$limit = 999999,$change_order_by_col="id")); ?>
                        <?php $i=0; $page = 1; while($i < $nubenqs){ ?>
                            <a class="<?php if(isset($_GET['startfrom_numrows'])){ echo($_GET['startfrom_numrows']==$i.',5')?"active":""; } ?>" href="/<?php echo home; ?>/admin/all-users/?startfrom_numrows=<?php echo $i; ?>,5"><?php echo $page; ?></a>
                        <?php  $i+=5; $page++; } ?>
                    <?php  }
                    ?>
                
                    </div>
            </div>
           
        <div class="col-md-12">
            
            <table class="table-sm table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                   
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>City</th>
                   
                    <th>User Group</th>
                    <th>Status</th>
                    <th>Reg Date</th>
                    <th>Action</th>
                    
                </thead>
                <tbody>
                <!-- Modal image zoom -->
                <div class="modal fade" id="zoom-profile-image" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <img id="trainee-big-img" style="height: 100%; width: 100%; object-fit: contain;" alt="">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal image zoom end -->
            <?php 
            
            $limit = 5;
            $usrObj = new Model('pk_user');
            if (isset($_GET['startfrom_numrows'])) {
                $limit = $_GET['startfrom_numrows'];
               } 
            $users = $usrObj->filter_index(array('user_group'=>$user_group),$ord='DESC',$limit,"id");

            if (isset($_GET['user_serch_keywords'])) {
                $search_keys = sanitize_remove_tags($_GET['user_serch_keywords']);
                $srcharr['id'] =   $search_keys;
                $srcharr['username'] =   $search_keys;
                $srcharr['name'] =   $search_keys;
                $srcharr['email'] =   $search_keys;
                $srcharr['created_at'] =   $search_keys;
                $users = $usrObj->search($srcharr, $ord='DESC',$limit =10,$change_order_by_col="id",array('user_group'=>'salesman'));
            } 
            
            // $db = new Dbobjects();
            //     $db->tableName = "pk_user";
                // $contacts = $db->all($ord = "DESC",$limit = 500);
                if ($users==false) {
                    $users = array();
                }
                foreach ($users as $pk => $pv) { 
                    
                        // $prod = get_item_by_id($pv['item_id']);
                    ?>
                <form action="" method="post">
                <tr>
                    
                    <td><a class="text-deco-none" href="/<?php echo home; ?>/admin/edit-account/?edit_user_id=<?php echo $pv['id']; ?>"><i class="fas fa-edit"></i></a> <?php echo $pv['id']; ?></td> 
                    <input type="hidden" value="<?php echo $pv['name']; ?>" name="fullname">
            
                    <td><?php echo $pv['name']; ?></td> 
                    
               
                    <td><?php echo $pv['username']; ?></td> 
                    <td><?php echo $pv['email']; ?></td> 
                    <input style="max-width: 100px;" type="hidden" value="<?php echo $pv['info']; ?>" name="info">
               
               
                    <td><?php echo $pv['mobile']; ?></td> 
                    <td><?php echo $pv['city']; ?></td> 
                    
                    <td><?php echo $pv['user_group']; ?></td> 
                    
                    <td>
                        <select name="status" class="form-control">
                            <option <?php matchData($pv['status'],'verified', 'selected'); ?> value="verified">Verified</option>
                            <option <?php matchData($pv['status'],'unverified', 'selected'); ?> value="unverified">Unverified</option>
                            
                        </select>
                        
                    </td>
                    <td><?php echo date('Y-m-d',strtotime($pv['created_at'])); ?></td> 
                    <td>
                    <div class="d-grid">
                    <input type="hidden" name="update_user_id" value="<?php echo $pv['id']; ?>">
                        <button class="btn btn-sm btn-primary my-2" type="submit">Update</button>
                        </div>
                </td> 
                </tr>
                </form>
            <?php } 
                ?>
                </tbody>
            </table>
                <a class="hide btn btn-success mt-2" href="/<?php echo home; ?>/admin/generate-csv/?report_obj=users">Generate Report</a>
        </div>
    </div>
                <!-- Main Area Ends -->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>