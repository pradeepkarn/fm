<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php 
    if (isset($_POST['update_user_id'])) {
        $role = 'customer';
        switch ($_POST['access_level']) {
            case '1':
                $role = 'superuser';
                break;
            case '2':
                $role = 'admin';
                break;
            case '5':
                $role = 'staff';
                break;
            case '10':
                $role = 'trainee';
                break;
            default:
                $role = 'subscriber';
                break;
        }
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
            $arr['access_level'] = $_POST['access_level'];
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
            <div id="sidebar-col" class="col-md-2 bg-dark">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <?php endif; ?>
            <!-- Main Area -->
            <div id="content-col" class="col-md-<?php echo (getAccessLevel()<=5)?"10":"12"; ?>">
                <!-- Main Area -->
            <?php import("apps/admin/pages/page-nav.php"); ?>
       
            <div class="row">
                <div class="col-md-12 ms-auto mb-2">
                <form action="/<?php echo home; ?>/admin/course-certificates/">
                <div class="d-flex">
                    <input type="search" name="user_serch_keywords" placeholder="Search user by id or username or name or email or registartion date" class="form-control" placeholder="Search user">
                    <input type="submit" value="Search User" class="ms-3 btn btn-dark">
                </div>
                </form>
                </div>
            <div class="col-md-12">
                <div class="pagination">
                    
                    <?php $enqs = new Model('pk_user'); 
                    $fltrarr['access_level'] = 10;
                    if ($enqs->filter_index($fltrarr,$ord='DESC',$limit = 999999,$change_order_by_col="id")!=false) {
                        $nubenqs = count($enqs->filter_index($fltrarr,$ord='DESC',$limit = 999999,$change_order_by_col="id")); ?>
                        <?php $i=0; $page = 1; while($i < $nubenqs){ ?>
                            <a class="<?php if(isset($_GET['startfrom_numrows'])){ echo($_GET['startfrom_numrows']==$i.',5')?"active":""; } ?>" href="/<?php echo home; ?>/admin/course-certificates/?startfrom_numrows=<?php echo $i; ?>,5"><?php echo $page; ?></a>
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
                    <th class="hide">Short Info</th>
                    <th>Access Level</th>
                    <th>Status</th>
                    <th>Reg Date <br> yyyy-mm-dd</th>
                    <th>Quick Update</th>
                    <th>Certificates</th>
                    
                </thead>
                <tbody>
            <?php 
            
            $limit = 5;
            $usrObj = new Model('pk_user');
            if (isset($_GET['startfrom_numrows'])) {
                $limit = $_GET['startfrom_numrows'];
               } 
            $users = $usrObj->filter_index($fltrarr,$ord='DESC',$limit,"id");

            if (isset($_GET['user_serch_keywords'])) {
                $search_keys = sanitize_remove_tags($_GET['user_serch_keywords']);
                $srcharr['id'] =   $search_keys;
                $srcharr['username'] =   $search_keys;
                $srcharr['name'] =   $search_keys;
                $srcharr['email'] =   $search_keys;
                $srcharr['created_at'] =   $search_keys;
                $users = $usrObj->search($srcharr, $ord='DESC',$limit =10,$change_order_by_col="id",['access_level'=>10]);
            } 
            
            // $db = new Dbobjects();
            //     $db->tableName = "pk_user";
                // $contacts = $db->all($ord = "DESC",$limit = 500);
                if ($users!=false) {
              
                foreach ($users as $pk => $pv) { 
                    
                        // $prod = get_item_by_id($pv['item_id']);
                    ?>
                <form action="" method="post">
                <tr>
                    
                    <td><?php echo $pv['id']; ?></td> 
                    <td> <input type="text" value="<?php echo $pv['name']; ?>" name="fullname"></td> 
                    <td>  <a class="text-deco-none" href="/<?php echo home; ?>/admin/edit-account/?edit_user_id=<?php echo $pv['id']; ?>"><?php echo $pv['username']; ?></a></td> 
                    <td><?php echo $pv['email']; ?></td> 
                    <td class="hide"><input style="max-width: 100px;" type="text" value="<?php echo $pv['info']; ?>" name="info"></td> 
               
                    
                    <td>
                    <select readonly name="access_level" class="form-control">
                            <option class="hide" disbaled <?php matchData($pv['access_level'],'1', 'selected'); ?> value="1">Super Admin</option>
                            <option class="hide" disbaled <?php matchData($pv['access_level'],'5', 'selected'); ?> value="2">Admin</option>
                            <option class="hide" disbaled <?php matchData($pv['access_level'],'9', 'selected'); ?> value="5">Staff</option>
                            <option <?php matchData($pv['access_level'],'10', 'selected'); ?> value="10">Trainee</option>
                        </select>
                    </td> 
                    <td>
             
                        <select name="status" class="form-control">
                            <option <?php matchData($pv['status'],'verified', 'selected'); ?> value="verified">Verified</option>
                            <option <?php matchData($pv['status'],'unverified', 'selected'); ?> value="unverified">Unverified</option>
                            <option <?php matchData($pv['status'],'inactive', 'selected'); ?> value="inactive">inactive</option>
                            
                        </select>
                        
                    </td>
                    <td><?php echo date('Y-m-d',strtotime($pv['created_at'])); ?></td> 
                    <td>
                    <div class="d-grid">
                    <input type="hidden" name="update_user_id" value="<?php echo $pv['id']; ?>">
                        <button class="btn btn-sm btn-primary my-2" type="submit">Update</button>
                        </div>
                </td> 
                <td>
                    <div class="d-grid">
                        <?php 
                        $myapps = new Model('pk_docs');
                        $arr['user_id'] = $pv['id'];
                        $arr['obj_group'] = "course_certificate";
                        $docs = $myapps->filterIndex($arr, $ord='DESC',$limit = 999999,$change_order_by_col="id");
                        $docscount = ($docs!=false)?count($docs):0;
                        ?>
                        <a class="btn btn-sm my-2 <?php echo($docscount==0)?"btn-warning text-dark":"btn-success text-white"; ?>" href="/<?php echo home; ?>/admin/manage-certificates/?user_id=<?php echo $pv['id']; ?>&obj_grp=course_certificate"><?php echo $docscount; ?> Files</a>
                    </div>
                </td>
                </tr>
                </form>
            <?php } }
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