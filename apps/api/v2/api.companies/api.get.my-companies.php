<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
if ($method != "POST") {
    $data['msg'] = "Only post method is allowed";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$req = json_decode(file_get_contents('php://input'));
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
$listings = $db->filter_index(array('created_by' => $user->id,'content_group'=>'company'), $ord = "DESC", $limit = "1000", $change_order_by_col = "id");
if ($listings == false) {
    $data['msg'] = "No Company found";
    $data['data'] = null;
    echo json_encode($data);
    die();
} else {

    foreach ($listings as $key => $uv) {
        $listing_data[] = array(
            'id' => $uv['id'],
            'title' => $uv['title'],
            'image' => img_or_null($img = $uv['banner']),
            'content' => sanitize_remove_tags($uv['content']),
            'status' => $uv['status']
        );
        $mor_imgs = null;
    }
    $data = null;
    $data['msg'] = "success";
    $data['data'] = $listing_data;
    echo json_encode($data);
    return;
}
