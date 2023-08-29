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
if (isset($req->token)) {
    $user = get_user_by_token($req->token);
    if ($user!=false) {
        // $userobj = new stdClass;
        $user = (object) $user;
        // $userobj->id = $user->id;
        // $userobj->first_name = $user->first_name;
        // $userobj->last_name = $user->last_name;
        // $userobj->mobile = intval($user->mobile);
        // $userobj->email = $user->email;
        // $userobj->dob = $user->dob;
        // $userobj->gender = $user->gender;
        // $userobj->image = "/media/images/profiles/".$user->image;
        $userobj = return_user_data($user->id);
        $res['msg'] = "success";
        $res['data'] = $userobj;
        echo json_encode($res);
        die();
    }else{
        $res['msg'] = "login failed";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    
}
