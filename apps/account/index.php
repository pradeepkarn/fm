<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
if ($url[0] == "account") {
switch ($path) {
    case 'account':
        if (authenticate() === false) {
            header("Location:/".home."/account/login");
        }
        import("apps/account/dashboard.php");
        break;
    case "account/login":
        if (isset($_POST['login_my_account'])) {
            login();
        }
        if (authenticate() === true) {
            if ((new Account)->getLoggedInAccount()['role']=="superuser") {
                header("Location:/".home."/admin");
            }
            else{
                header("Location:/".home."/vendor");
            }
            
        }
        import("apps/account/login.php");
        break;
    case "account/register":
        if (isset($_POST['create_new_account'])) {
            register();
            //echo "<script>alert('Registration Success!');</script>";
        }
        if (authenticate() === true) {
            header("Location:/".home);
        }
        import("apps/account/register.php");
        break;
    case "account/password-reset":
        if (authenticate() === true) {
            header("Location:/".home);
        }
        if (isset($_POST['reset_my_account_pass'])) {
            $db = new Mydb('pk_user');
            $checkemail = $db->filterData(['email'=>$_POST['email']]);
            if (count($checkemail)>0) {
                $home = home;
                $token = bin2hex(random_bytes(32));
                $to      = $_POST['email'];
                $subject = 'Password reset';
                $message = "Go to reset password: <a href='/{$home}/account/reset-account/?token={$token}&email={$_POST['email']}'>Reset</a>";
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '.email. "\r\n"; 
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                if(mail($to, $subject, $message, $headers)) {
                    $arr= null;
                    $arr['remember_token'] = $token;
                    $db->updateData($arr);
                    $GLOBALS['msg_signin'][]="A password reset link sent to your registered email: {$_POST['email']}, please check in spam folder in case of not found in inbox.";
                } else {
                    $GLOBALS['msg_signin'][]="Failure: Email was not sent!";
                }
            }
            else{
                $GLOBALS['msg_signin'][]="Wrong Email";
            }
        }
        import("apps/account/password-reset.php");
        break;
    case "account/logout":
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
        setcookie("remember_token", "", time() - (86400 * 30*12), "/"); // 86400 = 1 day
        header("Location:/".home);
        break;
  default:
        if ($url[1]=="reset-account") {

            import("apps/account/reset-account.php");
            return;
        }
        if ($url[1]=="popup-login") {
            if (isset($_POST['login_my_account'])) {
                if(login()!=false){
                    echo js("location.reload();");
                }
                else{
                    echo js_alert("Invalid input");
                }
            }
            return;
        }
          import("apps/view/404.php");
          break;
    }
}
