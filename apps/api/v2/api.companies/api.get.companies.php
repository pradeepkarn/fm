<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
if ($method!="POST") {
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
// $allcomps = get_content_by_seler_comapny($created_by=null);
import("apps/api/$v/api.companies/fn.php");

    $listing_data = array();
    $db = new Model('content');
    $listings = $db->filter_index(array('content_group' => $content_group), $ord = "DESC", $limit = "1000", $change_order_by_col = "id");
    if (count($listings) == 0) {
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        
        $comp = filterByCompanyId($data=$listings);
        // myprint($compid);
        // return;
        foreach ($comp as $key => $cmp) {
            // myprint($cmp);
            
            $uv = getData('content',$cmp['comp']);
            (new Model('content'))->filter_index(['created_by'=>$user->id]);
        
            $listing_data[] = array(
                'id' => $uv['id'],
                'title' => $uv['title'],
                'image' => img_or_null($img = $uv['banner']),
                'content' => sanitize_remove_tags($uv['content']),
                'status' => $uv['status']
            );
            $mor_imgs = null;
        }
        $data = null;
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
