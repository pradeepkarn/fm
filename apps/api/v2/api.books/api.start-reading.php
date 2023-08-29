<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
import("apps/api/$v/api.books/fn.relprods.php");
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
    if (!isset($req->chapter)) {
        $req->chapter = 0;
    }
    if ($req->chapter!==0) {
        if (!intval($req->chapter)) {
            $data['msg'] = "No chapter found, invalid page";
            $data['data'] = null;
            echo json_encode($data);
            return;
        }
    }
    
    if (isset($req->book_id) && isset($req->chapter)) {
        if (filter_var($req->book_id, FILTER_VALIDATE_INT)) {
            $id = $req->book_id;
            $chapter = read_book($book_id=$id, $page_no = $req->chapter);
            if ($chapter==false) {
                $data['msg'] = "Page number not found";
                $data['data'] = null;
                echo json_encode($data);
                return;
            }else{
                $data['msg'] = "Success";
                $data['data'] = $chapter;
                most_read_books();
                content_view_count($id=$chapter['id']);
                echo json_encode($data);
                return;
            }
        }
    }else{
        $data['msg'] = "No chapter found";
        $data['data'] = null;
        echo json_encode($data);
        return;
    }
}
