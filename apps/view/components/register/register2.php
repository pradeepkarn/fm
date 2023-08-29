<section class="h-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class=" my-4">
          <div class="row g-0">
            <div class="col-xl-6 d-none d-xl-block">
              <img src="/<?php echo MEDIA_URL; ?>/register.png"
                alt="Sample photo" class="img-fluid"
                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
            </div>
            <div class="col-xl-6">
              <div class="card-body p-md-5 ">
                <h3 class="mb-5 text-uppercase"> Registration Form</h3>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input name="first_name" type="text" id="form3Example1m" class="signup-data form-control form-control-lg" />
                      <label class="form-label" for="form3Example1m">First name</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div class="form-outline">
                      <input name="last_name" type="text" id="form3Example1n" class="signup-data form-control form-control-lg" />
                      <label class="form-label" for="form3Example1n">Last name</label>
                    </div>
                  </div>
                </div>
                <div class="form-outline mb-4">
                  <input type="email" name="email"  id="form3Example8" class="signup-data form-control form-control-lg" />
                  <label class="form-label" for="form3Example8">Email</label>
                </div>
                <!-- <div class="form-outline mb-4">
                  <input type="text" name="username" id="form3Example8" class="signup-data form-control form-control-lg" />
                  <label class="form-label" for="form3Example8">Username (For auto create leave this field blank) </label>
                </div> -->
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form3Exampledd8" class="signup-data form-control form-control-lg" />
                  <label class="form-label" for="form3Example8">Password</label>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="cnf_password" id="cnfform3Exampledd8" class="signup-data form-control form-control-lg" />
                  <label class="form-label" for="cnfform3Example8">Confirm Password</label>
                </div>
                <!-- <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                  <h6 class="mb-0 me-4">Gender: </h6>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="signup-data form-check-input" type="radio" name="gender" id="femaleGender"
                      value="f" />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="signup-data form-check-input" type="radio" name="gender" id="maleGender"
                      value="m" />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>

               

                </div> -->
               <div class="d-grid">
               <button id="signupbtn" type="button" class="btn btn-primary">
                     Register
                </button>
               </div>
                <div class="my-3" id="res"></div>
                <div class="d-flex justify-content-end pt-3">
                  <a href="/<?php echo home; ?>/login" class="btn btn-light">Back to login</a>
                </div>
               
                <a href="/<?php echo home; ?>" class="text-white">Back to Home</a>
                <?php pkAjax("#signupbtn","/register-ajax-form-data",".signup-data","#res"); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>