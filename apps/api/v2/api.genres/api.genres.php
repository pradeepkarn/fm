<?php
$db = new Model('genre');
$genres = $db->filter_index(array('content_group' => 'book'));
$genre_list = array();
foreach ($genres as $key => $gv) {
    $genre_list[] = array(
        'id' => $gv['id'],
        'genre' => $gv['genre'],
        'genre_ar' => $gv['genre_ar']
    );
}
$data['msg'] = "success";
$data['data'] = $genre_list;
if (count($genre_list)==0) {
    $data['msg'] = "No genre found";
    $data['data'] = null;
}
echo json_encode($data);
return;
