<?php $screen = "admin-home"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <?php import("apps/view/inc/header.php"); ?>
    </head>

  <body>
    <div class="container-scroller">
     
      <!-- partial:partials/_sidebar.html -->
      <?php import("apps/view/inc/admin-sidebar.php"); ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <div id="settings-trigger"><i class="mdi mdi-settings"></i></div>
        <?php import("apps/view/inc/theme-settings.php"); ?>
        <!-- partial -->
        <?php import("apps/view/inc/nav.php"); ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper pb-0">
            <?php import("apps/view/components/$screen/just-below-nav.php"); ?>
            <!-- first row starts here -->
            <?php import("apps/view/components/$screen/hiring.php"); ?>
            <!-- chart row starts here -->
            <?php import("apps/view/components/$screen/payroll.php"); ?>
            <!-- image card row starts here -->
            <?php import("apps/view/components/$screen/timing-details.php"); ?>
            <!-- table row starts here -->
            <?php import("apps/view/components/$screen/interviews.php"); ?>
            <!-- doughnut chart row starts -->
            <?php import("apps/view/components/$screen/employee-by-dept.php"); ?>
            <!-- last row starts here -->
            <?php import("apps/view/components/$screen/attendance-logs.php"); ?>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php import("apps/view/inc/footer-credit.php"); ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php import("apps/view/inc/footer.php"); ?>
  </body>
</html>