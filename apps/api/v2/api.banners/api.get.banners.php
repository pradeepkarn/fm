<?php
$v = API_V;
$db = new Model('content');
$transportations = $db->filter_index(array('content_group' => 'slider'), $ord = "DESC", $limit = "100", $change_order_by_col = "id");
$listings = array_merge($transportations);
if ($listings == false) {
    $data['msg'] = "No banners";
    $data['data'] = null;
    echo json_encode($data);
    die();
} else {
    $listing_data = array();
    foreach ($listings as $key => $uv) {
        $banner = null;
        if (file_exists(MEDIA_ROOT . "images/pages/" . $uv['banner'])) {
            $banner = "/media/images/pages/" . $uv['banner'];
            $listing_data[] = array(
                'id' => $uv['id'],
                'title' => $uv['title'],
                'image' => $banner
            );
        }
    }
    if (count($listing_data) == 0) {
        $data['msg'] = "No banner found, please upload banners from backend";
        $data['data'] = null;
        echo json_encode($data);
        return;
    }
    $data['msg'] = "success";
    $data['data'] = $listing_data;
    echo json_encode($data);
    return;
}
