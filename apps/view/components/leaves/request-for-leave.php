<?php
    $leaveObj = new LeaveCtrl;
?>
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h4 style="font-size: 30px;" class="card-title text-center">Employee <span class="p-2 bg-warning"><?php echo strtoupper($_GET['leave_group']); ?></span> Request Form</h4>
        <!-- <p class="card-description">Basic form layout</p> -->
       
        <form id="leav-form" method="post" >
            <h3 class="me-5">Date: <?php echo date('d-m-Y'); ?>, Time: <?php echo date('h:i:s A'); ?></h3>
            <?php
                $leaveObj = new LeaveCtrl;
                $marked = false;
            ?>
            <div class="row">
              <div class="col-md">
                <div class="form-floating py-3">
                  <label for="">From Date</label>
                  <input type="date" class="form-control" name="from_date">
                </div>
              </div>
              <div class="col-md">
                <div class="form-floating py-3">
                  <label for="">Start Time</label>
                  <input type="time" class="form-control" name="start_time" value="10:00:00">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md">
                <div class="form-floating py-3">
                  <label for="">To Date</label>
                  <input type="date" class="form-control" name="to_date">
                </div>
              </div>
              <div class="col-md">
                <div class="form-floating py-3">
                  <label for="">End Time</label>
                  <input type="time" class="form-control" name="end_time" value="18:00:00">
                </div>
              </div>
            </div>
            <button id="reqLeaveBtn" type="submit" class="btn btn-primary me-2"> Apply for  <?php echo strtoupper($_GET['leave_group']); ?> </button>
            <div id="res"></div>
           <input type="hidden" name="leave_group" value="<?php echo $_GET['leave_group']; ?>">
        </form>
        <?php 
            $marked===true?'':pkAjax('#reqLeaveBtn','/request-for-leave-ajax','#leav-form','#res'); 
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
                            <th style="font-weight:bold;">From Date</th>
                            <th>Start Time</th>
                            <th style="font-weight:bold;">To Date</th>
                            <th>End Time</th>
                            <th>Leave Type</th>
                            <th>Status</th>
                            <th>Approval</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaveObj->get_my_leaves_log() as $lk => $lv) : ?>
                          <tr>
                            <td>
                              <?php echo $lv['from_date']; ?>
                            </td>
                            <td><?php echo $lv['start_time']; ?></td>
                            <td><?php echo $lv['to_date']; ?></td>
                            <td><?php echo $lv['end_time']; ?></td>
                            <td><?php echo strtoupper($lv['leave_group']); ?></td>
                            <td><?php echo $lv['status']; ?></td>
                            <td><?php echo $lv['approved']?'Accepted':'Not accepted'; ?></td>
                          </tr>
                          <?php endforeach ; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
    </div>
</div>