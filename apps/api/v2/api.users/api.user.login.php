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
if (isset($req->credit) && isset($req->password)) {
    if ($req->credit=="" || $req->password=="") {
        $res['msg'] = "Data must not be empty";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $paramObj = new stdClass;
    $paramObj->credit = $req->credit;
    $paramObj->password = $req->password;
    $res_login = login_my_user_account($paramObj);
    if ($res_login!=false) {
        $res['msg'] = "success";
        $res['data'] = $res_login;
        echo json_encode($res);
        die();
    }else{
        $res['msg'] = "login failed";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    
}else{
    $res['msg'] = "All fields are mandatory";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
