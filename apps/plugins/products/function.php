<?php

function upload_base64($base64string = '', $uploadpath = RPATH . '/media/images/pages/', $name = "bnr")
{
    $uploadpath   = $uploadpath;
    $parts        = explode(";base64,", $base64string);
    $imageparts   = explode("image/", @$parts[0]);
    $imagetype    = $imageparts[1];
    $imagebase64  = base64_decode($parts[1]);
    $file         = $uploadpath . $name . '.png';
    file_put_contents($file, $imagebase64);
    return $name . ".png";
}
function uploadBanner($banner_name)
{
    if (isset($_FILES['banner']) && isset($_POST['update_banner'])) {
        $file = $_FILES['banner'];
        $media_folder = "images/pages";
        $imgname = $banner_name;
        $media = new Media();
        $page = new Dbobjects();
        $page->tableName = 'content';
        $page->pk($_POST['update_banner_page_id']);
        $file_ext = explode(".", $file["name"]);
        $ext = end($file_ext);
        $page->insertData['banner'] = $imgname . "." . $ext;
        $page->update();
        $media->upload_media($file, $media_folder, $imgname, $file['type']);
    }
}

function updatePage()
{
    if (isset($_POST['page_id']) && isset($_POST['update_page'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $cat = $db->pk($_POST['page_id']);
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = $_POST['page_content'];
        if (isset($_POST['parent_id'])) {
            $db->insertData['parent_id'] = $_POST['parent_id'];
        }
        if (isset($_POST['page_content_category'])) {
            $db->insertData['category'] = sanitize_remove_tags($_POST['page_content_category']);
        }
        $db->insertData['status'] = $_POST['page_status'];
        $db->insertData['content_type'] = $_POST['page_content_type'];

        $db->insertData['banner'] = $_POST['page_banner'];
        $db->insertData['post_category'] = isset($_POST['post_category']) ? $_POST['post_category'] : null;

        if (isset($_POST['address'])) {
            $db->insertData['address'] = $_POST['address'];
        }
        if (isset($_POST['price'])) {
            $db->insertData['price'] = floatval($_POST['price']);
        }
        if (isset($_POST['tax'])) {
            $db->insertData['tax'] = floatval($_POST['tax']);
        }
        // if (isset($_POST['related_product_id'])) {
        //     $db->insertData['json_obj'] = json_encode(array('related_products' => $_POST['related_product_id']));
        // } else {
        //     $db->insertData['json_obj'] = json_encode(array('related_products' => array()));
        // }
        // $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $arrDays = [];
        // foreach ($days as $key => $day) {
        //     if(isset($_POST[$day."_open"]) && isset($_POST[$day."_close"])){
        //         if ($_POST[$day."_close"]=="" || $_POST[$day."_close"]=="") {
        //             $_SESSION['msg'][] = "Empty time is allowed";
        //             echo js_alert(msg_ssn(return: true));
        //             return;
        //         }
        //         $arrDays['openings'][] = array(
        //             "day_key"=> ($key+1),
        //             "day"=> $day,
        //             "open"=> $_POST[$day."_open"],
        //             "close"=> $_POST[$day."_close"]
        //         );
        //     }
        // }
        
        $db->insertData['jsn'] = json_encode($arrDays);
        // $db->insertData['content_info'] = $_POST['page_content_info'];
        $db->insertData['update_date'] = date("Y-m-d h:i:sa", time());
        $author = new Mydb('pk_user');
        // $auth_user = $author->pkData($_SESSION['user_id'])['id'];
        // $db->insertData['created_by'] = $auth_user;
        if (isset($_POST['page_author'])) {
            $db->insertData['author'] = $_POST['page_author'];
        }
        if (isset($_POST['page_show_title']) && $_POST['page_show_title'] === "on") {
            $db->insertData['show_title'] = 1;
        } else {
            $db->insertData['show_title'] = 0;
        }
        if (check_slug_globally($_POST['slug']) == 0) {
            $db->insertData['slug'] = $_POST['slug'];
        }
        if (isset($_POST['banner_base64']) && $_POST['banner_base64'] != "") {
            $name = uniqid('banner_') . time();
            $imgname = upload_base64($_POST['banner_base64'], RPATH . '/media/images/pages/', $name);
            $oldpath = RPATH . '/media/images/pages/' . $cat['banner'];
            if ($cat['banner'] != "" && file_exists($oldpath)) {
                unlink($oldpath);
            }
            $db->insertData['banner'] = $imgname;
        }
        return $db->updateTransaction();
    }
}
function addContent($type = "product")
{
    if (isset($_POST['add_new_content'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = 'Write your content here';
        if (isset($_POST['parent_id'])) {
            $db->insertData['parent_id'] = $_POST['parent_id'];
        }
        if (isset($_POST['status'])) {
            $db->insertData['status'] = $_POST['status'];
        } else {
            $db->insertData['status'] = 'draft';
        }
        if (isset($_POST['address'])) {
            $db->insertData['address'] = $_POST['address'];
        }
        if (isset($_POST['price'])) {
            $db->insertData['price'] = floatval($_POST['price']);
        }
        if (isset($_POST['tax'])) {
            $db->insertData['tax'] = floatval($_POST['tax']);
        }
        if (isset($_POST['related_product_id'])) {
            $db->insertData['json_obj'] = json_encode(array('related_products' => $_POST['related_product_id']));
        } else {
            $db->insertData['json_obj'] = json_encode(array('related_products' => array()));
        }

        // $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        // $arrDays = [];
        // foreach ($days as $key => $day) {
        //     if(isset($_POST[$day."_open"]) && isset($_POST[$day."_close"])){
        //         if ($_POST[$day."_close"]=="" || $_POST[$day."_close"]=="") {
        //             $_SESSION['msg'][] = "Empty time is allowed";
        //             echo js_alert(msg_ssn(return: true));
        //             return;
        //         }
        //         $arrDays['openings'][] = array(
        //             "day_key"=> ($key+1),
        //             "day"=> $day,
        //             "open"=> $_POST[$day."_open"],
        //             "close"=> $_POST[$day."_close"]
        //         );
        //     }
        // }
        
        // $db->insertData['jsn'] = json_encode($arrDays);
        $db->insertData['slug'] = $_POST['slug'];
        $db->insertData['content_group'] = $type;
        $db->insertData['content_type'] = "product";
        $db->insertData['created_by'] = USER['id'];
        // if (isset($_POST['vendor_id'])) {
        //     $vndr = getData('pk_user', $_POST['vendor_id']);
        //     if ($vndr) {
        //         if ($vndr['user_group'] == 'vendor' || $vndr['user_group'] == 'admin') {

        //             if ((new Model('content'))->exists(['content_group' => 'salon', 'created_by' => $_POST['vendor_id']])) {
        //                 $salondata = (new Model('content'))->filter_index(['content_group' => 'salon', 'created_by' => $_POST['vendor_id']]);
        //                 $_SESSION['msg'][] = "This vendor has already registered salon {$salondata[0]['title']}";
        //                 echo js_alert(msg_ssn(return: true));
        //                 return;
        //             }
        //             $db->insertData['created_by'] = $_POST['vendor_id'];
        //         } else {
        //             echo "This user is not vendor or admin";
        //             $_SESSION['msg'][] = "Please select vender";
        //             echo js_alert(msg_ssn(return: true));
        //             return;
        //         }
        //     } else {
        //         echo "Invalid vendor";
        //         $_SESSION['msg'][] = "Please select vender";
        //         echo js_alert(msg_ssn(return: true));
        //         return;
        //     }
        // } else {
        //     echo "Please select vender";
        //     $_SESSION['msg'][] = "Please select vender";
        //     echo js_alert(msg_ssn(return: true));
        //     return;
        // }

        $slug = generate_slug($_POST['slug']);
        if (check_slug_globally($slug) == 0) {
            $db->insertData['slug'] = $slug;
            return $db->create();
        } else {
            $_SESSION['msg'][] = "Please change slug";
            return false;
        }
    }
}
function delContent($id = null)
{
    if ($id > 0) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $qry['id'] = $id;
        // $qry['status'] = 'trash';
        if (count($db->filter($qry)) > 0) {
            $db->pk($id);
            return $db->delete();
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getCat($id = null)
{
    if ($id != null) {
        $db = new Dbobjects();
        $db->tableName = "categories";
        $qry['id'] = $id;
        if (count($db->filter($qry)) > 0) {
            return $db->pk($id)['name'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function updateColorList($id, $color = 'mixed')
{
    $content = getData('content', $id);
    $color_list = json_decode($content['color_list'], true);
    if (in_array($color, $color_list) == false) {
        $color_list[] = $color;
    }
    $color_list_jsn = json_encode($color_list);
    try {
        (new Model('content'))->update($id, array('color_list' => $color_list_jsn));
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}
function removeColorList($id, $color)
{
    $content = getData('content', $id);
    $color_list = json_decode($content['color_list']);

    if (in_array($color, $color_list) == true) {
        try {
            $del_i =  array_search($color, $color_list);
            array_splice($color_list, $del_i, 1);
            $color_list_jsn = json_encode($color_list);
            (new Model('content'))->update($id, array('color_list' => $color_list_jsn));
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    } else {
        return false;
    }
}

// updateColorList($id=323,$color="blue");
// removeColorList($id=323,$color="blue");