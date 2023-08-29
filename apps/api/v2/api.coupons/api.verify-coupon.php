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
if (isset($req->token) && isset($req->amount) && isset($req->cpcode)) {

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
    $amt = get_discounted_amt($req->amount,$req->cpcode,$user->id);
    // if ($amt==false) {
    //     $data['msg'] = "Invalid coupon";
    //     $data['data'] =  null;
    //     echo json_encode($data);
    //     die();
    // }
    $data['msg'] = $amt['msg'];
    $data['data'] = strval($amt['amt']);
    echo json_encode($data);
    die();
}else {
    $data['msg'] = "Missing required field";
    $data['data'] = null;
    echo json_encode($data);
    die();
}