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
if (!isset($req->salon_id)) {
    $data['msg'] = "Please provide salon_id";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$content_group = 'salon';
$id = $req->salon_id;
import("apps/api/$v/api.listings/fn.relprods.php");
if (filter_var($req->salon_id, FILTER_VALIDATE_INT)) {
    $id = $req->salon_id;
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
    $is_fav = false;
    if (isset($req->token)) {
        $token = $req->token;
        $user = get_user_by_token($token);
        if ($user) {
            $user = obj($user);
            $is_fav = is_fav_content($user_id = $user->id, $content_id = $listings[0]['id']);
            $recent_vdttime = date('y-m-d H:i:s');
            $dbrecent = new Dbobjects;
            $sql = "select * from recent_visit where content_id={$listings[0]['id']} and user_id=$user->id and content_group='salon'";
            $avl = $dbrecent->show($sql);
            if (count($avl) > 0) {
                $sql = "update recent_visit set created_at = '$recent_vdttime' where content_id={$listings[0]['id']} and user_id=$user->id and content_group='salon'";
                $dbrecent->show($sql);
            } else {
                $sql = "INSERT INTO recent_visit (content_id, user_id, content_group, created_at)
                VALUES ({$listings[0]['id']}, $user->id, 'salon', '$recent_vdttime')";
                $dbrecent->show($sql);
            }
        }
    }
    $rvdb = new Model('bookmarks');
    $star_ratings = $rvdb->filter_index(['content_group' => 'star-rating', 'content_id' => $listings[0]['id']]);
    // print_r($star_ratings);
    $reviews = [];
    $rating_sum = 0;
    $rating_count = 0;
    $reviews['review_list'] = array();
    foreach ($star_ratings as $rt) {
        $usr =  getData('pk_user', $rt['user_id']);
        $rating_sum += floatval($rt['detail']);
        $rating_count += 1;
        $reviews['review_list'][] = array(
            'id' => $rt['id'],
            'created_at' => $rt['created_at'],
            'dp' => dp_or_null($usr['image']),
            'name' => $usr['name'],
            'star' => $rt['detail'],
            'message' => $rt['message']
        );
    }

    $rvdb = new Dbobjects;
    $rvdb->tableName = "review";
    $arrv = null;
    $arrv['item_id'] = $listings[0]['id'];
    $arrv['item_group'] = 'salon';
    $arrv['status'] = "published";
    $dummy_reviews = $rvdb->filter($arrv);

    foreach ($dummy_reviews as $dmrt) {
            $rating_sum += floatval($dmrt['rating']);
            $rating_count += 1;
            $reviews['review_list'][] = array(
                'id' => $dmrt['id'],
                'created_at' => $dmrt['created_at'],
                'dp' => null,
                'name' => $dmrt['name'],
                'star' => $dmrt['rating'],
                'message' => $dmrt['message']
            );
        }

    $days = json_decode($listings[0]['jsn'], true);
    $timings = isset($days['openings']) ? $days['openings'] : [];

    $reviews['average_rating'] = intval($rating_count) > 0 ? round(($rating_sum / $rating_count), 2) : 0;

    $db = new Model('content');
    $arrServ = null;
    $arrServ['content_group'] = "service";
    $arrServ['created_by'] = $listings[0]['created_by'];
    $arrServ['company_id'] = $listings[0]['id'];
    $services_count = count($db->filter_index($arrServ));
    $arrServ = null;

    $listing_data['id'] = $listings[0]['id'];
    $listing_data['title'] = $listings[0]['title'];
    $listing_data['content'] = sanitize_remove_tags($listings[0]['content']);
    $listing_data['image'] = "/media/images/pages/" . $listings[0]['banner'];
    $listing_data['category_id']  = $listings[0]['parent_id'];
    $listing_data['category']  = ($listings[0]['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $listings[0]['parent_id'])['title'];
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
    $mdtls = [];
    $moredetail = $moredetail == false ? array() : $moredetail;
    foreach ($moredetail as $key => $md) {
        $total_hr = 0;
        $total_min = 0;
        $total_price = 0;
        $md = obj($md);
        $asrvarr = [];
        $jsn = json_decode($md->json_obj);
        if (isset($jsn->services)) {
            foreach ($jsn->services as $srvid) {
                $srvs = getData('content', $srvid);
                if ($srvs) {
                    $srvs = obj($srvs);
                    $srvsct = getData('service_category', $srvs->service_cat_id);
                    if ($srvs->duration_unit == "min") {
                        $total_min += $srvs->duration;
                    } else {
                        $total_hr += $srvs->duration;
                    }
                    $total_price +=  ($srvs->price - $srvs->discount_amt);
                    $asrvarr[] = array(
                        'id' => $srvs->id,
                        'title' => $srvs->title,
                        'original_price' => strval($srvs->price),
                        'discount' => strval($srvs->discount_amt),
                        'price' => strval($srvs->price - $srvs->discount_amt),
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
            "total_time" => $total_hr . "Hr:" . $total_min . "Min",
            "total_price" => strval($total_price),
            "services" => $asrvarr
        );
    }

    $listing_data['services_count'] = $services_count;
    $listing_data['packages'] = $mdtls;
    $listing_data['more_detail'] = null;
    $listing_data['address'] = $listings[0]['address'];
    $listing_data['is_fav'] = $is_fav;
    $listing_data['reviews'] = $reviews;
    $listing_data['review_count'] = $rating_count;
    $listing_data['timings'] = $timings;
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
