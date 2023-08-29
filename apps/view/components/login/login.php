<section style="min-height: 100vh;">
<div class="row">
<div class="col-md-6 grid-margin stretch-card mx-auto">
    <div class="card" style="margin-top:200px;">
        <div class="card-body">
        <h4 style="font-size: 30px;" class="card-title text-center">Login</h4>
        <?php msg_ssn(); ?>
        <!-- <p class="card-description">Basic form layout</p> -->
        <form action="/<?php echo HOME ?>/login" method="post"  class="php-email-form">
          
            <div class="form-group mt-3">
                <input type="text" class="form-control" name="email" id="email" placeholder="username" required>
              </div>
              <div class="form-group mt-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required>
              </div>
         
            <div class="form-check form-check-flat form-check-primary">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input"> Remember me <i class="input-helper"></i></label>
            </div>
            <button type="submit" class="btn btn-primary me-2"> Submit </button>
            <button class="btn btn-light">Cancel</button>
            <input type="hidden" name="login_my_account" value="true">
        </form>
        </div>
    </div>
    </div>
</div>
</section>
