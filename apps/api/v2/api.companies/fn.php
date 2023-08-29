<?php

function rel_prods($ids)
{
    $rel_prods = array();
    if ($ids) {
        foreach ($ids as $rpid) {
            if (getData('content', $rpid)) {
                $rp = getData('content', $rpid);
                $rel_prods[] = array(
                    'id' => $rp['id'],
                    'title' => $rp['title'],
                    'currency' => $rp['currency'],
                    'price' => $rp['price'],
                    'brand' => $rp['brand'],
                    // 'color'=>$rp['color'],
                    'color_list' => json_decode($rp['color_list'], true),
                    'qty' => $rp['qty'],
                    'bulk_qty' => $rp['bulk_qty'],
                    'info' => $rp['content_info'],
                    'description' => pk_excerpt(sanitize_remove_tags($rp['content'])),
                    'image' => "/media/images/pages/" . $rp['banner'],
                    'category_id' => $rp['parent_id'],
                    'category' => ($rp['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $rp['parent_id'])['title']
                );
            }
        }
    }
    return $rel_prods;
}

function read_book($book_id,$page_no=0)
{
   
    if (!isset($page_no) || $page_no=="" || $page_no==null) {
        $page_no = "0,1";
    }else{
        if (!is_int($page_no)) {
            return false;
        }
        $page_no = abs($page_no);
        $page_no = $page_no.",1";
    }
    $page = array();
    $pn = explode(",",$page_no);
    $next = null;
    $prev = null;
    if (isset($pn[0]) && isset($pn[1])) {
        if ($pn[0]==0) {
            $prev = null;
            $next = ($pn[0]+1).",1";

            // for api
            $prev_chapter = null;
            $next_chapter = ($pn[0]+1);
        }else{
            $prev = ($pn[0]-1).",1";
            $next = ($pn[0]+1).",1";

            // for api
            $prev_chapter = ($pn[0]-1);
            $next_chapter = ($pn[0]+1);
        }
        $next_page =  (new Model('content'))->filter_index(array('content_group' => 'chapter', 'parent_id' => $book_id), $ord = "ASC", $limit = $next);
        if (count($next_page)==0) {
            $next = null;
            $next_chapter = null;
        }
    }
    $db = new Model('content');
    $listings = $db->filter_index(array('content_group' => 'chapter', 'parent_id' => $book_id), $ord = "ASC", $limit = $page_no, $change_order_by_col = "id");
    if (count($listings)==0) {
        return false;
    } else {
            $uv = $listings[0];
            $moreobj = new Model('content_details');
            $moreimg = $moreobj->filter_index(array('content_id' => $uv['id'], 'content_group' => 'product_more_img'));
            $moreimg = $moreimg == false ? array() : $moreimg;
            $moredetail = $moreobj->filter_index(array('content_id' => $uv['id'], 'content_group' => 'product_more_detail'));
            $moredetail = $moredetail == false ? array() : $moredetail;

            if (count($moreimg) == 0) {
                $mor_imgs = array();
                $mor_imgs[] = "/media/images/pages/{$uv['banner']}";
            } else {
                foreach ($moreimg as $key => $fvl) :
                    $mor_imgs[] = "/media/images/pages/{$fvl['content']}";
                endforeach;
            }
           
            $page[] = array(
                'id' => $uv['id'],
                'title_en' => $uv['title'],
                'content_en' => $uv['content'],
                'title_ar' => $uv['content_info'],
                'content_ar' => $uv['other_content'],
                'image' => "/media/images/pages/" . $uv['banner'],
                'category_id' => $uv['parent_id'],
                'category_en' => ($uv['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $uv['parent_id'])['title'],
                'category_ar' => ($uv['parent_id'] == 0) ? 'Uncategoriesed' : getData('content', $uv['parent_id'])['content_info'],
                'genre' => json_decode($uv['genre']),
                'status' => $uv['status'],
                'more_img' => $mor_imgs,
                'more_detail' => $moredetail,
                'view' => $uv['qty'],
                'author' => $uv['author'],
                "prev" => $prev_chapter,
                "next" => $next_chapter
            );
            $mor_imgs = null;
            return $page[0];
    }
}
function filterByCompanyId($data) {
    $arr = array(); // an array to store the filtered data
    foreach ($data as $item) {
        if ($item['company_id']!=0) {
            $arr[$item['company_id']] = array(
                'comp'=>$item['company_id']
            );
        }
       
    }
    return $arr;
  }