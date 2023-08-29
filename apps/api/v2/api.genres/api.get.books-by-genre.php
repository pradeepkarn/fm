<?php
import('apps/api/v1/api.listings/fn.relprods.php');
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
    if (!isset($req->genre)) {
        $data['msg'] = "Please provide genre";
        $data['data'] = null;
        echo json_encode($data);
        return;
    }
}else{
    $data['msg'] = "Invalid method, only post method is allowed";
    $data['data'] = null;
    echo json_encode($data);
    return;
}
$searchByGenreObj = new Model('content');
$arr['genre'] = $req->genre;
$whrarr['content_group'] = "book";
$books = $searchByGenreObj->search($arr, "DESC", 1000, 'title', $whrarr);
if ($books == false) {
    $data['msg'] = "Book not found";
    $data['data'] = null;
    echo json_encode($data);
    return;
} else {
    foreach ($books as $key => $uv) {
        $rel_prods = array();

        // $rel_prods = array();
        $user = getData('pk_user', $uv['created_by']);
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
        if ($uv['json_obj'] != null) {
            $jsn = json_decode($uv['json_obj']);
            if (isset($jsn->related_products)) {
                $rel_prods = rel_prods($jsn->related_products);
            }
        }
        $listing_data[] = array(
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
            'view' => view_count($book_id = $uv['id']),
            'author' => $uv['author']
        );
        $mor_imgs = null;
    }
    $data['msg'] = "success";
    $data['data'] = $listing_data;
    echo json_encode($data);
    return;
}
