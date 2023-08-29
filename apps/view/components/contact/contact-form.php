<?php
$user = USER;
?>

<section style="min-height: 100vh; padding-top:100px;">
  <div class="container">
    <div class="row">
      <div class="col-10 mx-auto grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Contact Us</h4>
            <form class="form-sample" id="update-my-profile-form" method="post" action="/<?php echo home; ?>/send-enquiry-ajax">
             
              <div class="row">
                <div class="col-md-12 my-2">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Company/Shop</label>
                    <div class="col-sm-9">
                      <input type="text" name="company" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-12 my-2">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Full Name</label>
                    <div class="col-sm-9">
                      <input type="text" name="name" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 my-2">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Mobile</label>
                    <div class="col-sm-9">
                      <input type="text" name="mobile" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-12 my-2">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" name="email" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
             
              <div class="row">
                <div class="col-md-12 my-2">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Title</label>
                    <div class="col-sm-9">
                      <input type="text" name="subject" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-12 my-2">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Message</label>
                    <div class="col-sm-9">
                      <textarea name="message" rows="5" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-md-12 text-end">
                  <div id="res"></div>
                  <button id="updateProfileBtn" type="button" class="btn btn-primary btn-lg btn-block">
                    <i class="mdi mdi-email"></i> Send </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php pkAjax_form("#updateProfileBtn", "#update-my-profile-form", "#res") ?>