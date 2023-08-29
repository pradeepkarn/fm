
<style>
.card-registration .select-input.form-control[readonly]:not([disabled]) {
font-size: 1rem;
line-height: 2.15;
padding-left: .75em;
padding-right: .75em;
}
.card-registration .select-arrow {
top: 13px;
}
</style>    
<!DOCTYPE html>    
<html>    
<head>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="/<?php echo STATIC_URL; ?>/admin/css/styles.bs.css" rel="stylesheet" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="/<?php echo STATIC_URL; ?>/admin/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://www.w3schools.com/lib/w3.js"></script>
  <script src="https://cdn.tiny.cloud/1/mhpaanhgacwjd383mnua79qirux2ub6tmmtagle79uomfsgl/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <title><?php if (isset($GLOBALS["title"])) {echo $GLOBALS["title"]; }  ?></title>
    <title> Student Registration Form</title>   
</head>    
<body style="background-color: rgb(32,32,32); color:white;">
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
                
                <button id="signupbtn" type="button" class="btn btn-primary">
                     Register</button>
                <div class="text-white my-3" id="res"></div>
                <div class="d-flex justify-content-end pt-3">
                  <a href="/<?php echo home; ?>/login" class="btn btn-primary">Login</a>
                  
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




</body>    
</html>    
