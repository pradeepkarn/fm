<?php 
function login(){
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $account = new Account();
        $user = $account->login($_POST['email'],$_POST['password']);
        if ($user != false) {
            $cookie_name = "remember_token";
            $cookie_value = bin2hex(random_bytes(32))."_uid_".$user['id'];
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); // 86400 = 1 day
            $db = new Mydb('pk_user');
            $db->pk($_SESSION['user_id']);
            $arr = null;
            $arr['remember_token'] = $cookie_value;
            $db->updateData($arr);
            $arr = null;
            // $GLOBALS['msg_signin'][] = "Login Success";
            $_SESSION['msg'][] = "Login Success";
            return $user;
        }
        else{
            // $GLOBALS['msg_signin'][] = "Invalid credentials";
            $_SESSION['msg'][] = "Invalid credentials";
            return false;
        }
    }
    
}
function register(){
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cnfpassword'])) {
        if ($_POST['password'] === $_POST['cnfpassword']) {
            $account = new Account();
            $user = $account->register($_POST['email'],$_POST['password']);
            if ($user != false) {
                $cookie_name = "remember_token";
                $cookie_value = bin2hex(random_bytes(32))."_uid_".$user['id'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); // 86400 = 1 day
                $db = new Mydb('pk_user');
                $db->pk($_SESSION['user_id']);
                $arr = null;
                $arr['remember_token'] = $cookie_value;
                $db->updateData($arr);
                $arr = null;
                return $user;
            }
            else{
                $GLOBALS['msg_signup'][] = "Sorry something went wrong";
                return false;
            }
        }
        else{
            $GLOBALS['msg_signup'][] = "Sorry, Password did not match";
            return false;
        }
        
    }
    
}
function authenticate(){
    $account = new Account();
    return $account->authenticate();
}

function is_superuser(){
    $account = new Account();
    return $account->is_superuser();
}


function msg($var='msg')
{
    if(isset($GLOBALS[$var])){
        foreach ($GLOBALS[$var] as $msg) {
            echo "{$msg}<br>";
        }
    }
}


