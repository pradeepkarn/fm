<?php
$v = API_V;
import("apps/api/$v/api.users/fn.users.php");
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $req_data = (object) $_POST;
    $req_files = isset($_FILES) ? (object) $_FILES : false;
    // Do something with the data
} elseif ($method === 'GET') {
    $res['msg'] = "Get method is not allowed";
    $res['data'] = null;
    echo json_encode($res);
    die();
}

if (isset($req_data->token)) {
    $user = get_user_by_token($req_data->token);
    if ($user == false) {
        $res['msg'] = "login failed";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
} else {
    $res['msg'] = "Token is required";
    $res['data'] = null;
    echo json_encode($res);
    die();
}
$user = obj($user);
$emlarr = explode("@", $user->email);
$emldmn = end($emlarr);
$arr = null;
$arr['first_name'] = isset($req_data->first_name) ? $req_data->first_name : $user->first_name;
$arr['last_name'] = isset($req_data->last_name) ? $req_data->last_name : $user->last_name;
if (($emldmn == "example.com" || $emldmn == "" || $emldmn == null) && isset($req_data->email)) {
    if (!email_has_valid_dns($req_data->email)) {
        $res['msg'] = "Invalid email, please do not provide dummy email";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
    $emlsusr = (new Model('pk_user'))->filter_index(['email' => $req_data->email]);
    if (count($emlsusr) > 0) {
        if ($emlsusr[0]['id'] != $user->id) {
            $res['msg'] = "Email is already registered";
            $res['data'] = null;
            echo json_encode($res);
            die();
        } else {
            $arr['email'] = $req_data->email;
        }
    } else {
        $arr['email'] = $req_data->email;
    }
}
$genderarr = ["m", "f", "o"];
if (isset($req_data->gender)) {
    if (in_array($req_data->gender, $genderarr)) {
        $arr['gender'] = isset($req_data->gender) ? $req_data->gender : $user->gender;
    }
}
if (isset($req_data->dob)) {
    $arr['dob'] = isset($req_data->dob) ? $req_data->dob : $user->dob;
}
if (isset($req_data->mobile)) {
    $mblusr = (new Model('pk_user'))->filter_index(['mobile' => $req_data->mobile]);
    if (count($mblusr) > 0) {
        if ($mblusr[0]['id'] != $user->id) {
            $res['msg'] = "Mobile is already registered";
            $res['data'] = null;
            echo json_encode($res);
            die();
        }
    } else {
        $arr['mobile'] = $req_data->mobile;
    }
}


$img = isset($req_files->image) ? (object)$req_files->image : false;

if ($img) {
    if ($img->name != null && $img->error == 0) {
        $dir = MEDIA_ROOT . "images/profiles/";
        $ext        = pathinfo($img->name, PATHINFO_EXTENSION);
        $file       = uniqid("dp{$user->id}u") . "." . $ext;
        $upload = move_uploaded_file($img->tmp_name, $dir . $file);
        if ($upload == true) {
            $arr['image'] = $file;
            if (file_exists($dir . $user->image)) {
                if ($user->image != null) {
                    unlink($dir . $user->image);
                }
            }
        }
    }
}

(new Model('pk_user'))->update($user->id, $arr);
$arr = null;



// $base64string = base64_decode($req->image);
// $uploadpath   = MEDIA_ROOT. "images/profiles/";
// $parts        = explode(";base64,", $base64string);
// $imageparts   = explode("image/", @$parts[0]);
// $imagetype    = $imageparts[1];
// $imagebase64  = base64_decode($parts[1]);
// $file         = $uploadpath . uniqid() . '.png';
// file_put_contents($file, $imagebase64);

if (isset($req_data->token)) {
    $user = get_user_by_token($req_data->token);
    if ($user != false) {
        $userobj = new stdClass;
        $user = (object) $user;
        // $userobj->id = $user->id;
        // $userobj->first_name = $user->first_name;
        // $userobj->last_name = $user->last_name;
        // $userobj->mobile = intval($user->mobile);
        // $userobj->email = $user->email;
        // $userobj->dob = $user->dob;
        // $userobj->gender = $user->gender;
        // $userobj->image = ($user->image!='') ? '/media/images/profiles/'.$user->image : null;

        $userobj = return_user_data($user->id);
        $res['msg'] = "success";
        $res['data'] = $userobj;
        echo json_encode($res);
        die();
    } else {
        $res['msg'] = "login failed";
        $res['data'] = null;
        echo json_encode($res);
        die();
    }
}
