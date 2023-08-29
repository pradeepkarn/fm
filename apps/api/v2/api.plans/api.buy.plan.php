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
if (!isset($req->planid)) {
    $data['msg'] = "Plan id is required";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$user = get_user_by_token($req->token);
if ($user) {
    $user = obj($user);
} else {
    $data['msg'] = "Invalid token";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$token = $req->token;
$planid = $req->planid;
$planObj = new Model('plans');
$plans = $planObj->filter_index(['id' => $planid, 'is_active' => 1]);

if (count($plans) > 0) {
    $plan = obj($plans[0]);
    try {
        $payment = new Model('customer_payment');
        $payment_id = $payment->store(
            [
                'plan_id' =>  $planid,
                'unique_id' => uniqid('PLN'),
                'amount' => $plan->price,
                'customer_email' => $user->email,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'is_paid' => 1,
                'payment_group' => 'plan'
            ]
        );
        $data['msg'] = "success";
        $data['data'] = $payment_id;
        echo json_encode($data);
        die();
    } catch (PDOException $e) {
        $data['msg'] = "Database error";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
} else {
    $data['msg'] = "No any plan is availeble";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
