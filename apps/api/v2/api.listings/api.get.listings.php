<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
if ($method != "POST") {
    $data['msg'] = "Only post method is allowed";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
// $content_group = "transportation";
$req = json_decode(file_get_contents('php://input'));
if (!isset($req->content_group)) {
    $data['msg'] = "Please provide content group";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$content_group = $req->content_group;
import("apps/api/$v/api.listings/fn.relprods.php");
if (isset($req->id)) {
    if (filter_var($req->id, FILTER_VALIDATE_INT)) {
        $id = $req->id;
        $db = new Model('content');
        $arr['id'] = $id;
        $arr['content_group'] = $content_group;
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
        $listing_data['content'] = $listings[0]['content'];
        // $listing_data['title_ar'] = $listings[0]['content_info'];
        // $listing_data['content_ar'] = $listings[0]['other_content'];
        $listing_data['image'] = "/media/images/pages/" . $listings[0]['banner'];
        $listing_data['category_id']  = $listings[0]['parent_id'];
        $listing_data['category']  = ($listings[0]['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $listings[0]['parent_id'])['title'];
        // $listing_data['category_ar']  = ($listings[0]['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $listings[0]['parent_id'])['content_info'];
        $listing_data['genre'] = json_decode($listings[0]['genre']);
        $moreobj = new Model('content_details');
        $moreimg = $moreobj->filter_index(array('content_id' => $listings[0]['id'], 'content_group' => 'product_more_img'));
        $moreimg = $moreimg == false ? array() : $moreimg;
        if (count($moreimg) == 0) {
            $listing_data['more_img'][] = img_or_null($img = $listings[0]['banner']);
        } else {
            foreach ($moreimg as $key => $fvl) :
                $listing_data['more_img'][] = img_or_null($img = $fvl['content']);
            endforeach;
        }
        $moredetail = $moreobj->filter_index(array('content_id' => $listings[0]['id'], 'content_group' => 'product_more_detail'));
        $moredetail = $moredetail == false ? array() : $moredetail;
        $listing_data['more_detail'][] = $moredetail;
        // $listing_data['view'] = view_count($book_id = $listings[0]['id']);
        // $listing_data['author'][] = $listings[0]['author'];
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
} else {
    $cmp = obj(getData('content', $req->company_id));
    if (isset($cmp->id) && intval($cmp->id)) {
        $compnay_data = array(
            'id' => $cmp->id,
            'title_en' => $cmp->title,
            'content_en' => $cmp->content,
            'title_ar' => $cmp->content_info,
            'content_ar' => $cmp->other_content,
            'image' => img_or_null($img = $cmp->banner),
        );
    } else {
        $data['msg'] = "Invalid company Id";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    $db = new Model('content');
    $listings = $db->filter_index(array('content_group' => $content_group, 'company_id' => $req->company_id), $ord = "DESC", $limit = "1000", $change_order_by_col = "id");
    if ($listings == false) {
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        foreach ($listings as $key => $uv) {
            $rel_prods = array();
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
                'image' => img_or_null($img = $uv['banner']),
                'category_id' => $uv['parent_id'],
                'category_en' => ($uv['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $uv['parent_id'])['title'],
                'category_ar' => ($uv['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $uv['parent_id'])['content_info'],
                'genre' => json_decode($uv['genre']),
                'status' => $uv['status'],
                'more_img' => $mor_imgs,
                'more_detail' => $moredetail,
                'company_id' => $uv['company_id']
                // 'view' => view_count($book_id = $uv['id']),
                // 'author' => $uv['author']
            );
            $mor_imgs = null;
        }
        $data['msg'] = "success";
        $data['data'] = array('company_data' => $compnay_data, 'listing_data' => $listing_data);
        echo json_encode($data);
        return;
    }
}
