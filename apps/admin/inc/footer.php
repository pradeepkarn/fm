



  <script>
 function sideMenuResponsive(x){
      if (x.matches) { // If media query matches
        sideBarMenu.style.display = "none";
      } else {
       sideBarMenu.style.display = "block";
      }
}
var sideBarMenu = document.getElementById('sidebar-col');
var x = window.matchMedia("(max-width: 700px)")
sideMenuResponsive(x) // Call listener function at run time
x.addListener(sideMenuResponsive) // Attach listener function on state changes

</script>

<script>
    function createSlug(getid,setid){
        var str = document.getElementById(getid).value;
        var setslug = document.getElementById(setid);
        setslug.value = str.replace(/\s+/g, '-').replaceAll("/","-").replaceAll("\\","-").toLowerCase();
    }
</script>
<?php
  if (MY_DOMAIN!="localhost") {
    $link = "https://".MY_DOMAIN."/media/images/pages/";
  }
  else{
      $link = "http://localhost/".home."/media/images/pages/";
  }
?>
<script>
    tinymce.init({
      selector: '.tiny_textarea',
      height: "450",
      plugins: 'code advlist autolink lists link image charmap print preview hr anchor pagebreak codesample table',
      toolbar_mode: 'floating',
      toolbar1: 'code | fullscreen preview bold italic underline | fontselect, fontsizeselect  | forecolor backcolor | alignleft alignright | aligncenter alignjustify | indent outdent | bullist numlist table | link image media | codesample |',
      toolbar2: 'visualblocks visualchars | charmap hr pagebreak nonbreaking anchor |  code |',
      relative_urls : false,
      remove_script_host : false,
      document_base_url : '<?php echo $link; ?>',
      extended_valid_elements : 'script[src|async|defer|type|charset]',
      allow_html_in_named_anchor: true,
      image_list: [
    <?php $mddb = new Mydb('pk_media');
          $md = $mddb->allData($ord="ASC",$limit=5000000);
          foreach ($md as $key => $mdvl) : ?>
        {title: '<?php echo $mdvl['media_title']; ?>', value: '<?php echo $mdvl['media_file']; ?>'},
        <?php endforeach; ?>
    
  ],
  allow_script_urls: true,
    });
  </script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="/<?php echo STATIC_URL; ?>/admin/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="/<?php echo STATIC_URL; ?>/admin/js/datatables-simple-demo.js"></script>
 </body>
</html>
