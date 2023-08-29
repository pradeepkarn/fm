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
    'booking_id',
    'quote_amount'
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
if (!is_numeric($req->booking_id) || !is_numeric($req->quote_amount)) {
    $res['msg'] = "Invalid booking id or quote amount or both, please check";
    $res['data'] = null;
    echo json_encode($res);
    die(); // Stop further execution
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

    $check_sql = "select * from driver_quotes where driver_id = $user->id and booking_id = $req->booking_id";
    $booking_found = count($db->show($check_sql)) > 0 ? true : false;
    if ($booking_found == true) {
        $res['msg'] = "You already have quoted this order";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $booking = $db->show("select * from parcel_bookings where id = $req->booking_id");
    if (count($booking)==0) {
        $res['msg'] = "Booking not found";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
   
    $db->tableName = "driver_quotes";
    $arr = null;
    $arr['booking_id'] = $req->booking_id;
    $arr['driver_id'] = $user->id;
    $arr['quote_amount'] = $req->quote_amount;
    $arr['is_confirmed'] = 0;
    $arr['remark'] = 'quoted';
    
    try {
        $db->tableName = "driver_quotes";
        $db->insertData = $arr;
        $id = $db->create();
        $quote = $db->pk($id);
        $pdo->commit();
        $res['msg'] = "success";
        $res['data'] = format_quote($quote);
        echo json_encode($res);
        die();
    } catch (PDOException $th) {
        $pdo->rollback();
        $db->create();
        $pdo->commit();
        $res['msg'] = "Request not sent sent, check input data error";
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
