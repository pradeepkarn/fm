<?php
$v = API_V;
$cat_img_dir = "/media/images/pages/";
if (isset($_GET['cat_id'])) {
    if (filter_input(INPUT_GET, "cat_id", FILTER_VALIDATE_INT)) {
        $id = $_GET['id'];
        $db = new Model('content');
        $uv = $db->show($id);
        if ($uv == false) {
            $data['msg'] = "Not found";
            $data['data'] = null;
            echo json_encode($data);
            die();
        }
        $cat_data[] = array(
            'id' => $uv['id'],
            'title' => $uv['title'],
            'cat_img' => img_or_null($uv['banner']),
            'offers' => list_offers($uv['id'])
        );
        $data['msg'] = "success";
        $data['data'] = $cat_data;
        echo json_encode($data);
        return;
    } else {
        $data['msg'] = "Invalid Id";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
} else {
    $db = new Model('content');
    $listings = $db->filter_index(['content_group' => 'listing_category']);
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
                'cat_img' => img_or_null($uv['banner']),
                'offers' => list_offers($uv['id'])
            );
        }
        $data['msg'] = "success";
        $data['data'] = $cat_data;
        echo json_encode($data);
        return;
    }
}


function list_offers($catid)
{
    $db = new Dbobjects;

    // Fetch offer details along with more images using a single query with JOIN
    $sql = "SELECT id, title, banner, discount_perc, link FROM content where content_group = 'offer' and parent_id = $catid;";

    $offer_list = $db->show($sql);

    // Return the fetched offer details directly
    foreach ($offer_list as $key => $value) {
        $offer_list[$key]['banner'] = img_or_null($value['banner']);
        $sql = "SELECT content FROM content_details WHERE content_details.content_id = {$value['id']} and content_details.content_group = 'product_more_img'";
        $sldrs  = $db->show($sql);
        $offer_list[$key]['sliders'] = array();
        foreach ($sldrs as $k => $sldr) {
            $offer_list[$key]['sliders'][] = img_or_null($sldr['content']);
        }
    }
    return $offer_list;
}
