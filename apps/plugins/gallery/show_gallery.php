<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<style>
.list-none li{
    font-weight: bold;
}
.menu-col{
    min-height: 300px !important;
}
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-col" class="col-md-2 bg-dark">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <!-- Main Area -->
            <div id="content-col" class="col-md-10">
            <?php import("apps/admin/pages/page-nav.php"); ?>
            <style>
    div.search-section{
        /* width: 450px; */
        position: relative;
        top: 20px;
        display: block;
        background-color: white;
        color: black;
        display: flex;
    }
    input[type=text].rename{
        width: 100%;
        border: none;
    }
    input[type=text].rename:focus{
        outline-style: none;
    }
   
	      </style>
            <?php 
            $attached_pic= array();
            $unattached_pic= array();

if (isset($GLOBALS['gal_media'])) {
    $gl = $GLOBALS['gal_media'];
    $db = new Mydb('content');
    $db_md = new Mydb('pk_media');
    for ($i=0; $i < count($gl); $i++) { 
        $pgqry['banner'] = $gl[$i];
        if (count($db->filterData($pgqry)) > 0 ) {
            $attached_pic[] = $db->getData($pgqry)['banner'];
        }
        else if (count($db->filterData($pgqry)) == 0 ) {
            $unattached_pic[] = $gl[$i];
        }
        $mdflqry['media_file'] = $gl[$i];
        if (count($db_md->filterData($mdflqry)) == 0 ) {
            $mdfl = null;
            $mdflqry = null;
            if(($gl[$i]!= ".") && ($gl[$i]!="..")):
            $mdfl['media_file'] = $gl[$i];
            $mdfl['dir_name'] = "/media/images/pages/";
            $db_md->createData($mdfl);
            endif;
            $mdfl = null;
            $mdflqry = null;
        }

    } ?>
            <div class="row">
        <div class="col-md-12">
            <div id="alertResult"></div>
            <h1 class="text-center">Attched images with content</h1>
        </div>
        <?php for($j=0; $j < count($attached_pic); $j++): ?>
        <div class="col-md-2 mb-2">
        <div class="card shadow" style="height: 150px;">
                <img class="pk-pointer glry" data-bs-target="#imgModal" data-bs-toggle="modal" style="height: 120px; object-fit: cover;"  src="/<?php echo media_root; ?>/images/pages/<?php echo $attached_pic[$j]; ?>" alt="">
            </div>
            <a style="position: relative; top: 5px;" download href="/<?php echo media_root; ?>/images/pages/<?php echo $attached_pic[$j]; ?>">Download</a>
            <div class="search-section form-control mb-4">
            <?php $db = new Mydb('pk_media');
                        $media_title = $db->getData(['media_file'=>$attached_pic[$j]])['media_title'];
                ?>
                <input id="imgname_<?php echo $j; ?>"  value="<?php echo $media_title; ?>"  type="text" placeholder="Image Title" class="rename" name="image_name">
                
                <i id="update_img_name<?php echo $j; ?>" class="text-secondary fa-solid fa-floppy-disk py-1 pk-pointer"></i>
              </div>
              <script>
                    $(document).ready(function() {
                        $('#update_img_name<?php echo $j; ?>').click(function(event) {
                            event.preventDefault();
                            $.ajax({
                                url: "/<?php echo home; ?>/gallery/updateimage",
                                method: "post",
                                data: {img_name: "<?php echo $attached_pic[$j]; ?>", img_new_name: $('#imgname_<?php echo $j; ?>').val()},
                                dataType: "html",
                                success: function(resultValue) {
                                    $('#alertResult').html(resultValue)
                                }
                            });
                        });
                    });
              </script>
        </div>
        <?php endfor ?>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">Unattched images with content</h1>
        </div>
        <?php for($k=0; $k < count($unattached_pic); $k++):
        if (($unattached_pic[$k]!= ".") && ($unattached_pic[$k]!="..")): ?>
        <div class="col-md-2 mb-2">
            <div class="card shadow" style="height: 150px;">
                <img class="pk-pointer glry" data-bs-target="#imgModal" data-bs-toggle="modal" style="height: 120px; object-fit: cover;" src="/<?php echo media_root; ?>/images/pages/<?php echo $unattached_pic[$k]; ?>" alt="">
            </div>
            <a style="position: relative; top: 5px;" download href="/<?php echo media_root; ?>/images/pages/<?php echo $unattached_pic[$k]; ?>">Download</a>
            <div class="search-section form-control mb-4">
            <?php $db = new Mydb('pk_media');
                        $media_titles = $db->getData(['media_file'=>$unattached_pic[$k]])['media_title'];
                ?>
                <input id="imgnamedd_<?php echo $k; ?>" value="<?php echo $media_titles; ?>" type="text" placeholder="Image Title" class="rename" name="image_name">
                <i id="un_update_img_name<?php echo $k; ?>" class="text-secondary fa-solid fa-floppy-disk py-1 pk-pointer"></i>
              </div>
              <script>
                    $(document).ready(function() {
                        $('#un_update_img_name<?php echo $k; ?>').click(function(event) {
                            event.preventDefault();
                            $.ajax({
                                url: "/<?php echo home; ?>/gallery/updateimage",
                                method: "post",
                                data: {img_name: "<?php echo $unattached_pic[$k]; ?>", img_new_name: $('#imgnamedd_<?php echo $k; ?>').val()},
                                dataType: "html",
                                success: function(resultValue) {
                                    $('#alertResult').html(resultValue)
                                }
                            });
                        });
                    });
              </script>
        </div>
        <?php endif ?>
        <?php endfor ?>
    </div>
    <?php } ?>

    <br><br>
 <div class="modal fade" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content pk-round">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="result"></div>
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                  <center>
                      Click on image name to copy <i class="fas fa-arrow-down"></i>
                  <h3>
                      <span class="p-2" onclick='document.execCommand("copy");' style='user-select: all;' id="imgSrcText"></span>
                      </h3>
                    <img style="width: 90%;" id="imgshow">
                </center>
                <i id="trashImg" class="fas fa-trash text-danger pk-pointer"></i> 
                  </div>
              </div>
          </div>        
        
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<script>
        var bs_modal_gallary = $('#imgModal');
        var imgSrcText = document.getElementById('imgSrcText');
        let glry = document.getElementsByClassName('glry');
        let imgshow = document.getElementById('imgshow');
        let i;
        function showPic(){
            imgshow.src = this.src;
            const pieces = this.src.split("/");
            const last = pieces[pieces.length - 1];
            imgSrcText.innerHTML = last;
            bs_modal_gallary.modal('show');
        }
        for(i=0; i < glry.length; i++){
        glry[i].addEventListener('click', showPic);
        }

        var trashImg = document.getElementById('trashImg');
        trashImg.addEventListener('click', deletePic);

        //delete pic
            function deletePic() {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "/<?php echo home; ?>/gallery/delete",
                data: {action: "dlt", imgsrc: imgshow.src, csrf_token: "<?php echo $_SESSION['token']; ?>"},
                success: function(resultValue) {
                        bs_modal_gallary.modal('hide');
                        $('#result').html(resultValue)
                      }
                })
            }
           //delete pic end
</script>

            <!-- Main Area ends -->
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>