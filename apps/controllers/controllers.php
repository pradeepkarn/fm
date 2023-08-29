<?php
class DocsCtrl
{
    private $dbTableObj;
    public function __construct()
    {
        $this->dbTableObj = new Model('pk_docs');
    }
    public function upload($csrf=false)
    {
        if ($csrf==true) {
            if(verify_csrf($_POST['csrf_token'],$refresh=true)==false){
                return false;
            }
         }
        if(isset($_FILES) && isset($_POST['object_group']) && isset($_POST['object_id'])){ 
            $user_id = $_SESSION['user_id']; 
            if (isset($_POST['user_id'])) {
                $user_id = $_POST['user_id'];
                $arr['user_id'] = $_POST['user_id'];
            } 
            if (isset($_POST['schedule_date'])) {
                $arr['schedule_date'] = $_POST['schedule_date'];
            }
            if (isset($_POST['expiry_date'])) {
                $arr['expiry_date'] = $_POST['expiry_date'];
            }  
            
                
            for ($i=0; $i < count($_FILES['docs']['name']); $i++) { 
                $obj_grp = $_POST['object_group'];
                $obj_id = $_POST['object_id'];
                $arr['obj_group'] = $_POST['object_group'];
                $arr['obj_id'] = $_POST['object_id'];
                $arr['status'] = "approved";
                $arr['details'] = $_POST['docs_name'][$i];

                $file_with_ext = $_FILES['docs']['name'][$i];
                if (!empty($_FILES['docs']['name'][$i])) {
                $only_file_name = filter_name($file_with_ext);
                $only_file_name =  $only_file_name."_{$obj_id}_{$obj_grp}_".random_int(100000,999999);
                 $target_dir = RPATH ."/media/docs/";
                 $file_ext_arr = explode(".",$file_with_ext);
                 $ext = end($file_ext_arr);
                 $target_file = $target_dir ."{$only_file_name}.".$ext;
                 
                 
                 if(($_FILES['docs']['type'][$i]=="application/pdf" || $_FILES['docs']['type'][$i]=="image/png" || $_FILES['docs']['type'][$i]=="image/jpeg" || $_FILES['docs']['type'][$i]=="image/jpg" || $_FILES['docs']['type'][$i]=="image/JPEG" || $_FILES['docs']['type'][$i]=="image/JPG" || $_FILES['docs']['type'][$i]=="video/mp4")){
                    if (move_uploaded_file($_FILES['docs']['tmp_name'][$i], $target_file)) {
                        $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
                        $filename = $only_file_name.".".$ext;
                        $arr['media_file'] = $filename;
                        $this->dbTableObj->store($arr);
                      }
                }
                else{
                    $_SESSION['msg'][] = "$file_with_ext is invalid file";
                    }
                }
            }
        }
    }

    // delete
  
    public function destroy($id,$file)
    {
        if (isset($id) && $id!="") {
            try {
                    $target_dir = RPATH ."/media/docs/{$file}";
                    if (file_exists($target_dir)) {
                        unlink($target_dir);
                    }
                $this->dbTableObj->destroy($id);
                return true;
            }catch (Exception $e) {
                return false;
            }
            
        }
        else{
            return false;
        }
    }
}

class UserCtrl{
    private $dbTableObj;
    public function __construct()
    {
        $this->dbTableObj = new Model('pk_user');
    }

    public function addUser($csrf=true)
    {

        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['password'])) {
                 $email_exists = $this->dbTableObj->exists(['email'=>$_POST['email']]);
                 $username_exists = $this->dbTableObj->exists(['username'=>$_POST['username']]);
                 $mobile_exists = $this->dbTableObj->exists(['mobile'=>$_POST['mobile']]);
                 $ugrplist = ['admin','subadmin','employee','whmanager'];
                 if (isset($_POST['user_group']) && in_array($_POST['user_group'],$ugrplist)) {
                    $arr['user_group'] = sanitize_remove_tags($_POST['user_group']);
                 }
                 if (isset($_POST['department'])) {
                    $arr['department'] = sanitize_remove_tags($_POST['department']);
                 }
                 else{
                    $arr['user_group'] = "employee";
                 }
                 if ($_POST['first_name']=="") {
                    $_SESSION['msg'][] = "Empty First name is not allowed";
                    return;
                  }
                  if ($_POST['last_name']=="") {
                    $_SESSION['msg'][] = "Empty First name is not allowed";
                    return;
                  }
                //   $arr['email'] = sanitize_remove_tags($_POST['email']);
                  $arr['first_name'] = sanitize_remove_tags($_POST['first_name']);
                  $arr['last_name'] = sanitize_remove_tags($_POST['last_name']);
                  $arr['mobile'] = sanitize_remove_tags($_POST['mobile']);
                  if ($_POST['email']=="") {
                    $arr['email'] = uniqid("dummy_email_")."@hrms.com";
                    echo $arr['email'];
                  }else{
                    $arr['email'] = sanitize_remove_tags($_POST['email']);
                  }

                  if ($_POST['username']=="") {
                    $arr['username'] = generate_username_by_email($arr['email']);
                  }else{
                    $arr['username'] = sanitize_remove_tags($_POST['username']);
                  }
                  if ($_POST['password']=="") {
                    $arr['password'] = md5(uniqid(rand(0,99999)).time());
                  }else{
                    $arr['password'] = md5($_POST['password']);
                  }
                  

                  if ($arr['first_name']=="") {
                    $_SESSION['msg'][] = "Empty name is not allowed";
                    return;
                  }
                  if (filter_var($arr['email'],FILTER_VALIDATE_EMAIL)!=true) {
                    $_SESSION['msg'][] = "Invalid Email";
                    return;
                  }
                  if (filter_var($_POST['mobile'],FILTER_VALIDATE_INT)!=true) {
                    $_SESSION['msg'][] = "Invalid Mobile";
                    return;
                  }
                  if ($email_exists!=false) {
                    $_SESSION['msg'][] = "This email is already exists";
                    return;
                  }
                  if (strlen($arr['username'])<3) {
                    $_SESSION['msg'][] = "Username must be greater than 2 digits";
                    return;
                  }
                  if (strlen($arr['password'])<5) {
                    $_SESSION['msg'][] = "Password must be greater than 4 digits";
                    return;
                  }
                  if ($username_exists!=false) {
                    $_SESSION['msg'][] = "This username is already exists";
                    return;
                  }
                  if ($mobile_exists!=false) {
                    $_SESSION['msg'][] = "This mobile is already exists";
                    return;
                  }
                  if ($csrf==true) {
                    if(verify_csrf($_POST['csrf_token'],$refresh=true)==false){
                        $_SESSION['msg'][] = "Invalid CSRF";
                        return false;
                    }
                 }
                    $userid = $this->dbTableObj->store($arr);
                  if(filter_var($userid,FILTER_VALIDATE_INT)==true){
                    $_SESSION['msg'][] = "User Created successfully";
                    return $userid;
                  }
                  else{
                    $_SESSION['msg'][] = "User not Created";
                    return false;
                  }
              }
    }
    public function add_employee()
    {
        if (isset($_POST['name']) && isset($_POST['city']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['password'])) {
                 $email_exists = $this->dbTableObj->exists(['email'=>$_POST['email']]);
                 $username_exists = $this->dbTableObj->exists(['username'=>$_POST['username']]);
                 $mobile_exists = $this->dbTableObj->exists(['mobile'=>$_POST['mobile']]);
                 $ugrplist = ['admin','subadmin','employee','whmanager'];
                 if (isset($_POST['user_group']) && in_array($_POST['user_group'],$ugrplist)) {
                    $arr['user_group'] = sanitize_remove_tags($_POST['user_group']);
                 }
                //  if (isset($_POST['department'])) {
                //     $arr['department'] = sanitize_remove_tags($_POST['department']);
                //  }
                 else{
                    $arr['user_group'] = "salesman";
                 }
                 if ($_POST['name']=="") {
                    $_SESSION['msg'][] = "Empty name is not allowed";
                    return;
                  }
                  if ($_POST['city']=="") {
                    $_SESSION['msg'][] = "Empty city name is not allowed";
                    return;
                  }
                //   $arr['email'] = sanitize_remove_tags($_POST['email']);
                  $arr['name'] = sanitize_remove_tags($_POST['name']);
                  $arr['city'] = sanitize_remove_tags($_POST['city']);
                  $arr['isd_code'] = sanitize_remove_tags($_POST['dial_code']);
                  $arr['mobile'] = sanitize_remove_tags($_POST['mobile']);
                  if ($_POST['email']=="") {
                    $arr['email'] = uniqid("dummy_email_")."@hrms.com";
                    echo $arr['email'];
                  }else{
                    $arr['email'] = sanitize_remove_tags($_POST['email']);
                  }

                  if ($_POST['username']=="") {
                    $arr['username'] = generate_username_by_email($arr['email']);
                  }else{
                    $arr['username'] = sanitize_remove_tags($_POST['username']);
                  }
                  if ($_POST['password']=="") {
                    $arr['password'] = md5(uniqid(rand(0,99999)).time());
                  }else{
                    $arr['password'] = md5($_POST['password']);
                  }
                  

                  if ($arr['name']=="") {
                    $_SESSION['msg'][] = "Empty name is not allowed";
                    return;
                  }
                  if (filter_var($arr['email'],FILTER_VALIDATE_EMAIL)!=true) {
                    $_SESSION['msg'][] = "Invalid Email";
                    return;
                  }
                  if (filter_var($_POST['mobile'],FILTER_VALIDATE_INT)!=true) {
                    $_SESSION['msg'][] = "Invalid Mobile";
                    return;
                  }
                  if ($email_exists!=false) {
                    $_SESSION['msg'][] = "This email is already exists";
                    return;
                  }
                  if (strlen($arr['username'])<3) {
                    $_SESSION['msg'][] = "Username must be greater than 2 digits";
                    return;
                  }
                  if (strlen($arr['password'])<5) {
                    $_SESSION['msg'][] = "Password must be greater than 4 digits";
                    return;
                  }
                  if ($username_exists!=false) {
                    $_SESSION['msg'][] = "This username is already exists";
                    return;
                  }
                  if ($mobile_exists!=false) {
                    $_SESSION['msg'][] = "This mobile is already exists";
                    return;
                  }
                //   if ($csrf==true) {
                //     if(verify_csrf($_POST['csrf_token'],$refresh=true)==false){
                //         $_SESSION['msg'][] = "Invalid CSRF";
                //         return false;
                //     }
                //  }
                    $userid = $this->dbTableObj->store($arr);
                  if(filter_var($userid,FILTER_VALIDATE_INT)==true){
                    $_SESSION['msg'][] = "User Created successfully";
                    return $userid;
                  }
                  else{
                    $_SESSION['msg'][] = "User not Created";
                    return false;
                  }
              }
    }
    public function add_user_by_group()
    {
        if (isset($_POST['name']) && isset($_POST['city']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['password'])) {
                 $email_exists = $this->dbTableObj->exists(['email'=>$_POST['email']]);
                 $username_exists = $this->dbTableObj->exists(['username'=>$_POST['username']]);
                 $mobile_exists = $this->dbTableObj->exists(['mobile'=>$_POST['mobile']]);
                 $ugrplist = ['vendor','customer'];
                 if (isset($_POST['user_group']) && in_array($_POST['user_group'],$ugrplist)) {
                    $arr['user_group'] = sanitize_remove_tags($_POST['user_group']);
                 }
                 else{
                    $arr['user_group'] = "customer";
                 }
                 if ($_POST['name']=="") {
                    $_SESSION['msg'][] = "Empty name is not allowed";
                    return;
                  }
                  if ($_POST['city']=="") {
                    $_SESSION['msg'][] = "Empty city name is not allowed";
                    return;
                  }
                //   $arr['email'] = sanitize_remove_tags($_POST['email']);
                  $arr['name'] = sanitize_remove_tags($_POST['name']);
                  $arr['city'] = sanitize_remove_tags($_POST['city']);
                  $arr['isd_code'] = sanitize_remove_tags($_POST['dial_code']);
                  $arr['mobile'] = sanitize_remove_tags($_POST['mobile']);
                  if ($_POST['email']=="") {
                    $arr['email'] = uniqid("dummy_email_")."@hrms.com";
                    echo $arr['email'];
                  }else{
                    $arr['email'] = sanitize_remove_tags($_POST['email']);
                  }

                  if ($_POST['username']=="") {
                    $arr['username'] = generate_username_by_email($arr['email']);
                  }else{
                    $arr['username'] = sanitize_remove_tags($_POST['username']);
                  }
                  if ($_POST['password']=="") {
                    $arr['password'] = md5(uniqid(rand(0,99999)).time());
                  }else{
                    $arr['password'] = md5($_POST['password']);
                  }
                  

                  if ($arr['name']=="") {
                    $_SESSION['msg'][] = "Empty name is not allowed";
                    return;
                  }
                  if (filter_var($arr['email'],FILTER_VALIDATE_EMAIL)!=true) {
                    $_SESSION['msg'][] = "Invalid Email";
                    return;
                  }
                  if (filter_var($_POST['mobile'],FILTER_VALIDATE_INT)!=true) {
                    $_SESSION['msg'][] = "Invalid Mobile";
                    return;
                  }
                  if ($email_exists!=false) {
                    $_SESSION['msg'][] = "This email is already exists";
                    return;
                  }
                  if (strlen($arr['username'])<3) {
                    $_SESSION['msg'][] = "Username must be greater than 2 digits";
                    return;
                  }
                  if (strlen($arr['password'])<5) {
                    $_SESSION['msg'][] = "Password must be greater than 4 digits";
                    return;
                  }
                  if ($username_exists!=false) {
                    $_SESSION['msg'][] = "This username is already exists";
                    return;
                  }
                  if ($mobile_exists!=false) {
                    $_SESSION['msg'][] = "This mobile is already exists";
                    return;
                  }
                //   if ($csrf==true) {
                //     if(verify_csrf($_POST['csrf_token'],$refresh=true)==false){
                //         $_SESSION['msg'][] = "Invalid CSRF";
                //         return false;
                //     }
                //  }
                    $userid = $this->dbTableObj->store($arr);
                  if(filter_var($userid,FILTER_VALIDATE_INT)==true){
                    $_SESSION['msg'][] = "User Created successfully";
                    return $userid;
                  }
                  else{
                    $_SESSION['msg'][] = "User not Created";
                    return false;
                  }
              }
    }
    public function destroy($id,$csrf=true)
    {
        if (isset($id) && filter_var($id,FILTER_VALIDATE_INT)==true) {
            if($this->dbTableObj->show($id)['username']=="admin"){
                $_SESSION['msg'][] = "Admin with username 'admin' can not be deleted";
                return false;
            }
            // if ($csrf==true) {
            //     if(verify_csrf($_POST['csrf_token'],$refresh=true)==false){
            //         $_SESSION['msg'][] = "Invalid CSRF";
            //         return false;
            //     }
            //  }
            try {
                $this->dbTableObj->destroy($id);
                $_SESSION['msg'][] = "User deleted successfully";
                return true;
            }catch (Exception $e) {
                $_SESSION['msg'][] = "User not deleted";
                return false;
            }
        }
        else{
            return false;
        }
    }
}