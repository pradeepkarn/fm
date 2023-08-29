<?php
$v = API_V;
$method = $_SERVER['REQUEST_METHOD'];
if ($method != "POST") {
    $data['msg'] = "Only post method is allowed";
    $data['data'] = null;
    echo json_encode($data);
    die();
}

$jsondata = file_get_contents('php://input');

$req = json_decode($jsondata);

if (!isset($req->token)) {
    $data['msg'] = "Login token is required";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
$user = get_user_by_token($req->token);
if ($user) {
    $user = obj($user);
} else {
    $data['msg'] = "Invalid token";
    $data['data'] = null;
    echo json_encode($data);
    die();
}
if (!isset($req->token) || !isset($req->content_group) || !isset($req->mobile) || !isset($req->name) || !isset($req->message)) {
    $data['msg'] = "All fields are mandatory";
    $data['data'] = null;
    echo json_encode($data);
    die();
} else {

    $comp_exists = row_xists('content', ['id' => $req->company_id, 'content_group' => 'company']);
    $listing_exists = row_xists('content', ['id' => $req->listing_id, 'content_group' => $req->content_group]);


    if (!$comp_exists) {
        $data['msg'] = "Company does not exists";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    if (!$listing_exists) {
        $data['msg'] = "Listing does not exists";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    $listing = obj(getData('content',  $req->listing_id));
    if ($listing->company_id!=$req->company_id) {
        $data['msg'] = "Listing does not match to its comapny";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
    $enqObj = new Dbobjects;
    $enqObj->tableName = "contact";
    $enqObj->insertData['name'] = $req->name;
    $enqObj->insertData['subject'] = isset($req->subject) ? $req->subject : null;
    $enqObj->insertData['message'] = $req->message;
    $enqObj->insertData['email'] = $user->email;
    $enqObj->insertData['mobile'] = $req->mobile;
    $enqObj->insertData['obj_id'] = isset($req->listing_id) ? $req->listing_id : 0;
    $enqObj->insertData['obj_group'] = $req->content_group;
    $enqObj->insertData['obj_owner'] = $req->company_id;
    $eqnId = $enqObj->create();
    if (intval($eqnId)) {
        $data['msg'] = "success";
        $data['data'] = array(
            'enquiry_id' => $eqnId
        );
        echo json_encode($data);
        die();
    } else {
        $data['msg'] = "Enquiry not sent";
        $data['data'] = null;
        echo json_encode($data);
        die();
    }
}
