<?php
import('apps/api/v1/api.listings/fn.relprods.php');
if (!isset($_POST['cat_id'])) {
    $data['msg'] = "Please provide categroy id";
    $data['data'] = null;
    echo json_encode($data);
    return;
}
if (!filter_var($_POST['cat_id'],FILTER_VALIDATE_INT)) {
    $data['msg'] = "Invalid category ID";
    $data['data'] = null;
    echo json_encode($data);
    return;
}
    $db = new Model('content');
    $listings = $db->filter_index(array('content_group'=>'product','parent_id'=>$_POST['cat_id']),$ord="DESC",$limit="1000",$change_order_by_col="id");
    if ($listings==false) {
        $data['msg'] = "No Listing";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    else{
        foreach ($listings as $key => $uv) {
            $rel_prods = array();
            $user = getData('pk_user',$uv['created_by']);  
            $moreobj = new Model('content_details');
            $moreimg = $moreobj->filter_index(array('content_id'=>$uv['id'],'content_group'=>'product_more_img'));
            $moreimg = $moreimg==false?array():$moreimg;
            $moredetail = $moreobj->filter_index(array('content_id'=>$uv['id'],'content_group'=>'product_more_detail'));
            $moredetail = $moredetail==false?array():$moredetail;
            if (count($moreimg)==0) {
                $mor_imgs = array();
                $mor_imgs[] = "/media/images/pages/{$uv['banner']}";
            }
            else{
                foreach ($moreimg as $key => $fvl):
                $mor_imgs[] = "/media/images/pages/{$fvl['content']}";
                endforeach;
            }
            if ($uv['json_obj']!=null) {
                $jsn = json_decode($uv['json_obj']);
                if (isset($jsn->related_products)) {
                    $rel_prods = rel_prods($jsn->related_products) ;
                }
            } 
            $colorObj = new Model('content');
            $cv = array();
            $colorObj = $colorObj->show_unique_whr('color',array('grouped_content'=>$uv['grouped_content'],'content_group'=>'product'));
            
            foreach ($colorObj as $key => $cvv) {
                if ($cvv['color']!="") {
                    $cv[] = $cvv['color'];
                }
            }           
            $listing_data[] = array(
                'id'=>$uv['id'],
                'title'=>$uv['title'],
                // 'currency'=>$uv['currency'],
                'price'=>$uv['price'],
                'tax'=>$uv['tax'],
                'qty_to_sell'=>$uv['bulk_qty'],
                'stock_qty'=>$uv['qty'],
                'brand'=>$uv['brand'],
                // 'color'=>$uv['color'],
                'color_list'=>json_decode($uv['color_list'],true),
                'info'=>$uv['content_info'],
                'description'=>pk_excerpt(sanitize_remove_tags($uv['content'])),
                'image' => "/media/images/pages/".$uv['banner'],
                // 'category_id' => $uv['parent_id'],
                // 'category' => ($uv['parent_id']==0)?'Uncategoriesed':getData('content',$uv['parent_id'])['title'],
                'rel_prods' => $rel_prods,
                // 'product_group' => getData('grouped_content',$uv['grouped_content'])?getData('grouped_content',$uv['grouped_content']):null,
                // 'product_color_group' => $cv,
                // 'status' => $uv['status'],
                'more_img' => $mor_imgs,
                'more_detail' => $moredetail,
                // 'listed_by' => $uv['created_by'],
                // 'user_membership' => $user['user_group'],
                // 'full_name' => $user['name'],
                // 'username' => $user['username'],
            );
            $mor_imgs = null;
        }
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }