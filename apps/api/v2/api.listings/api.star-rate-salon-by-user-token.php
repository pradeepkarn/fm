<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
import("apps/api/$v/api.listings/fn.relprods.php");
if ($method === 'POST') {
    $req = json_decode(file_get_contents('php://input'));
    if (isset($req->salon_id) && isset($req->rating_point)) {
        $rating_point = abs($req->rating_point);
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
            $message = null;
            if (isset($req->message)) {
                $message = $req->message;
            }
            $salon = rate_this_content($content_id = $id, $token = $token,$rating_point,$message);
            if ($salon == 'rated') {
                $data['msg'] = "success";
                $data['data'] = [];
                echo json_encode($data);
                return;
            } else if ($salon == 'unliked') {
                $data['msg'] = "removed";
                $data['data'] = null;
                echo json_encode($data);
                return;
            } else if($salon == "Only 1 to 5 integer value is allowed") {
                $data['msg'] = "Only 1 to 5 integer value is allowed";
                $data['data'] = null;
                echo json_encode($data);
                return;
            } else{
                $data['msg'] = "Not rated";
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
