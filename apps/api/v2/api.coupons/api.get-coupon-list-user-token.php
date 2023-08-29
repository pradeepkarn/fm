<?php
import("apps/api/v2/api.coupons/fn.coupons.php");
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
    // Do something with the data
} elseif ($method === 'GET') {
    $res['msg'] = "Get method is not allowed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
if (isset($req->token)) {

    $arr = null;
    $token = $req->token;
    $userobj = new Model('pk_user');
    $user = $userobj->filter_index(array('app_login_token' => $token));
    if (count($user)>0) {
        $user = obj($user[0]);
    }else{
        $data['msg'] = "User not found, token expired";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    $cl = colpon_list($group=null);
    if (count($cl)>0) {
        $data['msg'] = "success";
        $data['data'] = $cl;
        echo json_encode($data);
        die();
    }else{
        $data['msg'] = "Currently no any coupon is availble";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    
}else {
    $data['msg'] = "Missing required field";
    $data['data'] = null;
    echo json_encode($data);
    die();
}