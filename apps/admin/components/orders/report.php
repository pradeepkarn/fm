<?php
import("apps/admin/components/orders/fn.orders.php");
if (is_superuser()) : 
if (isset($_GET['filter']) && intval($_GET['filter'])) {
    $user = getData('pk_user',$_GET['filter']);
    $delvia = null;
}
else if (isset($_GET['filter']) && $_GET['filter']=='courier') {
    $delvia = "courier";
    $user = USER;
}
else{
    $user = USER;
    $delvia = null;
}
else:
    $user = USER;
    $delvia = null;
endif;
$status = $_GET['status'];
if (USER['user_group']=="whmanager") {
    $ords = wh_orders($status,$user,$delvia);
}else{
    $ords = paid_orders($status,$user,$delvia);
}


// myprint($ords->cp);
// return;
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename={$status}_orders.csv");


$fp = fopen('php://output', 'wb');

// $val = explode(",", $line);
// fputcsv($fp, $val);

$i=0;
$ords->cp = json_decode(json_encode($ords->cp));
foreach ( $ords->cp as $val ) {
    if ($i==0) {
        $data = array(
            "Order Number,Amount,Paid,Discount,Discount Type,Discount Ref.,Status,Payment Method,Dial Code,Mobile,City,Note,Name,Latitude,Longitude,Company,House No.,Near By,Delivery Instruction,Address type,Receiver house no,Order status,Ware House Status,Created at,Deliver via,Delivery date,Salesperson id,Cancel info,Last action on",
            "$val->unique_id,$val->amount,$val->is_paid,$val->discount_amt,$val->discount_type,$val->discount_ref,$val->status,$val->payment_method,$val->isd_code,$val->mobile,$val->city,$val->order_note,$val->name,$val->latitude,$val->longitude,$val->company,$val->house_no,$val->near_by,$val->delivery_instruction,$val->address_type,$val->receiver_house_no,$val->order_status,$val->wh_status,$val->created_at,$val->deliver_via,$val->delivery_date,$val->salesperson_id,$val->cancel_info,$val->last_action_on"
        );
    }
    else{
        $data = array(
            "$val->unique_id,$val->amount,$val->is_paid,$val->discount_amt,$val->discount_type,$val->discount_ref,$val->status,$val->payment_method,$val->isd_code,$val->mobile,$val->city,$val->order_note,$val->name,$val->latitude,$val->longitude,$val->company,$val->house_no,$val->near_by,$val->delivery_instruction,$val->address_type,$val->receiver_house_no,$val->order_status,$val->wh_status,$val->created_at,$val->deliver_via,$val->delivery_date,$val->salesperson_id,$val->cancel_info,$val->last_action_on"
        );
    }
    foreach ( $data as $line ) {
        $cellarr = explode(",", $line);
        fputcsv($fp, $cellarr);
    }
    $i++;
}
fclose($fp);