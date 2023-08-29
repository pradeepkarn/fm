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

// Initialize the response array
$res = array();

foreach ($data_list as $li) {
    if (!isset($_POST[$li])) {
        $res['msg'] = "You are missing the value for '$li'";
        $res['data'] = null;
        echo json_encode($res);
        die(); // Stop further execution
    }
    // $arr[$li] = $_POST[$li];
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
    $pdo = $db->dbpdo();
    $pdo->beginTransaction();

    $check_sql = "select * from driver_quotes where driver_id = $user->id and status != 'approved'";
    $bookings = $db->show($check_sql);
    $booking_found = count($bookings) > 0 ? true : false;
    if ($booking_found == false) {
        $res['msg'] = "No data found";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $abookings = [];
    foreach ($bookings as $qt) {
        $qt = obj($qt);
        $booking = $db->show("select * from parcel_bookings where id = $qt->booking_id");
        if (count($booking) > 0) {
            $abookings[] = format_parcel_bookings($booking[0]);
        }
    }

    if (count($abookings) == 0) {
        $res['msg'] = "Booking not found";
        $res['data'] = null;
        echo json_encode($res);
        die();
    } else {
        $res['msg'] = "success";
        $res['data'] = $abookings;
        echo json_encode($res);
        die();
    }
} else {
    $res['msg'] = "login failed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
