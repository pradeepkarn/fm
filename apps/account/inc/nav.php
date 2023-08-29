<!-- Fixed Navbar -->
<nav class="shadow navbar navbar-expand-sm justify-content-end navbar-dark bg-light fixed-top">
  <div class="container-fluid">
     <a id="top_logo" class="navbar-brand" href="/<?php echo home; ?>">
      <img src="/<?php echo home; ?>/apps/assets/media/logo/logo.png"> 
      <?php //echo SITE_NAME; ?>
      <!-- <span>Invest n Reap</span> -->
    </a>
        <style>
          /* input[type="text"].search-btn-header{
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
                input[type="text"].search-btn-header{
                height: 50px;
                width: 40%;  
            }
            button.search-btn-header{
                height: 50px;
                background-color: red;
            }
            @media only screen and (max-width: 600px) {
                .search-btn-header{
                  display: none;
              }
            } */
              .search-icon{
                    display: none;
              }
            @media only screen and (max-width: 600px) {
                .search-icon-menu{
                  display: none;
              }
              .search-icon{
                  display: block;
              }
            } 
           
        </style>
        <!-- <div class="header-search">
            <input type="text" placeholder="Find free PNG. Ex: 'Santa'"  class="search-btn-header form-control" aria-label="Recipient's username" aria-describedby="button-addon3">
        </div> -->
        <div class="search-icon">
          <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#search-modal">
            <i class="pk-pointer fas fa-search"></i>
          </a>
        </div>
    <button  class="navbar-toggler btn bg-secondary btn-sm btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <i style="color: white;" class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDarkDropdown">
      <ul class="navbar-nav p-1 text-dark">
        <li class="search-icon-menu nav-item dropdown has-megamenu">
          <a class="nav-link active text-dark" data-bs-toggle="modal" data-bs-target="#search-modal" href="/<?php echo home; ?>/"><i class="fas fa-search"></i> Search</a>
        </li>
        <li class="nav-item dropdown has-megamenu">
          <a class="nav-link active text-dark" href="/<?php echo home; ?>/"><i class="fas fa-home"></i> Home </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link active text-dark" href="#" aria-expanded="false">
          <i class="fas fa-images"></i> Categories
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="/<?php echo home; ?>/#">
          <i class="fas fa-envelope"></i>
            Contact Us
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-dark" href="/<?php echo home; ?>/#">
          <i class="fas fa-user"></i>
            Register
          </a>
        </li>
      </ul>
  </div>
  </div>
</nav>

<!-- Modal -->
<div class="modal" id="search-modal" tabindex="-1" aria-labelledby="search-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="search-modalLabel">Search PNG</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <?php csrf_token(); ?>
          <input type="text" name="search_image_keyword" placeholder="Find free PNG. Ex: 'Santa'" class="form-control">
          <div class="d-grid mt-2">
            <button class="btn btn-danger">Search</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>