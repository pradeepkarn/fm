<?php
$v = API_V;
    $db = new Model('content');
    $transportations = $db->filter_index(array('content_group' => 'transportation'), $ord = "DESC", $limit = "10", $change_order_by_col = "id");
    $maintenance = $db->filter_index(array('content_group' => 'maintenance'), $ord = "DESC", $limit = "10", $change_order_by_col = "id");
    $rent_equipemnts = $db->filter_index(array('content_group' => 'rent-equipment'), $ord = "DESC", $limit = "10", $change_order_by_col = "id");
    $listings = array_merge($transportations,$maintenance,$rent_equipemnts);
    if ($listings == false) {
        $data['msg'] = "No banners";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        $listing_data = array();
        foreach ($listings as $key => $uv) {
            $banner = null;
            if (file_exists(MEDIA_ROOT."images/pages/" . $uv['banner'])) {
                $banner = "/media/images/pages/".$uv['banner'];
            }
            if ($uv['banner']=="") {
                $banner = null;
            }
            $rel_prods = array();
            $user = getData('pk_user', $uv['created_by']);
            $moreobj = new Model('content_details');
            $listing_data[] = array(
                'id' => $uv['id'],
                'title' => $uv['title'],
                'image' => $banner
            );
            $mor_imgs = null;
        }
        $data['msg'] = "success";
        $data['data'] = $listing_data;
        echo json_encode($data);
        return;
    }
