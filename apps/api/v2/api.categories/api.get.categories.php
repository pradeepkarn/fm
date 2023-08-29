<?php
$v = API_V;
$cat_img_dir = "/media/images/pages/";
if (isset($_GET['cat_id'])) {
    if (filter_input(INPUT_GET, "cat_id", FILTER_VALIDATE_INT)) {
        $id = $_GET['id'];
        $db = new Model('content');
        $uv = $db->show($id);
        if ($uv == false) {
            $data['msg'] = "Not found";
            $data['data'] = null;
            echo json_encode($data);
            die();
        }
        $cat_data[] = array(
            'id' => $uv['id'],
            'title' => $uv['title'],
            'content' => $uv['content'],
            'slug' => $uv['slug'],
            'image' => $cat_img_dir . $uv['banner']
        );
        $data['msg'] = "success";
        $data['data'] = $cat_data;
        echo json_encode($data);
        return;
    } else {
        $data['msg'] = "Invalid Id";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
} else {
    $db = new Model('content');
    $listings = $db->filter_index(['content_group' => 'listing_category']);
    if ($listings == false) {
        $data['msg'] = "No Category found";
        $data['data'] = null;
        echo json_encode($data);
        die();
    } else {
        foreach ($listings as $key => $uv) {
            $cat_data[] = array(
                'id' => $uv['id'],
                'title' => $uv['title'],
                'content' => $uv['content'],
                'slug' => $uv['slug'],
                'image' => $cat_img_dir . $uv['banner']
            );
        }
        $data['msg'] = "success";
        $data['data'] = $cat_data;
        echo json_encode($data);
        return;
    }
}
