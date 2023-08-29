<?php 

// function add_to_cart_db($id)
// {  
//     $cart = new Mydb('my_order');
//     $arr = null;
//     $arr['status'] = 'cart';
//     $arr['item_id'] = $id;
//     $items = array();
//     if(count($cart->filterData($arr))>0){
//         $mcart = $cart->filterData($arr);
//         // $cart->startTrans();
//         foreach ($mcart as $key => $cv) {
//             $cv['qty'] += 1;
//             $qty = $cv['qty'];
//             $cart->updateData(["qty"=>$qty]);
//         }
//         // $cart->endTrans();
//     }
// }

// function remove_from_cart_db($id){
//     $cart = new Mydb('my_order');
//     $arr = null;
//     $arr['status'] = 'cart';
//     $arr['item_id'] = $id;
//     $items = array();
//     if(count($cart->filterData($arr))>0){
//         $mcart = $cart->filterData($arr);
//         foreach ($mcart as $key => $cv) {
//             if ($cv['qty'] == 1) {
//                 $cart->deleteData();
//             }
//             else{
//                 $cv['qty'] -= 1;
//                 $qty = $cv['qty'];
//                 $cart->updateData(["qty"=>$qty]);
//             }
            
//         }
//     }
// }

function add_to_cart($id,$action="add_to_cart")
{
    $live_stock = check_stock_minus_hold($id);
    // echo js_alert($live_stock);
    //$_SESSION['cart'] = null;
    if (isset($_SESSION['cart'][$id])) {
        if ($action=='buy_now') {
            return;
        }
        else{
            if ($live_stock>=1) {
                $_SESSION['cart'][$id]['id'] = $id;
                $_SESSION['cart'][$id]['qty'] += 1;
                return true;
            }
            else{
                return false;
            }
            
        }
        
    }
    else{
        if ($live_stock>=1) {
            $_SESSION['cart'][$id]['id'] = $id;
            $_SESSION['cart'][$id]['qty'] = 1;
            return true;
        }
        else{
            return false;
        }
        
    }
}
function remove_from_cart($id){
    if (isset($_SESSION['cart'][$id])) {
        if ($_SESSION['cart'][$id]['qty']>1) {
            $_SESSION['cart'][$id]['id'] = $id;
            $_SESSION['cart'][$id]['qty'] -= 1;
        }
        else{
            unset($_SESSION['cart'][$id]);
        }
    }
    if (count($_SESSION['cart'])==0) {
        unset($_SESSION['cart']);
    }
}
function check_stock_minus_hold($prodid){
    $item = new Mydb('content');
    $prod = $item->pkData($prodid);
    $old_hold_obj = (new Model('customer_order'))->filter_index(array('item_id'=>$prod['id'],'status'=>'hold'));
    $old_hold_db_qty = 0;
    if ($old_hold_obj!=false) {
        foreach ($old_hold_obj as $key => $hldqty) {
        $hldqtyar[] = $hldqty['qty'];
        }
        $old_hold_db_qty = array_sum($hldqtyar);
    }
    else{
        $old_hold_db_qty = 0;
    }
    $prod_qty_minus_hold_qty = $prod['qty'] - $old_hold_db_qty;
    return $prod_qty_minus_hold_qty;
}
   

//transaction testing
function createPayment($payment_method){
    $db2 = new Dbobjects;
    $db2->tableName = "booking_data";
     $arr = null;
     $arr['status'] = "new";
     $arr['is_paid'] = 0;
     $arr['user_id'] = $_SESSION['user_id'];
     if(count($db2->filter($arr))>0){
        $mycart = $db2->filter($arr,"DESC",$limit=10000);
        foreach ($mycart as $key => $crtv) {
            $qty = $crtv['booking_qty'];
            $price = $crtv['price_per_unit'];
            $amts[] = $qty*$price;
        }
    $tamt = array_sum($amts);
    $payment_id = time()."-".rand(100000,999999)."-".$_SESSION['user_id'];
    //table 1
    $db = new Dbobjects;
    $db->tableName = "payment";
    $arr = ['unique_id'=>$payment_id,
    'amount'=>$tamt,'status'=>'initiated',
    'payment_method'=>$payment_method,
    'user_id'=>$_SESSION['user_id'],
    'name'=>sanitize_remove_tags($_POST['name']),
    'mobile'=>sanitize_remove_tags($_POST['mobile']),
    'locality'=>sanitize_remove_tags($_POST['locality']),
    'city'=>sanitize_remove_tags($_POST['city']),
    'state'=>sanitize_remove_tags($_POST['state']),
    'country'=>sanitize_remove_tags($_POST['country']),
    'zipcode'=>sanitize_remove_tags($_POST['zipcode'])
    ];
    $db->insertData = $arr;
    $sql = $db->create_sql();
    //print_r($sql);
    //table 2   
    try{
        //start transaction
    $db->dbpdo()->beginTransaction();
    $db->dbpdo()->exec($sql);
    //connection between table 1 and 2
    $arrpm['payment_id'] = $db->dbpdo()->lastInsertId();
    $arrpm['is_paid'] = 1;
    $db2->insertData = $arrpm;
    $sqlpm = $db2->update_sql(); //payment sql for new user
    //work for any transaction sql
    //print_r($sqlpm);
    $db->dbpdo()->exec($sqlpm);
    // if everything is fine end transaction
    $db->dbpdo()->commit();
    return true;
    }
    catch (Exception $e) {
        // if everything is not ok
        echo $e;
        $db->dbpdo()->rollBack();
        $db2->delete();
        return false;
      }
}
}




