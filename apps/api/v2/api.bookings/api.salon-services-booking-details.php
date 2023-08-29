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
        // $cp = booking_by_user($user->id, $status = null);
        $cp = booking_detail_by_user_api($user->id, $req->booking_id);
        foreach ($cp as $key => $pv) :
            $bk = obj($pv);
            $user = obj(getData('pk_user', $bk->user_id));
            $vendor = obj(getData('pk_user', $bk->vendor_id));
            $salon = obj(getData('content', $bk->salon_id));
            $cur_dttm = date('y-m-d H:i:s');
            $vstng_dttm = $bk->visiting_date." ".$bk->visiting_time;
            $net_amount = $bk->total_amt-$bk->coupon_discount-$bk->discount;
            if ($cur_dttm>$vstng_dttm) {
                $bkkngarr[] = array(
                    'id' => $bk->id,
                    'salon_name'=>$salon->title,
                    'salon_image'=> "/media/images/pages/$salon->banner",
                    'visiting_date' => $bk->visiting_date,
                    'visiting_time' => $bk->visiting_time,
                    'visiting_datetime' => $bk->visiting_date." ".$bk->visiting_time,
                    'status' => $bk->status,
                    'booking_data'=>json_decode($bk->jsn),
                    'net_amt'     => $net_amount
                );
            }
        endforeach;
        if (count($bkkngarr)==0) {
            $res['msg'] = "No data found";
            $res['data'] = null;
            echo json_encode($res);
            die();
        }
        
        $res['msg'] = "success";
        $res['data'] = $bkkngarr[0];
        echo json_encode($res);
        die();
    } else {
        $res['msg'] = "login failed";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
} else {
    $res['msg'] = "Token is required";
    $res['data'] = null;
    echo json_encode($res);
    die();
}


use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

$validator = new EmailValidator();
$multipleValidations = new MultipleValidationWithAnd([
    new RFCValidation(),
    new DNSCheckValidation()
]);
//ietf.org has MX records signaling a server with email capabilities
$validator->isValid("example@ietf.org", $multipleValidations); //true