<?php
class UserSignCtrl{
    private $dbTableObj;
    public function __construct()
    {
        $this->dbTableObj = new Model('pk_user');
    }

    public function sign_up()
    {

        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cnf_password'])) {
                
                    $arr['user_group'] = "subscriber";
                    $arr['role'] = 'subscriber';
                    $arr['access_level'] = 10;
                    $email = sanitize_remove_tags($_POST['email']);
                    $password = sanitize_remove_tags($_POST['password']);
                    $cnf_password = sanitize_remove_tags($_POST['cnf_password']);
                    $arr['email'] = $email;
                    $arr['password'] = md5($password);
                    //name
                    if (isset($_POST['first_name'])) {
                        if(strlen(sanitize_remove_tags($_POST['first_name']))<2){
                            $_SESSION['msg'][] = "Invalid Name";
                            return;
                        }
                        $arr['first_name'] = sanitize_remove_tags($_POST['first_name']);
                    }
                    if (isset($_POST['last_name'])) {
                        if(strlen(sanitize_remove_tags($_POST['last_name']))<2){
                            $_SESSION['msg'][] = "Invalid Name";
                            return;
                        }
                        $arr['last_name'] = sanitize_remove_tags($_POST['last_name']);
                    }
                    if (isset($_POST['gender'])) {
                        if(strlen(sanitize_remove_tags($_POST['gender']))!=1){
                            $_SESSION['msg'][] = "Invalid Gender";
                            return;
                        }
                        $arr['gender'] = sanitize_remove_tags($_POST['gender']);
                    }
                    if (isset($_POST['country'])) {
                        if(strlen(sanitize_remove_tags($_POST['country']))<2){
                            $_SESSION['msg'][] = "Invalid Country Name";
                            return;
                        }
                        $arr['country'] = sanitize_remove_tags($_POST['country']);
                    }
                    if (isset($_POST['gender'])) {
                        if(strlen(sanitize_remove_tags($_POST['gender']))!=1){
                            $_SESSION['msg'][] = "Invalid Gender Value";
                            return;
                        }
                        $arr['gender'] = sanitize_remove_tags($_POST['gender']);
                    }
                         // national id number
                    // if (isset($_POST['national_id'])) {
                    // if($_POST['national_id']==""){
                    //     $_SESSION['msg'][] = "Empty National Id Number";
                    //     return;
                    // }
                    // if(filter_var($_POST['national_id'],FILTER_VALIDATE_INT)==false){
                    //     $_SESSION['msg'][] = "Invalid national id";
                    //     return;
                    // }
                    // if(strlen($_POST['national_id'])!=8){
                    //     $_SESSION['msg'][] = "Invalid national id, it should be of 8 digits";
                    //     return;
                    // }
                    // $arr['national_id'] = sanitize_remove_tags($_POST['national_id']);
                    // }
                    //image
                    // if (!isset($_FILES['image'])) {
                    //     $_SESSION['msg'][] = "please upload id card";
                    //     return;
                    // }
                    // if (empty($_FILES['image']['name'])) {
                    //     $_SESSION['msg'][] = "Please upload id card";
                    //     return;
                    // }
                    // $fl = $_FILES['image'];
                    // $file_type = mime_content_type($fl['tmp_name']);
                    // if (($file_type =="image/png" || $file_type =="image/jpg" || $file_type =="image/jpeg")!=true) {
                    //     $_SESSION['msg'][] = "please select valid file, you selected an invalid file [$file_type], please select jpg or png";
                    //     return;
                    // }
                   
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
                     // zip code id number
                     if (isset($_POST['zipcode'])) {
                        if($_POST['zipcode']==""){
                            $_SESSION['msg'][] = "Please enter your zip code";
                            return;
                        }
                        // if(strlen($_POST['zipcode'])!=11){
                        //     $_SESSION['msg'][] = "Invalid zip code, it should be of 11 digits alpha numeric";
                        //     return;
                        // }
                        else{
                            $arr['zipcode'] = sanitize_remove_tags($_POST['zipcode']);
                        }
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
                       
                        //username
                        
                    // if (isset($_POST['username'])) {
                    //     $username = strtolower(str_replace(" ","",sanitize_remove_tags($_POST['username'])));
                    //     $arr['username'] = $username;
                    //     if ((strlen($username)!=0)) {
                    //         if ((strlen($username)<3) || (strlen($username)>16)) {
                    //             $_SESSION['msg'][] = "Username must be between 3 to 16 characters";
                    //             return;
                    //         }
                    //     }
                    //     elseif ((strlen($username)==0)) {
                    //         $username = strtolower(generate_username_by_email($email,$try=5000));
                    //     }
                    //     //check regtered username
                    //     $user_by_username = (new Model('pk_user'))->exists(['username'=>$username]);
                    //     if ($user_by_username!=false) {
                    //         $_SESSION['msg'][] = "Username is not available";
                    //         return;
                    //     }
                    // }
                    // else{
                    //     $arr['username'] = strtolower(generate_username_by_email($email,$try=5000));
                    // }
                    $arr['username'] = strtolower(generate_username_by_email($email,$try=50000));
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
                                $id = $userid;
                                $user = (new Model('pk_user'))->show($userid);
                                // if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                                //     $fl = $_FILES['image'];
                                //     $file_with_ext = $fl['name'];
                                //     $file_type = mime_content_type($fl['tmp_name']);
                                //     $only_file_name = filter_name($file_with_ext);
                                //     $only_file_name =  "photo_id_".$only_file_name."_{$id}_{$user['username']}_".random_int(1000,9999);
                                //     $target_dir = RPATH ."/media/images/ids/";
                                //     $file_ext_arr = explode(".",$file_with_ext);
                                //     $ext = end($file_ext_arr);
                                //     $target_file = $target_dir ."{$only_file_name}.".$ext;
                                //     if ($file_type =="image/png" || $file_type =="image/jpg" || $file_type =="image/jpeg") {
                                //         if (move_uploaded_file($fl['tmp_name'], $target_file)) {
                                //             $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
                                //             $filename = $only_file_name.".".$ext;
                                //             $arr = null;
                                //             $arr['photo_id'] = $filename;
                                //             if($user['image']!=""){
                                //                 if(file_exists($target_dir."/".$user['image'])){
                                //                     unlink($target_dir."/".$user['image']);
                                //                 }
                                //             }
                                            
                                //           }
                                //     }
                                   
                                // }
                              $msg['created_user_id'] = $userid;
                              $_SESSION['msg'][] = "Congartulation you have successfully registered";
                              if (isset($email) && isset($password)) {
                                $account = new Account();
                                $user = $account->login($email,$password);
                                if ($user != false) {
                                    $cookie_name = "remember_token";
                                    $cookie_value = bin2hex(random_bytes(32))."_uid_".$user['id'];
                                    setcookie($cookie_name, $cookie_value, time() + (86400 * 30*12), "/"); // 86400 = 1 day
                                    $db = new Mydb('pk_user');
                                    $db->pk($_SESSION['user_id']);
                                    $arr['remember_token'] = $cookie_value;
                                    $db->updateData($arr);
                                    $arr = null;
                                    echo js("location.href='/$home';");
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


