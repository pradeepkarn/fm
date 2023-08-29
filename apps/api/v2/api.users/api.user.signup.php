<?php

$v = API_V;
import("apps/api/$v/api.users/fn.users.php");

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    // $req = json_decode(file_get_contents('php://input'));
    $req = obj($_POST);
    if (isset($_FILES)) {
        $files = obj($_FILES);
    }
} elseif ($method === 'GET') {
    $res['msg'] = "Get method is not allowed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
if (
    isset($req->first_name) && isset($req->last_name)
    && isset($req->mobile) && isset($req->email)
    && isset($req->password) && (isset($req->national_id) && isset($req->user_group))
) {
    if (!intval($req->mobile)) {
        $res['msg'] = "Mobile number must be numeric";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $paramObj = new stdClass;
    if (!email_has_valid_dns($req->email)) {
        $res['msg'] = "Please provide a live email";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $db = new Dbobjects;
    $pdo = $db->dbpdo();
    $pdo->beginTransaction();
    $db->tableName = 'pk_user';
    if ($db->filter(['email' => $req->email])) {
        $res['msg'] = "This email is already registered, please provide other email";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $username = generate_username_by_email_trans($req->email, $try = 100, $db = $db);
    if ($username == false) {
        $res['msg'] = "please check email format";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    if ($db->filter(['mobile' => $req->mobile])) {
        $res['msg'] = "This number is already registered, please provide other number";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    if (empty(str_replace(" ", "", $req->password))) {
        $res['msg'] = "Password must not be blank.";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $ugarr = ['user','driver'];
    $paramObj->mobile = intval($req->mobile);
    $paramObj->email = $req->email;
    $paramObj->username = $username;
    $paramObj->national_id = $req->national_id;
    $paramObj->password = md5($req->password);
    $paramObj->name = $req->first_name . " " . $req->last_name;
    $paramObj->first_name = $req->first_name;
    $paramObj->last_name = $req->last_name;
    $paramObj->user_group = in_array($req->user_group,$ugarr)?$req->user_group:'user';
    $paramObj->company = isset($req->company_name)?$req->company_name:null;
    $paramObj->company_details = isset($req->company_details)?$req->company_details:null;
    $paramObj->company_cr = isset($req->company_cr)?$req->company_cr:null;
    $paramObj->company_vat = isset($req->company_vat)?$req->company_vat:null;
    $paramObj->driver_id = isset($req->driver_id)?$req->driver_id:null;
    $paramObj->is_company = isset($req->is_company)?$req->is_company:0;

    $db->tableName = 'pk_user';
    $db->insertData = arr($paramObj);
    try {
        $id = $db->create();
        $user =  return_user_data_trans($id,$db);
        if (intval($id)) {
            // Uploads
            if (isset($files->profile_img)) {
                $imgfl = obj($files->profile_img);
                if ($imgfl->error == 0) {
                    $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                    $imgname = uniqid('profile_') ."_". $id . "." . $ext;
                    move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "images/profiles/$imgname");
                    $db->insertData['image'] = $imgname;
                }
            }
            if (isset($files->comp_vat_doc)) {
                $imgfl = obj($files->comp_vat_doc);
                if ($imgfl->error == 0) {
                    $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                    $docs = uniqid('comp_vat_doc_') ."_". $id . "." . $ext;
                    move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "docs/$docs");
                    $db->insertData['comp_vat_doc'] = $docs;
                }
            }
            if (isset($files->national_id_doc)) {
                $imgfl = obj($files->national_id_doc);
                if ($imgfl->error == 0) {
                    $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                    $docs = uniqid('national_id_doc_') ."_". $id . "." . $ext;
                    move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "docs/$docs");
                    $db->insertData['national_id_doc'] = $docs;
                }
            }
            if (isset($files->comp_cr_doc)) {
                $imgfl = obj($files->comp_cr_doc);
                if ($imgfl->error == 0) {
                    $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                    $docs = uniqid('comp_cr_doc_') ."_". $id . "." . $ext;
                    move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "docs/$docs");
                    $db->insertData['comp_cr_doc'] = $docs;
                }
            }
            if (isset($files->driver_doc)) {
                $imgfl = obj($files->driver_doc);
                if ($imgfl->error == 0) {
                    $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                    $docs = uniqid('driver_doc_') ."_". $id . "." . $ext;
                    move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "docs/$docs");
                    $db->insertData['driver_doc'] = $docs;
                }
            }
            // uploads end
            $db->tableName = 'pk_user';
            $user = $db->pk($id);
            $token = uniqid() . bin2hex(random_bytes(8)) . "u" . $id;
            $datetime = date('Y-m-d H:i:s');
            $db->insertData['app_login_token'] = $token;
            $db->insertData['app_login_time'] = $datetime;
            $db->update();
            $res['msg'] = "succcess";
            $res['data'] =  return_user_data_trans($id, $db);
            echo json_encode($res);
            $pdo->commit();
            die();
        } else {
            $pdo->rollback();
            $res['msg'] = "User not created, something went wrong";
            $res['data'] = null;
            echo json_encode($res);
            die();
        }
    } catch (PDOException $th) {
        $pdo->rollback();
        $res['msg'] = "Data error";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
} else {
    $res['msg'] = "All fields (First name, Last name, Mobile, Email, Password and National Id, user group) are mandatory";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
