<nav class="px-3 navbar navbar-expand-lg bg-body-tertiary fixed-top">
  <div class="container">
    <a class="navbar-brand" href="/<?php echo home; ?>">
      <img style="position: relative; height:60px; " src="/<?php echo MEDIA_URL; ?>/logo/logo.png" alt="logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
        <li class="nav-item px-4">
          <a class="nav-link active text-upper" aria-current="page" href="/<?php echo home; ?>">Home</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link active text-upper" href="/<?php echo home; ?>/about">About</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link active text-upper" href="/<?php echo home; ?>/privacy-policy">Privacy Policy</a>
        </li>
        <li class="nav-item px-4">
          <a class="nav-link active text-upper" href="/<?php echo home; ?>/terms-and-conditions">Terms & Conditions</a>
        </li>

        <li class="nav-item px-4">
          <a class="nav-link active text-upper" href="/<?php echo home; ?>/contact">Contact Us</a>
        </li>
        <li class="nav-item px-4">
          <?php if (authenticate()) : ?>
            <a class="nav-link active text-upper" href="/<?php echo home; ?>/logout">Logout</a>
          <?php else : ?>
            <a class="nav-link active text-upper" href="/<?php echo home; ?>/login">Login</a>
          <?php endif; ?>
        </li>
      </ul>

    </div>
  </div>
</nav>