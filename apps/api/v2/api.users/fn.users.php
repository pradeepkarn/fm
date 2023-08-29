<?php
function login_my_user_account($obj)
{
    $userObj = new Model('pk_user');
    $arr['email'] = $obj->credit;
    $arr['password'] = md5($obj->password);
    $user_arr = $userObj->filter_index($arr);
    if (count($user_arr) == 0) {
        $arrmob['mobile'] = $obj->credit;
        $arrmob['password'] = md5($obj->password);
        $user_arr = $userObj->filter_index($arrmob);
    }
    if (count($user_arr) == 0) {
        $arrunme['username'] = $obj->credit;
        $arrunme['password'] = md5($obj->password);
        $user_arr = $userObj->filter_index($arrunme);
    }
    if (count($user_arr) > 0) {
        $user = $user_arr[0];
        if ($user['app_login_time'] == null) {
            update_token($user['id']);
        } else {
            if ($user['app_login_token'] == null) {
                update_token($userid = $user['id']);
            } else {
                refresh_token_after_minute($userid = $user['id'], $app_login_time = $user['app_login_time'], $after_mnute = 120);
            }
        }
        return return_user_data_trans($user['id'],new Dbobjects);
    } else {
        return false;
    }
}

function update_token($userid)
{
    $token = uniqid() . bin2hex(random_bytes(8)) . "u" . $userid;
    $datetime = date('Y-m-d H:i:s');
    (new Model('pk_user'))->update($userid, array('app_login_token' => $token, 'app_login_time' => $datetime));
}

function refresh_token_after_minute($userid, $app_login_time, $after_mnute)
{
    $after_second = $after_mnute * 60;
    $app_login_time = strtotime($app_login_time);
    $time_out = $after_second + $app_login_time;
    $current_time = strtotime(date('Y-m-d H:i:s'));
    if ($current_time > $time_out) {
        $token = uniqid() . bin2hex(random_bytes(8)) . "u" . $userid;
        $datetime = date('Y-m-d H:i:s');
        (new Model('pk_user'))->update($userid, array('app_login_token' => $token, 'app_login_time' => $datetime));
    }
}


function create_my_user_account($obj)
{
    // myprint($obj);
    $data = new stdClass;
    $userObj = new Model('pk_user');
    $arr['email'] = $obj->email;
    $user_arr = $userObj->filter_index(['email'=>$obj->email]);
    if (count($user_arr) > 0) {
        $data->success = false;
        $data->msg = "Email is already registered";
        $data->res = null;
        return $data;
    }
    $arr['mobile'] = $obj->mobile;
    $user_arr = $userObj->filter_index(['mobile'=>$obj->mobile]);
    if (count($user_arr) > 0) {
        $data->success = false;
        $data->msg = "Mobile is already registered";
        $data->res = null;
        return $data;
    }
    if ($obj->password == "" || $obj->confirm_password == "") {
        $data->success = false;
        $data->msg = "Password must not be empty";
        $data->res = null;
        return $data;
    }
    if ($obj->password != $obj->confirm_password) {
        $data->success = false;
        $data->msg = "Password did not match";
        $data->res = null;
        return $data;
    }
    $arr['mobile'] = $obj->mobile;
    $arr['name'] = $obj->name;
    $arr['first_name'] = $obj->first_name;
    $arr['last_name'] = $obj->last_name;
    $arr['password'] = md5($obj->password);
    $arr['user_group'] = "customer";
    $user_reg = $userObj->store($arr);
    if ($user_reg != false && intval($user_reg)) {
        $newuserObj = new Model('pk_user');
        $user = $newuserObj->show($user_reg);
        if ($user != false) {
            $ru = new stdClass;
            update_token($user['id']);
            $data->success = true;
            $data->msg = "Signup success";
            $data->res = return_user_data($user['id']);
            return $data;
        }
    } else {
        $data->success = false;
        $data->msg = "User not created";
        $data->res = null;
        return $data;
    }
}

function return_user_data($id) {
    $ru = new stdClass;
    $u = obj(getData('pk_user',$id));
    $ru->id = $u->id;
    $ru->first_name = $u->first_name;
    $ru->last_name = $u->last_name;
    $ru->mobile = intval($u->mobile);
    $ru->email = $u->email;
    $ru->gender = $u->gender;
    $ru->dob = $u->dob;
    $ru->image = ($u->image!='') ? '/media/images/profiles/'.$u->image : null;
    $ru->token = $u->app_login_token;
    return $ru;
}

function return_user_data_trans($id,$db) {
    $ru = new stdClass;
    $db->tableName = 'pk_user';
    $user = $db->pk($id);
    $u = obj($user);
    $ru->id = $u->id;
    $ru->first_name = $u->first_name;
    $ru->last_name = $u->last_name;
    $ru->mobile = intval($u->mobile);
    $ru->email = $u->email;
    $ru->user_group = $u->user_group;
    $ru->national_id = $u->national_id;
    $ru->driver_id = $u->driver_id;
    $ru->company_name = $u->company;
    $ru->company_details = $u->company_details;
    $ru->company_cr = $u->company_cr;
    $ru->company_vat = $u->company_vat;
    $ru->national_id = $u->national_id;
    $ru->is_company = $u->is_company;
    // $ru->dob = date('Y-m-d H:i:s',strtotime($u->dob));
    $ru->image = ($u->image!='') ? '/media/images/profiles/'.$u->image : null;
    $ru->token = $u->app_login_token;
    return $ru;
}