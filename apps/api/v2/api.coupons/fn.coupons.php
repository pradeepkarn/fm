<?php 

function colpon_list($group=null)
{   $proms = new Model('coupons');
    if($group==null){
        return $proms->index();
    }else{
        return $proms->filter_index(array('coupon_group'=>$group));
    }
}
function colpon_detail($id)
{   $proms = new Model('coupons');
    return $proms->show($id);
}
function colpon_detail_by_code($code)
{   $proms = new Model('coupons');
    $cpns = $proms->filter_index(array('code'=>$code));
    if (count($cpns)>0) {
        return $cpns[0];
    }else{
        return false;
    }
}

function get_discounted_amt($amount,$code,$user_id){
    $data['msg']=null;
    $data['amt']=0;
    $discamt = null;  
    $obj = new Dbobjects;
    $tessql = "select * from salon_bookings where coupon = '$code' and status <> 'cancelled' and user_id = $user_id;";
    $cpn = $obj->show($tessql);
    if (count($cpn)>0) {
      $msg="Coupon already used";
      $data['msg']=$msg;
      $data['amt']=null;
      return $data;
    }
    $proms = new Model('coupons');
    $cpns = $proms->filter_index(array('code'=>$code));
    if (count($cpns)>0) {
       
        $cp = $cpns[0];
        if ($cp['expiry_date'] < date('Y-m-d H:i:s')) {
            $msg="Coupon expired";
            $data['msg']=$msg;
            $data['amt']=null;
            return $data;
        }
        $dvl = $cp['discount_value'];
        $dtyp = $cp['discount_type'];
        if ($amount>=$cp['min_purchase_amt']) {
            if ($dtyp=="%") {
                $discamt = round(($amount*$dvl*0.01),2);
            }else{
                $discamt = $dvl;
            }
            $msg="Coupon applied";
        }else{
            $msg="Coupon not applied for this amount";
            $discamt = null;
        }
        $data['msg']=$msg;
        $data['amt']=$discamt;
        return $data;
    }else{
        $msg="Invalid coupon";
        $data['msg']=$msg;
        $data['amt']=$discamt;
        return $data;
    }
}