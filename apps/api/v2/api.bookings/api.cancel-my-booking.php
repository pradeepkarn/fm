<?php
$v = API_V;
import("apps/api/$v/api.users/fn.users.php");
import("apps/api/$v/api.bookings/fn-bookings.php");
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
if (isset($req->token) && isset($req->booking_id)) {
    $user = get_user_by_token($req->token);
    if ($user != false) {
        $user = (object) $user;
        $bkkngarr = [];
        $reply = change_booking_satus_api($user->id, $req->booking_id, $status = 'cancelled');
        if ($reply['data'] == true) {
            $res['msg'] = $reply['msg'];
            $res['data'] = array();
            echo json_encode($res);
            die();
        } else {
            $res['msg'] = $reply['msg'];
            $res['data'] = null;
            echo json_encode($res);
            die();
        }
    } else {
        $res['msg'] = "Login failed";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
} else {
    $res['msg'] = "User Token and booking id is required";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
