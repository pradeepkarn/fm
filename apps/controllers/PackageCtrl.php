<?php
class PackageCtrl{
    private $dbTableObj;
    public function __construct()
    {
        $this->dbTableObj = new Model('pk_user');
    }
    public function buy_package_for_logged_in()
    {

        if (isset($_POST['buy_pkg_id'])) {
                    if (authenticate()==false) {
                        $_SESSION['msg'][] = "You are not logged in";
                        return;
                    }
                    $account = new Account();
                    $user = $account->getLoggedInAccount();
                    if ($user==false) {
                        $_SESSION['msg'][] = "Invalid credential";
                        return;
                    }
                    if ((new Model('content'))->filter_index(array('content_group'=>'package','id'=>$_POST['buy_pkg_id']))==false) {
                        $_SESSION['msg'][] = "Invalid Pacakge";
                        return;
                    }
                    $pkg = getData('content',$_POST['buy_pkg_id']);
                    $arr = null;
                    $arr['user_group'] = strtolower(sanitize_remove_tags($pkg['post_category']));
                    if ($arr['user_group']=="") {
                        $_SESSION['msg'][] = "Package category not defined";
                        return;
                    }
                    $arr['role'] = 'premium';
                    $arr['access_level'] = 5;
                    //if evrything valid then
                    $usr = new Model('pk_user');
                    return $usr->update($user['id'],$arr);
                    }
                    else{
                        $_SESSION['msg'][] = "Missing required field";
                        return;
                    }
    }
    public function activate_pkg_after_payment($pkg_id)
    {

                if (filter_var($pkg_id,FILTER_VALIDATE_INT)) {
                    if (authenticate()==false) {
                        $_SESSION['msg'][] = "You are not logged in";
                        return;
                    }
                    $account = new Account();
                    $user = $account->getLoggedInAccount();
                    if ($user==false) {
                        $_SESSION['msg'][] = "Invalid credential";
                        return;
                    }
                    if ((new Model('content'))->filter_index(array('content_group'=>'package','id'=>$pkg_id))==false) {
                        $_SESSION['msg'][] = "Invalid Pacakge";
                        return;
                    }
                    $pkg = getData('content',$pkg_id);
                    $arr = null;
                    $arr['user_group'] = strtolower(sanitize_remove_tags($pkg['post_category']));
                    if ($arr['user_group']=="") {
                        $_SESSION['msg'][] = "Package category not defined";
                        return;
                    }
                    $arr['role'] = 'premium';
                    $arr['access_level'] = 5;
                    //if evrything valid then
                    $usr = new Model('pk_user');
                    return $usr->update($user['id'],$arr);
                    }
                    else{
                        $_SESSION['msg'][] = "Missing required field";
                        return;
                    }
    }
    public function buyNowPkg()
    {

        if (isset($_POST['buy_pkg']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cnf_password'])) {
                
                    if(($_POST['buy_pkg'])==""){
                        $_SESSION['msg'][] = "Select a package first";
                        return;
                    }
                    $arr['user_group'] = strtolower(sanitize_remove_tags($_POST['buy_pkg']));
                    $arr['role'] = 'premium';
                    $arr['access_level'] = 5;
                  
          
                    $email = sanitize_remove_tags($_POST['email']);
                    $password = sanitize_remove_tags($_POST['password']);
                    $cnf_password = sanitize_remove_tags($_POST['cnf_password']);
                
                    
                    $arr['email'] = $email;
                    $arr['password'] = md5($password);
                    //name
                    if (isset($_POST['name'])) {
                        if(strlen(sanitize_remove_tags($_POST['name']))<2){
                            $_SESSION['msg'][] = "Invalid Name";
                            return;
                        }
                        $arr['name'] = sanitize_remove_tags($_POST['name']);
                        }
                         //email
                    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)==false){
                        $_SESSION['msg'][] = "Invalid email";
                        return;
                    }
                    //check regtered email
                    $user_by_email = (new Model('pk_user'))->exists(['email'=>$email]);
                    if ($user_by_email!=false) {
                        $_SESSION['msg'][] = "Email is not available";
                        return;
                    }
                        //mobile
                        if (isset($_POST['mobile'])) {
                        if(filter_var($_POST['mobile'],FILTER_VALIDATE_INT)==false){
                            $_SESSION['msg'][] = "Invalid mobile";
                            return;
                        }
                        $user_by_mobile = (new Model('pk_user'))->exists(['mobile'=>$_POST['mobile']]);
                        if ($user_by_mobile!=false) {
                            $_SESSION['msg'][] = "Mobile is not available";
                            return;
                        }
                        $arr['mobile'] = sanitize_remove_tags($_POST['mobile']);
                        }
                        //national id number
                        // if (isset($_POST['national_id'])) {
                        //     if($_POST['national_id']==""){
                        //         $_SESSION['msg'][] = "Empty National Id Number";
                        //         return;
                        //     }
                        //     $user_by_national_id = (new Model('pk_user'))->exists(['national_id'=>$_POST['national_id']]);
                        //     if ($user_by_national_id!=false) {
                        //         $_SESSION['msg'][] = "Your National Id is already regsitered";
                        //         return;
                        //     }
                        // $arr['national_id'] = sanitize_remove_tags($_POST['national_id']);
                        // }
                        //username
                        $arr['username'] = strtolower(generate_username_by_email($email,$try=500));
                    // if (isset($_POST['username'])) {
                    //     $username = str_replace(" ","",sanitize_remove_tags($_POST['username']));
                    //     $arr['username'] = $username;
                    //     if ((strlen($username)<3) || (strlen($username)>16)) {
                    //         $_SESSION['msg'][] = "Username must be between 3 to 16 characters";
                    //         return;
                    //     }
                    //     //check regtered username
                    //     $user_by_username = (new Model('pk_user'))->exists(['username'=>$username]);
                    //     if ($user_by_username!=false) {
                    //         $_SESSION['msg'][] = "Username is not available";
                    //         return;
                    //     }
                    // }
                   
                       
                    
                    
                   
                    //empty pass
                    if (($_POST['password'])=="") {
                        $_SESSION['msg'][] = "Empty password is not allowed";
                        return;
                    }
                    //valid pass
                    if (($password!=$_POST['password'])) {
                        $_SESSION['msg'][] = "Invalid characters used in password";
                        return;
                    }
                    //pass match
                    if ($password!=$cnf_password) {
                        $_SESSION['msg'][] = "Password did not match";
                        return;
                    }
                        //if evrything valid then
                        $dbcreate = new Model('pk_user');
                        try {
                          $home = home;
                            $userid = $dbcreate->store($arr);
                            if ($userid<=0) {
                              $_SESSION['msg'][] = "User not created!";
                              return;
                              }
                            else{
                              $msg['created_user_id'] = "$userid";
                              $_SESSION['msg'][] = "Congartulation you have successfully purchaged <b> {$arr['user_group']} </b> membership";
                              if (isset($email) && isset($password)) {
                                $account = new Account();
                                $user = $account->login($email,$password);
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
                                    echo js("location.href='/$home/vendor';");
                                    $arr = null;
                                    return;
                                }
                                else{
                                  echo js("location.href='/$home';");
                                }
                                
                              }
                              
                            }
                        } catch (\Throwable $th) {
                          
                        }
                    }
                    else{
                        $_SESSION['msg'][] = "Missing required field";
                        return;
                    }
        }
    }


