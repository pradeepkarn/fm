<?php
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
function wh_orders($wh_status = 'new', $user, $delvia=null, $ord = 'DESC', $limit = 100, $by = 'id')
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
    $arr['wh_status'] = $wh_status;
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