<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link flex-column">
              <div class="nav-profile-image">
                <img src="/<?php echo MEDIA_URL; ?>/img/faces/face1.jpg" alt="profile" />
                <!--change to offline or busy as needed-->
              </div>
              <div class="nav-profile-text d-flex ms-0 mb-3 flex-column">
                <span class="font-weight-semibold mb-1 mt-2 text-center">Antonio Olson</span>
                <span class="text-secondary icon-sm text-center">$3499.00</span>
              </div>
            </a>
          </li>
          <li class="nav-item pt-3">
            <a class="nav-link d-block" href="/<?php echo home; ?>/dashboard">
              <!-- <img class="sidebar-brand-logo" src="/<?php echo MEDIA_URL; ?>/img/logo.svg" alt="" /> -->
              <!-- <img class="sidebar-brand-logomini" src="/<?php echo MEDIA_URL; ?>/img/logo-mini.svg" alt="" /> -->
              <h3>HRMS</h3>
              <div class="small font-weight-light pt-1">HRMS Dashboard</div>
            </a>
            <form class="d-flex align-items-center" action="#">
              <div class="input-group">
                <div class="input-group-prepend">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control border-0" placeholder="Search" />
              </div>
            </form>
          </li>
          <li class="pt-2 pb-1">
            <span class="nav-item-head">Template Pages</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/<?php echo home; ?>/dashboard">
              <i class="mdi mdi-compass-outline menu-icon"></i>
              <span class="menu-title">Home</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/<?php echo home; ?>/profile">
              <i class="mdi mdi-face-profile"></i>
              <span class="menu-title ms-3">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#attendance" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-monitor-dashboard menu-icon"></i>
              <span class="menu-title">Attendance</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="attendance">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Attendance Log</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Attendance Requests</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Timings</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#leave" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-inbox menu-icon"></i>
              <span class="menu-title">Leave</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="leave">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Casual Leave</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Paid Leave</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Sick Leave</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Unpaid Leave</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#organizationId" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-cards-variant menu-icon"></i>
              <span class="menu-title">Organization</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="organizationId">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Employees</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/<?php echo home; ?>">Documents</a>
                </li>
              </ul>
            </div>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="/<?php echo home; ?>/logout">
              <i class="mdi mdi-logout"></i> 
              <span class="menu-title ms-3">Logout</span>
            </a>
          </li>
        </ul>
      </nav>