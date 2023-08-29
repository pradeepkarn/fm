<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $req = new stdClass;
    $req = obj($_POST);
    if (isset($_FILES)) {
        $req->files = obj($_FILES);
    }
    
    // Do something with the data
} elseif ($method === 'GET') {
    $res['msg'] = "Get method is not allowed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}

if (
    isset($req->token) &&
    isset($req->comp_id) &&
    isset($req->comp_name) &&
    isset($req->comp_mobile) &&
    isset($req->comp_address) &&
    isset($req->comp_detail) &&
    isset($req->files->comp_logo) &&
    isset($req->files->comp_doc)
) {
    if (isset($req->token)) {
        $user = get_user_by_token($req->token);
        if (!$user) {
            $data['msg'] = "Invalid token";
            $data['data'] = null;
            echo json_encode($data);
            die();
        }
    } else {
        $data['msg'] = "Please provide login token";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }


    $user = obj($user);

    $listing_data = array();
    $db = new Model('content');
    $listings = $db->filter_index(array('id' => $req->comp_id, 'created_by' => $user->id, 'content_group' => 'company'), $ord = "DESC", $limit = "1", $change_order_by_col = "id");
    if (count($listings) == 0) {
        $data['msg'] = "No Company found";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        $mycomp = obj($listings[0]);
        $php_obj = json_decode($mycomp->json_obj);
        $mydoc = isset($php_obj->doc) ? $php_obj->doc : null;
        $myaddress = isset($php_obj->address) ? $php_obj->address : null;

        $arr = null;
        $arr['title'] = $req->comp_name;
        $arr['slug'] = generate_slug(strtolower(trim($req->comp_name)));
        $arr['status'] = 'listed';
        $arr['content'] = $req->comp_detail;
        $arr['content_group'] = 'company';
        $banner = false;
        $doc = false;
        if (isset($req->files->comp_logo)) {
            $banner = upload_file($ext_arr = ['jpg', 'png', 'jpeg'], $file = $req->files->comp_logo, $media_dir = "images/pages/", $any_name = 'comp_logo');
        }
        if (isset($req->files->comp_doc)) {
            $doc = upload_file($ext_arr = ['jpg', 'png', 'jpeg', 'pdf'], $file = $req->files->comp_doc, $media_dir = "docs/", $any_name = 'comp_doc');
        }

        $arr['banner'] = $banner ? $banner : $mycomp->banner;
        $json_obj = array(
            'email' => isset($req->email)?$req->email:$user->email,
            'mobile' => $req->comp_mobile,
            'logo' => $banner ? $banner : $mycomp->banner,
            'doc' => $doc ? $doc : $mydoc,
            'address' => $req->comp_address ? $req->comp_address : $myaddress,
        );
        $arr['json_obj'] = json_encode($json_obj);
        // $arr['created_by'] = $user->id;
        (new Model('content'))->update($mycomp->id, $arr);
        $uv = getData('content', $mycomp->id);
        $listing_data = array(
            'id' => $uv['id'],
            'title' => $uv['title'],
            'image' => img_or_null($img = $uv['banner']),
            'content' => sanitize_remove_tags($uv['content']),
            'status' => $uv['status']
        );
        $data = null;
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
}
else {
    $res['msg'] = "All fields are mandatory";
    $res['data'] = null;
    echo json_encode($res);
    die();
}