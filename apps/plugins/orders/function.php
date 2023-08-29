<?php
function cart_by_status($status = 'cart', $ord = 'DESC', $limit = 100, $by = 'id')
{
    $data = new stdClass();
    $cartobj = new Model('customer_order');
    $arr['status'] = $status;
    $cart = $cartobj->filter_index($arr, $ord, $limit, $by);
    $data->cart = $cart;
    $data->count = count($cart);
    return $data;
}
function parcel_bookings($order_status = 'processing', $ord = 'DESC', $limit = 100, $by = 'id')
{
    $data = new stdClass();
    $obj = new Model('parcel_bookings');
    $arr['status'] = $order_status;
    $bookings = $obj->filter_index($arr, $ord, $limit, $by);
    $data = new stdClass;
    $data->cp = $bookings;
    $data->ordCount = count($bookings);
    return $data;
}
function paid_orders($order_status = 'processing', $user, $delvia=null, $ord = 'DESC', $limit = 100, $by = 'id')
{
    $data = new stdClass();
    $obj = new Model('customer_payment');
    $arr['status'] = 'paid';
    
    if ($user['user_group']=="salesman") {
        $arr['deliver_via'] = "salesman";
        $arr['salesperson_id'] = $user['id'];
    }
    if ($delvia!=null) {
        $arr['deliver_via'] = $delvia;
    }
    $arr['order_status'] = $order_status;
    $cp = $obj->filter_index($arr, $ord, $limit, $by);
    // $carts = populate_carts($cp);
    $ord_obj = new Model('customer_order');
    $cartcnt = array();
    foreach ($cp as $pay) {
        foreach($ord_obj->filter_index(array('payment_id'=>$pay['id'])) as $cv) {
            $cartcnt[] = $cv['qty'];
        }
    }
   
    $data->cp = $cp;
    // $data->carts = $carts;
    $data->ordCount = count($cp);
    $data->cartQty = array_sum($cartcnt);
    // echo "<pre>";
    // print_r($carts);
    // echo $data->cartQty."<br>";
    $returndata = $data;
    $data = null;
    return $returndata;
}

function get_order_by_uinique_id($uid)
{
    $obj = new Model('parcel_bookings');
    $arr['unique_id'] = $uid;
    $cp = $obj->filter_index($arr);
    return $cp[0];
}
function populate_carts($paments)
{
    $pmntsarr = array();
    foreach ($paments as $pmt) {
        $purchased_items = purchased_items_by_payment($pmt['id']);
        $pmntsarr[] = array(
            'id' => $pmt['id'],
            'unique_id' => $pmt['unique_id'],
            'amount' => $pmt['amount'],
            'discount_amt' => $pmt['discount_amt'],
            'discount_type' => $pmt['discount_type'],
            'discount_ref' => $pmt['discount_ref'],
            'payment_status' => $pmt['status'],
            'order_status' => $pmt['order_status'],
            'wh_status' => $pmt['wh_status'],
            'deliver_via' => $pmt['deliver_via'],
            'name' => $pmt['name'],
            'mobile' => $pmt['mobile'],
            'company' => $pmt['company'],
            'city' => $pmt['city'],
            'house_no' => $pmt['house_no'],
            'delivery_instruction' => $pmt['delivery_instruction'],
            'latitude' => $pmt['latitude'],
            'longitude' => $pmt['longitude'],
            'address_type' => $pmt['address_type'],
            'house_no' => $pmt['house_no'],
            'receiver_house_no' => $pmt['receiver_house_no'],
            'near_by' => $pmt['near_by'],
            'created_at' => $pmt['created_at'],
            'delivery_date' => $pmt['delivery_date'],
            'cancel_info' => $pmt['cancel_info'],
            'last_action_on' => $pmt['last_action_on'],
            'salesperson_id' => $pmt['salesperson_id'],
            'purchased_items' => $purchased_items
        );
    }
    return $pmntsarr;
}

function purchased_items_by_payment($payemntid)
{
    $mycart = array();
    $cartObj = new Model('customer_order');
    $get_cart['payment_id'] = $payemntid;
    $cart = $cartObj->filter_index($get_cart);
    foreach ($cart as $ck => $cv) {
        $clrloop = array();
        $prod = getData('content', $cv['item_id']);
        foreach (json_decode($cv['color_list']) as $clv) {
            $mycart[] = array(
                'cart_id' => $cv['id'],
                'payment_id' => $cv['payment_id'],
                'item_id' => $prod['id'],
                'item_name' => $prod['title'],
                'bulk_qty' => $prod['bulk_qty'],
                'item_image' => img_by_color($prod['id'], $clv->color) != null ? img_by_color($prod['id'], $clv->color) : "/media/images/pages/{$prod['banner']}",
                'item_price' => $cv['price'],
                'item_price_wot' => $cv['price_wot'],
                'tax_on_price_wot' => $cv['tax'],
                'item_cart_qty' => $cv['qty'],
                'is_paid' => $cv['is_paid'],
                'color' => $clv->color,
                'color_cart_qty' => $clv->qty,
                'remark' => $cv['remark'],
                "cart_status" => $cv['status'],
                "shipping_status" => $cv['shipping_status'],
                "shipping_id" => $cv['shipping_id'],
                "created_at" => $cv['created_at'],
                "updated_at" => $cv['updated_at']
            );
        }
    }
    return $mycart;
}

function img_by_color($content_id,$color)
{
    $moreobj = new Model('content_details');
    $moreimg = $moreobj->filter_index(array('content_id'=>$content_id,'content_group'=>'product_more_img','color'=>$color));
    // $moreimg = $moreimg==false?array():$moreimg;
    if (count($moreimg)==0) {
        $mor_imgs = null;
    }
    else{
        foreach ($moreimg as $key => $fvl):
        $mor_imgs = "/media/images/pages/{$fvl['content']}";
        endforeach;
    }  
    return $mor_imgs;
}

function getSalesmanList()
{
    $obj = new Model('pk_user');
    // return $obj->filter_index(array('user_group'=>'salesman'));
    return $obj->filter_index(array('user_group'=>'driver'));
}
function getWhmanagerList()
{
    $obj = new Model('pk_user');
    return $obj->filter_index(array('user_group'=>'whmanager'));
}