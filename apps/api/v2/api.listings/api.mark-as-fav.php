<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
import("apps/api/$v/api.listings/fn.relprods.php");
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
    if (isset($req->salon_id)) {
        if (filter_var($req->salon_id, FILTER_VALIDATE_INT)) {
            $id = $req->salon_id;
            $token = isset($req->token) ? $req->token : null;
            $user = get_user_by_token($token);
            if ($user == false) {
                $data['msg'] = "Invalid token";
                $data['data'] = null;
                echo json_encode($data);
                return;
            }
            if (!getData('content', $id)) {
                $data['msg'] = "Invalid salon id";
                $data['data'] = null;
                echo json_encode($data);
                return;
            }
            $salon = mark_as_fav_content($content_id = $id, $token = $token);
            if ($salon == 'liked') {
                $data['msg'] = "success";
                $data['data'] = [];
                echo json_encode($data);
                return;
            } else if ($salon == 'unliked') {
                $data['msg'] = "removed";
                $data['data'] = null;
                echo json_encode($data);
                return;
            } else if ($salon == 'invalid_id') {
                $data['msg'] = "Invalid salon id";
                $data['data'] = null;
                echo json_encode($data);
                return;
            } else {
                $data['msg'] = "removed";
                $data['data'] = null;
                echo json_encode($data);
                return;
            }
        }
    } else {
        $data['msg'] = "No data found";
        $data['data'] = null;
        echo json_encode($data);
        return;
    }
}
