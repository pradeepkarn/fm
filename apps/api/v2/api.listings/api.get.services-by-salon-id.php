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
        }
    }
    $salon = obj($listings[0]);
    $arr = null;
    $db = new Model('content');
    $arr['content_group'] = "service";
    $arr['created_by'] = $salon->created_by;
    $arr['company_id'] = $salon->id;
    $services = $db->filter_index($arr);
    $srvarr = [];
    foreach ($services as $srvs) {
        $srvs = obj($srvs);
        $srvsct = getData('service_category', $srvs->service_cat_id);
        $servcatindex = $srvsct ? $srvsct['name'] : "No category";
        if ($srvs->post_category == "featured") {
            $srvarr['featured'][] = array(
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

        $srvarr["all"][] = array(
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
    if (count($srvarr)) {
        $data['msg'] = "success";
        $data['data'] = $srvarr;
        echo json_encode($data);
        return;
    } else {
        $data['msg'] = "No Services";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
} else {
    $data['msg'] = "Please provide salon id";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
