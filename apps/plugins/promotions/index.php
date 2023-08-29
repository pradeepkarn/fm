<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "promotions";
$home = home;
import("apps/plugins/{$plugin_dir}/function.php");

if ("{$url[0]}/{$url[1]}" == "admin/{$plugin_dir}") {
    if (!isset($url[2])) {
        import("apps/plugins/{$plugin_dir}/item-list.php");
        return;
    }
    if (count($url)>=3) {
        if ($url[2]=='get-product-list-ajax') {
            
                $prodObj = new Model('content');
                // $employees = $userObj->index();
                $search_data = sanitize_remove_tags($_POST['search_prod']);
                $arr['id'] = $search_data;
                $arr['title'] = $search_data;
                $arr['content'] = $search_data;
                $obj = $prodObj->search($arr,'DESC',100,'id',array('content_group'=>'product'));
                // $employees = $userObj->filter_index(array('user_group'=>'employee'));
                // print_r($genres);
                if ($obj==false) {
                    $obj = array();
                }
            ?>
              <?php foreach ($obj as $k => $v): ?>
                    <li id="getEmpList<?php echo $v['id']; ?>" class="py-1 pk-pointer">
                        <input onclick="setInSearch(`<?php echo $v['title']; ?>`)"  class="update_page" type="radio" name="content_id" value="<?php echo $v['id']; ?>"> 
                        <?php echo $v['title'] ?? $v['title'] ?? "No Name"; ?> ID: <?php echo $v['id']; ?> 
                    </li>
            <?php endforeach; 
            return;
        }
        if ($url[2]=='add-new-promotion') {
            import("apps/plugins/{$plugin_dir}/promotion-add.php");
            return;
        }
        if ($url[2]=='edit-promotion') {
            import("apps/plugins/{$plugin_dir}/promotion-edit.php");
            return;
        }
        if ($url[2]=='add-new-item') {
            import("apps/plugins/{$plugin_dir}/item-add.php");
            return;
        }
        if ($url[2]=='add-this-product-in-promotions-ajax') {
            if (!isset($_POST['content_id'])) {
                echo js_alert('Please choose a product');
               return;
            }
            $arr['content_id'] = $_POST['content_id'];
            $procat = new Model('promo_category');
            $promo = $procat->show($_POST['promo_cat']);
            $arr['content_group'] = $promo['name'];
            $arr['promo_cat'] = $_POST['promo_cat'];
            if(isset($_FILES['promoimage'])){
                $fl = $_FILES['promoimage'];
                if ($fl['name']=="") {
                    echo js_alert('Please give a promotion image');
                   return;
                }
                if ($fl['error']==0 && $fl['type']=="image/jpeg" || $fl['type']=="image/jpg" || $fl['type']=="image/png") {
                    $imgarr = explode(".",$fl['name']);
                    $img = uniqid('promo_');
                    $imgname = $img.".".end($imgarr);
                    $new_img_link = RPATH . "/media/images/pages/".$imgname;
                    $arr['image'] = $imgname;
                    move_uploaded_file($fl['tmp_name'], $new_img_link);
                }
                
            }
            (new Model('promotions'))->store($arr);
            echo js("location.href='/$home/admin/promotions';");
            return;
        }
        if ($url[2]=='save-new-promotion-ajax') {
           
          
            if(isset($_FILES['promoimage'])){
                $fl = $_FILES['promoimage'];
                if ($fl['error']==0 && $fl['type']=="image/jpeg" || $fl['type']=="image/jpg" || $fl['type']=="image/png") {
                    if (isset($_POST['promo_name']) && $_POST['promo_name']=="") {
                        echo js_alert('Please give a promotion image');
                       return;
                    }
                    $imgarr = explode(".",$fl['name']);
                    $img = uniqid('promo_');
                    $imgname = $img.".".end($imgarr);
                    $new_img_link = RPATH . "/media/images/pages/".$imgname;

                    if (isset($_POST['promo_name']) && $_POST['promo_name']!="") {
                        $pormoObj = new Model('promo_category');
                        $arr['name'] = str_replace(" ","_",trim(strtolower($_POST['promo_name'])));
                        $arr['image'] = $imgname;
                        $id = $pormoObj->store($arr);
                        if ($id>0) {
                            move_uploaded_file($fl['tmp_name'], $new_img_link);
                            echo js("location.href='/$home/admin/promotions';");
                        }
                    }

                }else{
                   
                        echo js_alert('Please upload an image');
                       return;
                    
                }
            }
            
            return;
        }
        if ($url[2]=='update-promotion-ajax') {
           
          
            if(isset($_FILES['promoimage'])){
                $fl = $_FILES['promoimage'];
                if ($fl['error']==0 && $fl['type']=="image/jpeg" || $fl['type']=="image/jpg" || $fl['type']=="image/png") {
                    if (isset($_POST['promo_name']) && $_POST['promo_name']=="") {
                        echo js_alert('Please give a promotion group name');
                       return;
                    }
                    $imgarr = explode(".",$fl['name']);
                    $img = uniqid('promo_');
                    $imgname = $img.".".end($imgarr);
                    $new_img_link = RPATH . "/media/images/pages/".$imgname;

                    if (isset($_POST['promo_name']) && $_POST['promo_name']!="") {
                        $pormoObj = new Model('promo_category');
                        $promobj = $pormoObj->show($_POST['promo_id']);
                        $old_img_link = RPATH . "/media/images/pages/".$promobj['image'];
                        $arr['name'] = str_replace(" ","_",trim(strtolower($_POST['promo_name'])));
                        $arr['image'] = $imgname;
                        $id = $pormoObj->update($_POST['promo_id'],$arr);
                        if ($fl['name']!=null) {
                            try {
                                unlink($old_img_link);
                            } catch (\Throwable $th) {
                                //throw $th;
                            }
                            move_uploaded_file($fl['tmp_name'], $new_img_link);
                            echo js("location.href='/$home/admin/promotions';");
                        }
                    }

                }else{
                        echo js_alert('Please upload an image');
                       return;
                    
                }
            }
            
            return;
        }
        if ($url[2]=='remove-this-product-in-promotions-ajax') {
            $pormoObj = new Model('promotions');
            $promobj = $pormoObj->show($_POST['remove_id']);
            $old_img_link = RPATH . "/media/images/pages/".$promobj['image'];
            if (file_exists($old_img_link) && $promobj['image']!=null) {
                try {
                    unlink($old_img_link);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            (new Model('promotions'))->destroy($_POST['remove_id']);
            echo js("location.href='/$home/admin/promotions';");
            return;
        }
        if ($url[2]=='add-new-item-ajax') {
            if ($_POST['page_title']=="") {
                echo js_alert('Empty name is not allowed');
                return;
            }
            // print_r($_POST);
            $pageid = addContent($type="content");
            
            if (isset($_FILES['banner']) && $_FILES['banner']["error"]==0 && filter_var($pageid,FILTER_VALIDATE_INT)) {
                $contentid = $pageid;
                $banner=$_FILES['banner'];
                $banner_name = time().uniqid("_banner_").USER['id'];
                change_my_banner($contentid=$contentid,$banner=$banner,$banner_name=$banner_name);
            }
            if (filter_var($pageid,FILTER_VALIDATE_INT)) {
                echo js_alert('added');
                $home = home;
                echo js("location.href='/$home/admin/contents';");
            }
            return;
        }
        
    
    }
       
 
}

