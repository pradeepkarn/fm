<?php 
function show_promotions($group=null)
{   $proms = new Model('promotions');
    if($group==null){
        return $proms->index();
    }else{
        return $proms->filter_index(array('content_group'=>$group));
    }
}
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