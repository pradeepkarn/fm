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
if (!isset($req->token)) {
    $data['msg'] = "Please provide token";
    $data['data'] = null;
    echo json_encode($data);
    die();
}

$content_group = 'salon';
$token = $req->token;
$user = get_user_by_token($token);
import("apps/api/$v/api.listings/fn.relprods.php");
if ($user) {
    $user = obj($user);
    $ratingobj = new Model('recent_visit');
    $recent_visit = $ratingobj->filter_index(assoc_arr: array('content_group' => 'salon','user_id'=>$user->id),change_order_by_col:'created_at',ord:'desc');
    
    $salons = array();
    foreach ($recent_visit as $fv) {
        $sl = getData('content', $fv['content_id']);
        $ratingobj = new Model('bookmarks');
        $star_rating = $ratingobj->filter_index(array('content_group' => 'star-rating','user_id'=>$user->id));
        $avg_rt_pt = count($star_rating)>0?$star_rating[0]['detail']:0;
        if ($sl) {
            if ($sl['content_group']=='salon') {
                $salons[] = $sl;
            }
        }
    }
    // $db = new Model('content');
    // $listings = $db->filter_index(array('content_group' => $content_group, 'parent_id' => $parent_id), $ord = "DESC", $limit = "1000", $change_order_by_col = "id");
    if (count($salons) == 0) {
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        foreach ($salons as $key => $uv) {
            $rel_prods = array();
            $user = getData('pk_user', $uv['created_by']);
            $moreobj = new Model('content_details');
            $moreimg = $moreobj->filter_index(array('content_id' => $uv['id'], 'content_group' => 'product_more_img'));
            $moreimg = $moreimg == false ? array() : $moreimg;
            $moredetail = $moreobj->filter_index(array('content_id' => $uv['id'], 'content_group' => 'product_more_detail'));
            $mdtls = [];

            foreach ($moredetail as $key => $md) {
                $md = obj($md);
                $asrvarr = [];
                $jsn = json_decode($md->json_obj);
                if (isset($jsn->services)) {
                    foreach ($jsn->services as $srvid) {
                        $srvs = getData('content', $srvid);
                        if ($srvs) {
                            $srvs = obj($srvs);
                            $srvsct = getData('service_category', $srvs->service_cat_id);
                            $asrvarr[] = array(
                                'id' => $srvs->id,
                                'title' => $srvs->title,
                                'price' => $srvs->price,
                                'duration' => $srvs->duration,
                                'duration_unit' => $srvs->duration_unit,
                                'category' => $srvsct ? $srvsct['name'] : "No category",
                            );
                        }
                    }
                }
                $mdtls[] = array(
                    "id" => $md->id,
                    "name" => $md->heading,
                    "content" => $md->content,
                    "services" => $asrvarr
                );
            }
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
            $is_fav = false;
            if (isset($req->token)) {
                $token = $req->token;
                $user = get_user_by_token($token);
                if ($user) {
                    $user = obj($user);
                    $is_fav = is_fav_content($user_id = $user->id, $content_id = $uv['id']);
                }
            }
            $listing_data[] = array(
                'id' => $uv['id'],
                'title' => $uv['title'],
                'content' => $uv['content'],
                'image' => img_or_null($img = $uv['banner']),
                'category_id' => $uv['parent_id'],
                'category' => ($uv['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $uv['parent_id'])['title'],
                'status' => $uv['status'],
                'more_img' => $mor_imgs,
                'address' => $uv['address'],
                'more_detail' => null,
                'packages' => $mdtls,
                'is_fav' => $is_fav,
                'star_rating' => strval($avg_rt_pt)
                // 'view' => view_count($book_id = $uv['id']),
                // 'author' => $uv['author']
            );
            $mor_imgs = null;
        }
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
} else {
    $data['msg'] = "Login failed";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
