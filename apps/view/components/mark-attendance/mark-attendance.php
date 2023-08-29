<?php
    $atndnce = new AttendanceCtrl;
?>
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 style="font-size: 30px;" class="card-title text-center">Employee Attendance</h4>
        <!-- <p class="card-description">Basic form layout</p> -->
       
        <form id="attendance-form"  method="post"  class="php-email-form">
            <h3 class="me-5">Date: <?php echo date('d-m-Y'); ?>, Time: <?php echo date('h:i:s A'); ?></h3>
            <?php
                $atndnce = new AttendanceCtrl;
                $marked = $atndnce->check_today_attendance();
            ?>
            <button <?php echo $marked===true?'disabled':''; ?> id="markatndncebtn" type="submit" class="btn btn-primary me-2"> <?php echo $marked===true?"Already marked for today <span class='mdi mdi-checkbox-marked-outline'></span>":"Present"; ?> </button>
            <div id="res"></div>
        </form>
        <?php 
            $marked===true?'':pkAjax('#markatndncebtn','/mark-attendance-ajax','#attendance-form','#res'); 
        ?>
        </div>
    </div>
    </div>
</div>

<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">
                  <div class="card-body">
                    <h4 class="card-title">My Attendance Log</h4>
                 
                   
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Marked at</th>
                            <th>Late by</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($atndnce->get_my_attendance_log() as $atk => $atv) : 
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
                    </div>
                  </div>
                </div>
    </div>
</div>