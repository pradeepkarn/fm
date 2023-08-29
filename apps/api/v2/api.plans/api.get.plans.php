<?php

$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
if ($method != "POST") {
    $data['msg'] = "Only post method is allowed";
    $data['data'] = null;
    echo json_encode($data);
    die();
}

$jsondata = file_get_contents('php://input');

$req = json_decode($jsondata);

if (!isset($req->token)) {
    $data['msg'] = "Login token is required";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$user = get_user_by_token($req->token);
if ($user) {
   $user = obj($user);
}else{
    $data['msg'] = "Invalid token";
    $data['data'] = null;
    echo json_encode($data);
    die();
}

$planObj = new Model('plans');
$plans = $planObj->filter_index(['is_active'=>1]);
$plan_arr = [];
foreach ($plans as $pv) {
    $pv = obj($pv);
    $plan_arr[] = [
        'id'=>$pv->id,
        'name'=>$pv->name,
        'price'=>$pv->price,
        'duration_days'=>$pv->duration_days,
        'details'=>$pv->details,
        'updated_at'=>$pv->updated_at,
        'features'=>($pv->data!='')?json_decode($pv->data):[]
    ];
}
if (count($plans)>0) {
    $data['msg'] = "success";
    $data['data'] = $plan_arr;
    echo json_encode($data);
    die();
}else{
    $data['msg'] = "No any plan is availeble";
    $data['data'] = $plan_arr;
    echo json_encode($data);
    die();
}

