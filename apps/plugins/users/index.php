<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "users";
$home = home;

import("apps/plugins/{$plugin_dir}/rv-fn.php");

if ("{$url[0]}/{$url[1]}" == "admin/{$plugin_dir}") {
    if (!isset($url[2])) {
        import("apps/plugins/{$plugin_dir}/item-list.php");
        return;
    }
    if (count($url) >= 3) {
        if ($url[2] == 'add-new-item') {
            import("apps/plugins/{$plugin_dir}/item-add.php");
            return;
        }
        if ($url[2] == 'edit-item') {
            import("apps/plugins/{$plugin_dir}/item-edit.php");
            return;
        }
        if ($url[2] == 'list') {
            import("apps/plugins/{$plugin_dir}/item-list.php");
            return;
        }
        if ($url[2] == 'add-user-ajax') {
            if (USER['user_group']!='admin') {
                msg_set('You are not authorised for this');
                echo js_alert(msg_ssn(return:true));
                exit;
            }
            $act = new Ac_user_ctrl;
            
            if($act->register()){
                echo RELOAD;
            }
            return;
        }
        if ($url[2] == 'update-user-ajax') {
            if (USER['user_group']!='admin') {
                msg_set('You are not authorised for this');
                echo js_alert(msg_ssn(return:true));
                exit;
            }
            $act = new Ac_user_ctrl;
            if($act->update()){
                // echo RELOAD;
            }
            return;
        }
    }
}
