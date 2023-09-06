<?php
$v = API_V;
function faq_list()
{
    $db = new Dbobjects;
    $sql = "SELECT id, title as question, content as answer FROM content where content_group = 'faq'";
    $faq_list = $db->show($sql);
    return $faq_list;
}
$faqs = faq_list();
if (count($faqs) == 0) {
    $data['msg'] = "No data found";
    $data['data'] = null;
    echo json_encode($data);
    die();
} else {
    $data['msg'] = "success";
    $data['data'] = faq_list();
    echo json_encode($data);
    return;
}
