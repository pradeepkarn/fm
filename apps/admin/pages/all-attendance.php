<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "All Users"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>

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
                <form action="/<?php echo home; ?>/admin/attendance/">
                <div class="d-flex">
                    <input type="search" name="user_serch_keywords" placeholder="Search user by id or username or name or email or registartion date" class="form-control" placeholder="Search user">
                    <input type="submit" value="Search User" class="ms-3 btn btn-dark">
                </div>
                </form>
                </div>
            <div class="col-md-12">
                <div class="pagination">
                <?php 
            
            $dddd = new Dbobjects;
            // $sql = "select attendance.signin_on, attendance.signin_time, attendance.signout_on, pk_user.id, pk_user.first_name from attendance JOIN pk_user ON attendance.user_id=pk_user.id;";
            $sql = "select * from attendance JOIN pk_user ON attendance.user_id=pk_user.id;";
            $data = $dddd->show($sql);
            // echo "<pre>";
            // print_r($data);
         
            ?>
                    <?php $enqs = new Model('pk_user'); 
                    if ($enqs->index($ord='',$limit = 999999,$change_order_by_col="id")!=false) {
                        $nubenqs = count($enqs->index($ord='',$limit = 999999,$change_order_by_col="id")); ?>
                        <?php $i=0; $page = 1; while($i < $nubenqs){ ?>
                            <a class="<?php if(isset($_GET['startfrom_numrows'])){ echo($_GET['startfrom_numrows']==$i.',5')?"active":""; } ?>" href="/<?php echo home; ?>/admin/attendance/?startfrom_numrows=<?php echo $i; ?>,5"><?php echo $page; ?></a>
                        <?php  $i+=5; $page++; } ?>
                    <?php  }
                    ?>
                
                    </div>
            </div>
        <div class="col-md-12">
            
            <table class="table-sm table table-bordered">
                <thead>
                    <th>ID</th>
                    <th>First Name</th>
                   
                    <th>Dept.</th>
                 
              
                    <th>Mobile</th>
                   
                 
                    <th>From</th>
                    <th>To</th>
               
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
            $users = $usrObj->index($ord='DESC',$limit,"id");

            if (isset($_GET['user_serch_keywords'])) {
                $search_keys = sanitize_remove_tags($_GET['user_serch_keywords']);
                $srcharr['id'] =   $search_keys;
                $srcharr['username'] =   $search_keys;
                $srcharr['name'] =   $search_keys;
                $srcharr['email'] =   $search_keys;
                $srcharr['created_at'] =   $search_keys;
                $users = $usrObj->search($srcharr, $ord='DESC',$limit =10,$change_order_by_col="id");
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
                <form action="/<?php echo home; ?>/admin/attendance-detail/" method="get">
                <tr>
                    
                    <td><a class="text-deco-none" href="/<?php echo home; ?>/admin/edit-account/?edit_user_id=<?php echo $pv['id']; ?>"><i class="fas fa-edit"></i></a> <?php echo $pv['id']; ?></td> 
                    <input type="hidden" value="<?php echo $pv['name']; ?>" name="fullname">
                    <td><?php echo $pv['first_name']; ?></td> 
                    
                    
                    <td><?php echo getData('content',$pv['department'])?getData('content',$pv['department'])['title']:null; ?></td> 
                   
               
                    <input style="max-width: 100px;" type="hidden" value="<?php echo $pv['info']; ?>" name="info">
               
               
                    <td><?php echo $pv['mobile']; ?></td> 
                    <td>
                    
                        <input value="2023-01-01" type="date" name="from_date" class="form-control">
                    
                     </td> 
                    <td>
                    
                        <input value="2023-01-31" type="date" name="to_date" class="form-control">
                        
                    </td> 
               
                    <td>
                    
                        <input type="hidden" name="user_id" value="<?php echo $pv['id']; ?>">
                        <div class="d-grid">
                        <button type="submit" class="btn btn-sm btn-primary my-2">View Attendance</button>
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