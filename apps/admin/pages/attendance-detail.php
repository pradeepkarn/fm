<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "All Users"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<?php 
    if (isset($_GET['user_id']) && isset($_GET['from_date']) && isset($_GET['to_date'])) {
        $userid = $_GET['user_id'];
        $from = $_GET['from_date'];
        $to = $_GET['to_date'];
        $dddd = new Dbobjects;
        $sql = "select * from attendance JOIN pk_user ON attendance.user_id=pk_user.id where (attendance.user_id = $userid) AND (attendance.signin_on BETWEEN '$from' AND '$to');";
        $data = $dddd->show($sql);
        // echo $sql;
        // echo "<pre>";
        // print_r($data);
    }else{
        echo js("location.href=/".home."/admin/attendance");
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
                
          
        <div class="col-md-12">
            
        <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Marked at</th>
                            <th>Late by</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $atk => $atv) : 
                                $office_time = strtotime("10:00:00");
                                $office_end_time = strtotime("18:00:00");
                                $workHr = $office_end_time-$office_time;
                                $marked_time = strtotime($atv['signin_time']);
                                $lateby = $marked_time - $office_time;
                                $latebyMinutes = round(($marked_time - $office_time)/60,2);
                                if ($lateby<0) {
                                    $lateby = 0;
                                  }
                                  else{
                                    $lateby = round(($lateby/$workHr)*100);
                                  }
                                ?>
                          <tr>
                            <td>
                              <?php echo $atv['signin_on']; ?>
                            </td>
                            <td><?php echo $atv['signin_time']; ?></td>
                            <td>
                                <?php echo $latebyMinutes; ?> Minute  (<?php echo round(($latebyMinutes/60),2); ?> Hour)
                              <div class="progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $lateby; ?>%;" aria-valuenow="<?php echo $lateby; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                            </td>
                            
                          </tr>
                          <?php endforeach ; ?>
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