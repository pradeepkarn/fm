<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
// $plugin_dir = (explode("\\",__DIR__)); 
// $plugin = end($plugin_dir);
$plugin_dir = "gallery";
import("apps/plugins/{$plugin_dir}/function.php");

if ($url[0] == "{$plugin_dir}") {
switch ($path) {
    case "{$plugin_dir}":
        $GLOBALS['gal_media'] = gal_media();
        import("apps/plugins/{$plugin_dir}/show_gallery.php");
        break;
    case "{$plugin_dir}/upload":
        if (isset($_FILES['media_file']) && isset($_POST['csrf_token'])) {
            $str = removeSpace($_POST['media_title']);
            $banner_name = "{$str}_img_".rand(0,999999)."_".time()."_".$_SESSION['user_id'];
            // echo js_alert($banner_name);
            gal_upload_media($banner_name);
        }
        import("apps/plugins/{$plugin_dir}/upload_file.php");
        break;
    case "{$plugin_dir}/updateimage":
        if (isset($_POST['img_name'])) {
            $db = new Mydb('pk_media');
            $db->getData(['media_file'=>$_POST['img_name']]);
            $arr = null;
            $arr['media_title'] = $_POST['img_new_name'];
            $db->updateData($arr);
            $arr = null;
            echo js_alert("Updated");
        }
        break;
    case "{$plugin_dir}/delete":
        if (isset($_POST['csrf_token'])) {
            //print_r($_POST);
            if(del_media($_POST['imgsrc']) == true){
                echo js("alert('Deleted'); location.reload();");
            };
            return;
        }
        break;
  default:
          import("apps/view/404.php");
          break;
    }
}
