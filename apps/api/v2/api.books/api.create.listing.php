<?php   
    if(isset($_POST['user_id']) && isset($_POST['login_token']) && isset($_POST['title'])){
    
    $user_id = sanitize_remove_tags($_POST['user_id']);
    $login_token = sanitize_remove_tags($_POST['login_token']);
    
   $user = new Model('pk_user');
   $userarr['id'] = $user_id;
   $userarr['app_login_token'] = $login_token;
   if($user->exists($userarr)==false){
            $data['msg'] = "Please login first";
            $data['data'] = null;
            echo json_encode($data);
            die();
   }
//title and slug
 
        $arr['title'] = sanitize_remove_tags($_POST['title']);
        $slug = sanitize_remove_tags($_POST['title']);
        $slug = str_replace(" ","-",sanitize_remove_tags($slug));
        $slug = str_replace("&","-",sanitize_remove_tags($slug));
        $slug = str_replace("?","-",sanitize_remove_tags($slug));
        $arr['slug'] = generate_slug($slug,$try=500);
        $arr['content_group'] = "product";
        $arr['created_by'] = $user_id;
        $arr['status'] = "draft";
        $arr['banner'] = "product.png";
        if (isset($_POST['cat_id'])) {
            $arr['parent_id'] = $_POST['cat_id'];
        }
        if (isset($_POST['content'])) {
            $arr['content'] = $_POST['content'];
        }
        if (isset($_POST['currency'])) {
            $arr['currency'] = sanitize_remove_tags($_POST['currency']);
        }
        if (isset($_POST['payment_id'])) {
            $arr['payment_id'] = sanitize_remove_tags( $_POST['payment_id']);
        }
        else{
            $data['msg'] = "Payment is required";
            $data['data'] = null;
            echo json_encode($data);
            return;
        }
        if (isset($_POST['ad_type'])) {
            $arr['ad_type'] = sanitize_remove_tags( $_POST['ad_type']);
        }
        else{
            $data['msg'] = "Ad type is required";
            $data['data'] = null;
            echo json_encode($data);
            return;
        }
        if (isset($_POST['price'])) {
            $arr['price'] = $_POST['price'];
        }
        if (isset($_POST['currency'])) {
            $arr['currency'] = $_POST['currency'];
        }
        if (isset($_FILES['product_img'])) {
            if($_FILES['product_img']['name'][0]==""){
              $data['msg'] = "Please upload at least 1 image";
              $data['data'] = null;
              echo json_encode($data);
              return;
            }
          }
// $payments = (new Model('payment'))->filter_index(array('id'=>$_POST['payment_id'],'user_id' => $user_id));
// if ($payments==false) {
//     $data['msg'] = "No payment history";
//     $data['data'] = null;
//     echo json_encode($data);
//     die();
// }
$order = (new Model('my_order'))->filter_index(array('payment_id'=>$_POST['payment_id']));
if ($order==false) {
    $data['msg'] = "No any package associated with this payment";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
else{
    $arr['package_id'] = $order[0]['item_id'];
}
// filter old post using package
$old_post = (new Model('content'))->filter_index(array('package_id' => $arr['package_id'],'ad_type'=> $arr['ad_type'],'payment_id'=>$arr['payment_id']));
if ($old_post==false) {
    $old_post=array();
}
// filter old post using package end
//package
$pkgobj = (new Model('content'))->show($arr['package_id']);
if ($pkgobj ==false){
    $data['msg'] = "You have not any package";
    $data['data'] = null;
    echo json_encode($data);
    return;
}
else{
    $more_dtls = (new Model('content_details'))->filter_index(array('content_id' => $pkgobj['id'] ));
    if ($more_dtls==false) {
        $data['msg'] = "Invalid package contact service provider";
        $data['data'] = null;
        echo json_encode($data);
        return;
    }
    else{
        foreach ($more_dtls as $key => $mdlt) {
            if (($mdlt['heading']=='free_ads') && ($arr['ad_type']=='free')) {
                if ((count($old_post) >= $mdlt['content'])) {
                    $data['msg'] = "Limit exhausted";
                    $data['data'] = null;
                    echo json_encode($data);
                    return;
                }
            }
            elseif (($mdlt['heading']=='premium_ads') && ($arr['ad_type']=='premium')) {
                if ((count($old_post) >= $mdlt['content'])) {
                    $data['msg'] = "Limit exhausted";
                    $data['data'] = null;
                    echo json_encode($data);
                    return;
                }
            }
        }
    }
    
}
//
        //if evrything valid then
        $dbcreate = new Model('content');
        $product_id = $dbcreate->store($arr);
        if ($product_id==false) {
            $data['msg'] = "Product not listed";
            $data['data'] = null;
            echo json_encode($data);
            die();
        }
        if ($product_id==0) {
            $data['msg'] = "Product not listed";
            $data['data'] = null;
            echo json_encode($data);
            die();
        }
// images
$contentid = $product_id;
if (isset($_FILES['product_img'])) {
    $fl = $_FILES['product_img'];
  
  for ($i=0; $i < count($fl['name']); $i++) { 
    $file_type = mime_content_type($fl['tmp_name'][$i]);
    $obj_grp = "product_more_img";
    $obj_id = $contentid;
    $imgsarr['content_id'] = $contentid;
    $imgsarr['content_group'] = "product_more_img";
    $imgsarr['status'] = "published";
    $imgsarr['content'] = $fl['name'][$i];
    $file_with_ext = $fl['name'][$i];
    if (!empty($fl['name'][$i])) {
    $only_file_name = filter_name($file_with_ext);
    $only_file_name =  $only_file_name."_{$obj_id}_{$obj_grp}_".random_int(100000,999999);
     $target_dir = RPATH ."/media/images/pages/";
     $file_ext_arr = explode(".",$file_with_ext);
     $ext = end($file_ext_arr);
     $target_file = $target_dir ."{$only_file_name}.".$ext;
     
     
     if(($file_type=="image/png" || $file_type=="image/jpeg" || $file_type=="image/jpg" || $file_type=="image/JPEG" || $file_type=="image/JPG")){
        if (move_uploaded_file($fl['tmp_name'][$i], $target_file)) {
            $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
            $filename = $only_file_name.".".$ext;
            $imgsarr['content'] = $filename;
            (new Model('content_details'))->store($imgsarr);
            $md = new Model('pk_media');
            $md->store(array('media_file'=>$filename,'dir_name'=>"/media/images/pages/".$filename,'media_title'=>$filename));
            (new Model('content'))->update($contentid,array('banner'=>$filename));
          }
    }
    else{
        $data['msg'] = "$file_with_ext is invalid file";
        $data['data'] = null;
        echo json_encode($data);
        return;
        }
    }
}
}

        $data['msg'] = "success";
        $data['data'] = array('listing_id'=>$product_id);
        echo json_encode($data);
        return;
    }
    else{
        $data['msg'] = "Missing required field";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
