<nav class="shadow navbar navbar-expand-sm justify-content-start navbar-dark <?php echo navbar_bg; ?> sticky-top">
  <div class="container-fluid">
  <div class="navbar-brand">
        <a class="navbar-brand" href="/<?php echo home; ?>/admin">
        <i class="fa-solid fa-gauge"></i> Dashboard
       </a>
    </div>
    <button  class="navbar-toggler btn bg-secondary btn-sm btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target=".closenav" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <i style="color: white;" class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse justify-content-start closenav" id="navbarmenu">
      <ul class="navbar-nav">
        <li>
          <div class="dropdown hide">
              <a class="nav-link active" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-caret-down"></i> Menu
              </a>
              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton1">
              <?php if(getAccessLevel()<=5): ?>
                <li> <a class="dropdown-item" href="/<?php echo home; ?>/admin/services"> <i class="fa-solid fa-ruler-combined"></i> Services </a></li>
                <li><a class="dropdown-item" href="/<?php echo home; ?>/admin/bookings"> <i class="fa-solid fa-money-bill-transfer"></i> Bookings </a></li>
               <?php endif; ?>
                <li><a class="dropdown-item" href="/<?php echo home; ?>/admin/purchase-orders"> <i class="fa-solid fa-money-bill-transfer"></i> My Purchase Orders </a></li>
              </ul>
          </div>
        </li>
       
        <!-- <li class="nav-item">
          <a class="nav-link active" href="/<?php // echo home; ?>/admin"><i class="fa-solid fa-arrow-rotate-right"></i> Reload</a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link active" href="/<?php // echo home; ?>"><i class="fa-solid fa-globe"></i> Go To Site</a>
        </li> -->
      </ul>
  </div>    
  <div class="collapse navbar-collapse justify-content-end closenav" id="navbarmenu2">
      <ul class="navbar-nav ">
        <li class="nav-item">
        <a class="nav-link active" href="/<?php echo home; ?>/logout"> <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout </a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<style>
  .img-center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
</style>
<div class="modal" data-bs-backdrop="static" id="ajaxLoadModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-body">
        <img id="ajaxlod" class="img-center" style="width:100px;" src="/<?php echo media_root;?>/logo-loading.gif" alt="">
      </div>
    </div>
</div>
<?php // ajaxLoadModal("#ajaxLoadModal"); ?>