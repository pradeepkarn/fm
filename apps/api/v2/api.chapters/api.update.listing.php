<?php
    if(isset($_POST['user_id']) && isset($_POST['login_token']) && isset($_POST['listing_id'])){
    if (filter_input(INPUT_POST, "listing_id", FILTER_VALIDATE_INT)) {
        $user_id = sanitize_remove_tags($_POST['user_id']);
        $login_token = sanitize_remove_tags($_POST['login_token']);
       $user = new Model('pk_user');
       $userarr['id'] = $user_id;
       $userarr['app_login_token'] = $login_token;
       if($user->exists($userarr)==false){
                $data['msg'] = "Please login first";
                $data['data'] = null;
                echo json_encode($data);
                return;
       }
        $id = $_POST['listing_id'];
        $contentid = $_POST['listing_id'];
        $db = new Model('content');
        $arr['id'] = $id;
        $arr['content_group'] = "product";
        $arr['created_by'] = sanitize_remove_tags($_POST['user_id']);
        $product = $db->filter_index($arr);
        if ($product==false) {
            $data['msg'] = "No Product Found";
            $data['data'] = null;
            echo json_encode($data);
            return;
        }
        else {
            if (isset($_POST['title'])) {
                $arr['title'] = sanitize_remove_tags($_POST['title']);
            }
            // if (isset($_POST['image'])) {
            //     $arr['banner'] = sanitize_remove_tags($_POST['image']);
            // }
            if (isset($_POST['cat_id'])) {
                $arr['parent_id'] = $_POST['cat_id'];
            }
            if (isset($_POST['currency'])) {
                $arr['currency'] = $_POST['currency'];
            }
            if (isset($_POST['content'])) {
                $arr['content'] = $_POST['content'];
            }
            if (isset($_POST['price'])) {
                $arr['price'] = $_POST['price'];
            }

            if (isset($_FILES['product_img'])) {
                if($_FILES['product_img']['name'][0]==""){
                  $data['msg'] = "Please upload at least 1 image";
                  $data['data'] = null;
                  echo json_encode($data);
                  return;
                }
              }
              if ($arr['title']=="") {
                $data['msg'] = "Product name is empty";
                  $data['data'] = null;
                  echo json_encode($data);
                return;
              }


// images
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
// images


            $db->update($id,$arr);
            $data['msg'] = "success";
            $data['data'] = null;
            echo json_encode($data);
            return;
        }
    }
    else{
        $data['msg'] = "Invalid Product ID";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    return;
}