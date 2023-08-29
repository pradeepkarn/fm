<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "404"; ?>
<?php import("apps/view/inc/header.php"); ?>
<style>
    body, html {
  height: 100% !important;
}
</style>
<section id="top_banner" class="parallax" style="background-image: url(/<?php echo home; ?>/apps/assets/media/images/404.png);">
<div id="header_h1" style="height: 100%; background-color: rgba(0,0,0,0.5);">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="position: relative; margin-top: 20%;">
            <div class="row">
                <div class="col-md-12">
                   <div class="card pk-round" style="background-color: rgba(0,0,0,0.3);">
                       <div class="card-body">
                              <h1 class="display-1 text-white text-center">
                               404
                              </h1>
                       </div>
                   </div>
                </div>
                <div class="col-md-12 mt-1">
                <h1 class="text-white text-center pk-pointer">
                        <a href="/<?php echo home; ?>/#contact" class="btn btn-warning pk-round">
                           Are you looking for more?
                        </a>
                    </h1>
                </div>
            </div>
            
            
            </div>
        </div>
    </div>
</div>
</section>

 <?php import("apps/view/inc/footer.php"); ?>