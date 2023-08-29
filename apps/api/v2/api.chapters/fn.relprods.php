<?php 

function rel_prods($ids)
{
    $rel_prods = array();
    if ($ids) {
        foreach ($ids as $rpid) {
            if (getData('content',$rpid)) {
                $rp = getData('content',$rpid);
                $rel_prods[] = array(
                    'id'=>$rp['id'],
                    'title'=>$rp['title'],
                    'currency'=>$rp['currency'],
                    'price'=>$rp['price'],
                    'brand'=>$rp['brand'],
                    // 'color'=>$rp['color'],
                    'color_list'=>json_decode($rp['color_list'],true),
                    'qty'=>$rp['qty'],
                    'bulk_qty'=>$rp['bulk_qty'],
                    'info'=>$rp['content_info'],
                    'description'=>pk_excerpt(sanitize_remove_tags($rp['content'])),
                    'image' => "/media/images/pages/".$rp['banner'],
                    'category_id' => $rp['parent_id'],
                    'category' => ($rp['parent_id']==0)?'Uncategoriesed':getData('content',$rp['parent_id'])['title']
                );
            }
        }
        
    }
    return $rel_prods;
}