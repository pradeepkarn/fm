<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
import("apps/api/$v/api.books/fn.relprods.php");
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
}else{
    $data['msg'] = "Invalid method, only post method is allowed";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
    $keywords = sanitize_remove_tags($req->keywords);
    $db = new Model('content');
    $arr['title'] = $keywords;
    $arr['content_info'] = $keywords;
    $arr['content'] = $keywords;
    $arr['other_content'] = $keywords;
    $listings = $db->search($arr, $ord = "DESC", $limit = "10", $change_order_by_col = "id",array('content_group' => 'book'));
    $arr = null;
    if ($listings == false) {
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        $listing_data = array();
        foreach ($listings as $key => $uv) {
            $moreobj = new Model('content_details');
            $listing_data[] = array(
                'id' => $uv['id'],
                'title_en' => $uv['title'],
                'content_en' => $uv['content'],
                'title_ar' => $uv['content_info'],
                'content_ar' => $uv['other_content'],
                'image' => "/media/images/pages/" . $uv['banner'],
                'category_id' => $uv['parent_id'],
                'category_en' => ($uv['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $uv['parent_id'])['title'],
                'category_ar' => ($uv['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $uv['parent_id'])['content_info'],
                'genre' => json_decode($uv['genre']),
                'status' => $uv['status']
            );
            $mor_imgs = null;
        }
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
