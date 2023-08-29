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

$paymentsObj = new Model('customer_payment');
$payments = $paymentsObj->filter_index(['payment_group'=>'plan','customer_email'=>$user->email,'is_paid'=>1]);
$plan_arr = [];
foreach ($payments as $pmt) {
    $pmt = obj($pmt);
    $pv = obj(getData('plans',$pmt->plan_id));
    $plan_arr[] = [
        'payment_group'=>$pmt->payment_group,
        'payment_data' => array(
            'id'=>$pv->id,
            'name'=>$pv->name,
            'price'=>$pv->price,
            'duration_days'=>$pv->duration_days,
            'details'=>$pv->details,
            'updated_at'=>$pv->updated_at,
            'features'=>($pv->data!='')?json_decode($pv->data):[]
        )
    ];
}
if (count($payments)>0) {
    $data['msg'] = "success";
    $data['data'] = $plan_arr;
    echo json_encode($data);
    die();
}else{
    $data['msg'] = "No any purchased plan found";
    $data['data'] = null;
    echo json_encode($data);
    die();
}

