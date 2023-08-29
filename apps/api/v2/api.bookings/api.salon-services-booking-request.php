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
if (isset($req->token) && isset($req->services_ids) && isset($req->visiting_date) && isset($req->visiting_time) && isset($req->salon_id)) {
    $user = get_user_by_token($req->token);
    if ($user != false) {
        $user = (object) $user;
        if ($user->email == null || $user->email == '') {
            $res['msg'] = "Please update your email in profile section, email will be used to send booking status.";
            $res['data'] = null;
            echo json_encode($res);
            die();
        }
        $salon = getData('content',$req->salon_id);
        if ($salon) {
            if ($salon['content_group']!='salon') {
                $res['msg'] = "Invalid salon id";
                $res['data'] = null;
                echo json_encode($res);
                die();
            }
        }else{
            $res['msg'] = "Salon object not found";
            $res['data'] = null;
            echo json_encode($res);
            die();
        }
        
        $salon = obj($salon);
        $db = new Dbobjects;
        $pdo = $db->dbpdo();
        $pdo->beginTransaction();
        $total_price = 0;
        $total_discount=0;
        $coupon_discount = 0;
        $jsnarr = [];
        if (isset($req->services_ids)) {
            if (count($req->services_ids)==0) {
                $res['msg'] = "Please select at least one service";
                $res['data'] = null;
                echo json_encode($res);
                die();
            }
            foreach ($req->services_ids as $servid) {
                
                $db->tableName = 'content';
                $service = $db->filter(['id'=>$servid]);
                // print_r($service);
                if (count($service)>0) {
                    if ($service[0]['company_id']!=$salon->id) {
                        $res['msg'] = "{$service[0]['title']} (id: {$service[0]['id']} ) not found in the salon you provided";
                        $res['data'] = null;
                        echo json_encode($res);
                        die();
                    }
                    $srv = obj($service[0]);
                    $jsnarr['services'][] = array(
                        'id'=>$srv->id,
                        'price'=>$srv->price,
                        'title'=>$srv->title,
                        'duration'=>$srv->duration,
                        'duration_unit'=>$srv->duration_unit,
                        'salon_id'=>$salon->id,
                        'vendor_id'=>$salon->created_by
                    );

                    $total_price += $srv->price;
                    $total_discount += $srv->discount_amt;
                }else{
                    $res['msg'] = "$servid not found in the salon you provided";
                    $res['data'] = null;
                    echo json_encode($res);
                    die();
                }
            }
        }
        $sale_price = $total_price-$total_discount;
        if (isset($req->coupon)) {
            $coupon_discount = get_discounted_coupon_amt($sale_price,$req->coupon,$user->id,$db)['amt'];
        }

        $jsnarr['total_amt'] = $total_price;
        
        $jsnarr['coupon'] = isset($req->coupon)?$req->coupon:null;
        if ($coupon_discount==0) {
            $jsnarr['coupon'] = null;
        }
        $jsnarr['coupon_discount'] = $coupon_discount;
        $jsnarr['coupon_expiry_date'] = null;
        $jsnarr['user_id'] = $user->id;
        $jsnarr['salon_id'] = $salon->id;
        $jsnarr['vendor_id'] = $salon->created_by;
        $jsnarr['discount'] = $total_discount;
        $jsnarr['note'] = isset($req->note)?$req->note:null;
        $jsnarr['net_amt'] = $sale_price-$coupon_discount;
        
        $db->tableName = "salon_bookings";
        $arr=null;
        $arr['visiting_date'] = $req->visiting_date;
        $arr['visiting_time'] = $req->visiting_time;
        $arr['total_amt'] = $total_price;
        $arr['user_id'] = $user->id;
        $arr['salon_id'] = $salon->id;
        $arr['vendor_id'] = $salon->created_by;
        $arr['note'] = isset($req->note)?$req->note:null;
        $arr['discount'] = $total_discount;
        $arr['coupon_discount'] = $coupon_discount;
        $arr['jsn'] = json_encode($jsnarr);
        $arr['coupon'] = isset($req->coupon)?$req->coupon:null;
        if ($coupon_discount==0) {
            $arr['coupon'] = null;
        }
        $arr['net_amt'] = $sale_price-$coupon_discount;

        $db->insertData = $arr;
        try {
            $db->create();
            $pdo->commit();
            $res['msg'] = "success";
            $res['data'] = [];
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
} else {
    $res['msg'] = "all fields (token, salon id, services ids, date and time) are required";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
