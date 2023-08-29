<?php
$v = API_V;
import("apps/api/$v/api.users/fn.users.php");

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    // $req = json_decode(file_get_contents('php://input'));
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
// print_r($req);
// return;
if (isset($req->email) && 
isset($req->password) && 
isset($req->confirm_password) && 
isset($req->first_name) && 
isset($req->last_name) &&
isset($req->comp_name) &&
isset($req->comp_mobile) &&
isset($req->comp_address) &&
isset($req->comp_detail) &&
isset($req->files->comp_logo) &&
isset($req->files->comp_doc)
) {
    $paramObj = new stdClass;
    $paramObj->email = $req->email;
    $paramObj->password = $req->password;
    $paramObj->confirm_password = $req->confirm_password;
    $paramObj->first_name = $req->first_name;
    $paramObj->last_name = $req->last_name;

    $userObj = new Model('pk_user');
    $arr['email'] = $req->email;
    $user_arr = $userObj->filter_index($arr);
    $res_signup = create_my_user_account($paramObj);
    if ($res_signup->success == false) {
        $res['msg'] = $res_signup->msg;
        $res['data'] = null;
        echo json_encode($res);
        die();
    } else {
        $arr = null;
        $arr['title'] = $req->comp_name;
        $arr['slug'] = generate_slug(strtolower(trim($req->comp_name)));
        $arr['status'] = 'listed';
        $arr['content'] = $req->comp_detail;
        $arr['content_group'] = 'company';
        $banner = upload_file($ext_arr = ['jpg', 'png', 'jpeg'], $file = $req->files->comp_logo, $media_dir = "images/pages/", $any_name = 'comp_logo');
        $doc = upload_file($ext_arr = ['jpg', 'png', 'jpeg', 'pdf'], $file = $req->files->comp_doc, $media_dir = "docs/", $any_name = 'comp_doc');
        $arr['banner'] = $banner ? $banner : null;
        $json_obj = array(
            'email' => $req->email,
            'mobile' => $req->comp_mobile,
            'logo' => $banner,
            'doc' => $doc,
            'address' => $req->comp_address,
        );
        $arr['json_obj'] = json_encode($json_obj);
        $arr['created_by'] = $res_signup->res['id'];
        (new Model('content'))->store($arr);
        $res['msg'] = 'success';
        $res['data'] = array('user_id'=>$res_signup->res['id']);
        echo json_encode($res);
        die();
    }
} else {
    $res['msg'] = "All fields are mandatory";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
