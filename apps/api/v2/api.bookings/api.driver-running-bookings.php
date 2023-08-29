<?php
$v = API_V;
import("apps/api/$v/api.users/fn.users.php");
import("apps/api/$v/api.bookings/fn-bookings.php");
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    // $req = json_decode(file_get_contents('php://input'));
    $req = obj($_POST);
    // Do something with the data
} elseif ($method === 'GET') {
    $res['msg'] = "Get method is not allowed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
$data_list = [
    'token'
];

foreach ($data_list as $li) {
    if (!isset($_POST[$li])) {
        $res['msg'] = "You are missing the value for '$li'";
        $res['data'] = null;
        echo json_encode($res);
        die(); 
    }
}

$user = get_user_by_token($req->token);
if ($user != false) {
    $user = (object) $user;
    if ($user->email == null || $user->email == '') {
        $res['msg'] = "Please update your email in profile section, email will be used to send booking status.";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    if ($user->user_group != 'driver') {
        $res['msg'] = "Please login with your driver account";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $db = new Dbobjects;
    $db->tableName = "parcel_bookings";
    $bkdeata = $db->filter(assoc_arr:['assigned_driver_id'=>$user->id],limit:10000,ord:'desc');
    $bkdata = [];
    foreach ($bkdeata as $key => $bk) {
        $bkobj = obj($bk);
        if ($bkobj->assigned_driver_id!='' && $bkobj->status!='cancelled') {
            $bkdata[] = format_parcel_bookings($bk);
        }
    }
    if (count($bkdata)==0) {
        $res['msg'] = "Currently no ruuning bookings found";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $res['msg'] = "success";
    $res['data'] = $bkdata;
    echo json_encode($res);
    die();
} else {
    $res['msg'] = "login failed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
