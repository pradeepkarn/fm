<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
import("apps/api/$v/api.listings/fn.relprods.php");
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
    if (isset($req->chapter_id)) {
        if (filter_var($req->chapter_id, FILTER_VALIDATE_INT)) {
            $id = $req->chapter_id;
            $db = new Model('content');
            $arr['id'] = $id;
            $arr['content_group'] = "chapter";
            $listings = $db->filter_index($arr);
            if ($listings == false) {
                $data['msg'] = "Not found";
                $data['data'] = null;
                echo json_encode($data);
                die();
            }
            $relt_prods = array();
            if ($listings[0]['json_obj'] != null) {
                $jsnobj = json_decode($listings[0]['json_obj']);
                if (isset($jsnobj->related_products)) {
                    $relt_prods = rel_prods($jsnobj->related_products);
                }
            }

            $listing_data['id'] = $listings[0]['id'];
            $listing_data['title'] = $listings[0]['title'];
            $listing_data['content_en'] = $listings[0]['content'];
            $listing_data['content_ar'] = $listings[0]['other_content'];
            $listing_data['image'] = "/media/images/pages/" . $listings[0]['banner'];
            $listing_data['category_id']  = $listings[0]['parent_id'];
            $listing_data['category']  = ($listings[0]['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $listings[0]['parent_id'])['title'];
            $listing_data['genre'] = json_decode($listings[0]['genre']);
            $moreobj = new Model('content_details');
            $moreimg = $moreobj->filter_index(array('content_id' => $listings[0]['id'], 'content_group' => 'product_more_img'));
            $moreimg = $moreimg == false ? array() : $moreimg;
            if (count($moreimg) == 0) {
                $listing_data['more_img'][] = "/media/images/pages/{$listings[0]['banner']}";
            } else {
                foreach ($moreimg as $key => $fvl) :
                    $listing_data['more_img'][] = "/media/images/pages/{$fvl['content']}";
                endforeach;
            }
            $moredetail = $moreobj->filter_index(array('content_id' => $listings[0]['id'], 'content_group' => 'product_more_detail'));
            $moredetail = $moredetail == false ? array() : $moredetail;
            $listing_data['more_detail'][] = $moredetail;
            $listing_data['author'][] = $listings[0]['author'];
            $data['msg'] = "success";
            $data['data'] = $listing_data;
            echo json_encode($data);
            return;
        } else {
            $data['msg'] = "Invalid Id";
            $data['data'] = null;
            echo json_encode($data);
            die();
        }
    }
} else {

    $data['msg'] = "No chapter found";
    $data['data'] = null;
    echo json_encode($data);
    return;
}
