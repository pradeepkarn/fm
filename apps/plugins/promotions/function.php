<?php 
function show_promotions($catid=null)
{   $proms = new Model('promotions');
    if($catid==null){
        return $proms->index();
    }else{
        return $proms->filter_index(array('promo_cat'=>$catid));
    }
}