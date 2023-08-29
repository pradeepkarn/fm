<?php
$v = API_V;
$cat_img_dir = "/media/images/pages/";
$req = json_decode(file_get_contents('php://input'));
if (!isset($req->search)) {
    $data['msg'] = "Please provide search keywords";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$search = $req->search;
$db = new Model('content');
$search_arr['title'] = $search;
$listings = $db->search(assoc_arr: $search_arr, whr_arr: ['content_group' => 'listing_category']);
if ($listings == false) {
    $data['msg'] = "No Category found";
    $data['data'] = null;
    echo json_encode($data);
    die();
} else {
    foreach ($listings as $key => $uv) {
        $cat_data[] = array(
            'id' => $uv['id'],
            'title' => $uv['title'],
            'content' => $uv['content'],
            'slug' => $uv['slug'],
            'image' => $cat_img_dir . $uv['banner']
        );
    }
    $data['msg'] = "success";
    $data['data'] = $cat_data;
    echo json_encode($data);
    return;
}
