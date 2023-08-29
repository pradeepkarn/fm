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
    'token',
    'from_coordinate',
    'to_coordinate',
    'from_address',
    'to_address',
    'length',
    'length_unit',
    'width',
    'width_unit',
    'height',
    'height_unit',
    'weight',
    'weight_unit',
    'user_amount',
    'pickup_date',
    'pickup_time',
    'delivery_date',
    'delivery_method',
    'your_contact',
    'receiver_contact',
    'parcel_detail'
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
    $db = new Dbobjects;
    $pdo = $db->dbpdo();
    $pdo->beginTransaction();
    // asingnings
    $from_c = null;
    $to_c = null;

    $from_cord = explode(",", $req->from_coordinate);
    $from_c = array(
        'latitude' => isset($from_cord[0]) ? $from_cord[0] : null,
        'longitude' => isset($from_cord[1]) ? $from_cord[1] : null
    );
    $to_cord = explode(",", $req->to_coordinate);
    $to_c = array(
        'latitude' => isset($to_cord[0]) ? $to_cord[0] : null,
        'longitude' => isset($to_cord[1]) ? $to_cord[1] : null
    );
    $arr['from_coordinate'] = json_encode($from_c);
    $arr['to_coordinate'] = json_encode($to_c);
    $arr['from_address'] = $req->from_address;
    $arr['to_address'] = $req->to_address;
    $arr['length'] = $req->length;
    $arr['length_unit'] = $req->length_unit;
    $arr['width'] = $req->width;
    $arr['width_unit'] = $req->width_unit;
    $arr['height'] = $req->height;
    $arr['height_unit'] = $req->height_unit;
    $arr['weight'] = $req->weight;
    $arr['weight_unit'] = $req->weight_unit;
    $arr['user_amount'] = $req->user_amount;
    $arr['pickup_date'] = $req->pickup_date;
    $arr['pickup_time'] = $req->pickup_time;
    $arr['delivery_date'] = $req->delivery_date;
    $arr['delivery_method'] = strtolower($req->delivery_method);
    $arr['your_contact'] = $req->your_contact;
    $arr['receiver_contact'] = $req->receiver_contact;
    $arr['parcel_detail'] = $req->parcel_detail;
    $arr['user_id'] = $user->id;
    $arr['user_email'] = $user->email;
    $arr['unique_id'] = strtoupper(uniqid("PKG".$user->id."U"));
    // end
    $db->tableName = "parcel_bookings";
    $db->insertData = $arr;
    try {
        $booking_id = $db->create();
        $bkdeata = $db->pk($booking_id);
        $bk = format_parcel_bookings($bk=$bkdeata);
        $pdo->commit();
        $res['msg'] = "success";
        $res['data'] = $bk;
        echo json_encode($res);
        die();
    } catch (PDOException $th) {
        $pdo->rollback();
        $db->create();
        $pdo->commit();
        $res['msg'] = "Request not sent sent, db error";
        $res['data'] = [];
        echo json_encode($res);
        die();
    }
} else {
    $res['msg'] = "login failed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
