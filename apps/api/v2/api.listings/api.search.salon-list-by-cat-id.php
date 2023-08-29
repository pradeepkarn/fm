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
if (!isset($req->cat_id)) {
    $data['msg'] = "Please provide cat_id";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
if (!isset($req->search)) {
    $data['msg'] = "Please provide search keyword";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$content_group = 'salon';
$parent_id = $req->cat_id;
$search = $req->search;
import("apps/api/$v/api.listings/fn.relprods.php");
if (isset($req->cat_id)) {
    if (filter_var($req->cat_id, FILTER_VALIDATE_INT)) {
        $db = new Model('content');
        $search_arr['title'] = $search;
        $listings = $db->search(assoc_arr: $search_arr, whr_arr: array('content_group' => $content_group, 'parent_id' => $parent_id));
        if ($listings == false) {
            $data['msg'] = "No Listing";
            $data['data'] = null;
            echo json_encode($data);
            die();
        } else {

            // Increase view by 1
            $db = new Dbobjects;

            $db->show(
                "update content set views = views+1 where content.id = $req->cat_id"
            );

            // Count this categor as opend

            foreach ($listings as $key => $uv) {
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
                    'is_fav' => $is_fav
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
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
}
