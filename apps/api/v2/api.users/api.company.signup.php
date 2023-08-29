<?php

$v = API_V;
import("apps/api/$v/api.users/fn.users.php");

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
if (isset($req->mobile) && isset($req->password) && isset($req->name)) {
    if (!intval($req->mobile)) {
        $res['msg'] = "Mobile number must be numeric";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $paramObj = new stdClass;
    $newemail = generate_dummy_email();
    $paramObj->mobile = intval($req->mobile);
    $paramObj->email = $newemail;
    $paramObj->password = $req->password;
    $paramObj->confirm_password = $req->password;
    $paramObj->name = $req->name;
    $paramObj->first_name = $req->name;
    $paramObj->last_name = null;
    $res_signup = create_my_user_account($paramObj);
    if ($res_signup->success==false) {
        $res['msg'] = $res_signup->msg;
        $res['data'] = null;
        echo json_encode($res);
        die();
    }else{
        $res['msg'] = $res_signup->msg;
        $res['data'] = $res_signup->res;
        echo json_encode($res);
        die();
    }
    
}else{
    $res['msg'] = "All fields are mandatory";
    $res['data'] =null;
    echo json_encode($res);
    die();
}
