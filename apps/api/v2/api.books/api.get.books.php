<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
import("apps/api/$v/api.books/fn.relprods.php");
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
    if (isset($req->book_id)) {
        if (filter_var($req->book_id, FILTER_VALIDATE_INT)) {
            $id = $req->book_id;
            $db = new Model('content');
            $arr['id'] = $id;
            $arr['content_group'] = "book";
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
            $listing_data['title_en'] = $listings[0]['title'];
            $listing_data['content_en'] = $listings[0]['content'];
            $listing_data['title_ar'] = $listings[0]['content_info'];
            $listing_data['content_ar'] = $listings[0]['other_content'];
            $listing_data['image'] = "/media/images/pages/" . $listings[0]['banner'];
            $listing_data['category_id']  = $listings[0]['parent_id'];
            $listing_data['category_en']  = ($listings[0]['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $listings[0]['parent_id'])['title'];
            $listing_data['category_ar']  = ($listings[0]['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $listings[0]['parent_id'])['content_info'];
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
            $listing_data['view'] = view_count($book_id = $listings[0]['id']);
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
    $db = new Model('content');
    $listings = $db->filter_index(array('content_group' => 'book'), $ord = "DESC", $limit = "1000", $change_order_by_col = "id");
    if ($listings == false) {
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        foreach ($listings as $key => $uv) {
            $rel_prods = array();

            // $rel_prods = array();
            $user = getData('pk_user', $uv['created_by']);
            $moreobj = new Model('content_details');
            $moreimg = $moreobj->filter_index(array('content_id' => $uv['id'], 'content_group' => 'product_more_img'));
            $moreimg = $moreimg == false ? array() : $moreimg;
            $moredetail = $moreobj->filter_index(array('content_id' => $uv['id'], 'content_group' => 'product_more_detail'));
            $moredetail = $moredetail == false ? array() : $moredetail;

            if (count($moreimg) == 0) {
                $mor_imgs = array();
                $mor_imgs[] = "/media/images/pages/{$uv['banner']}";
            } else {
                foreach ($moreimg as $key => $fvl) :
                    $mor_imgs[] = "/media/images/pages/{$fvl['content']}";
                endforeach;
            }
            if ($uv['json_obj'] != null) {
                $jsn = json_decode($uv['json_obj']);
                if (isset($jsn->related_products)) {
                    $rel_prods = rel_prods($jsn->related_products);
                }
            }
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
                'status' => $uv['status'],
                'more_img' => $mor_imgs,
                'more_detail' => $moredetail,
                'view' => view_count($book_id = $uv['id']),
                'author' => $uv['author']
            );
            $mor_imgs = null;
        }
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
}
