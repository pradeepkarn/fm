<?php 

class UserProfileUpdateCtrl 
{

    public function update_profile()
    {

        if (authenticate()==true) {
                $accnt = new Account();
                $user = $accnt->getLoggedInAccount();
                $arr['user_group'] = "subscriber";
                    // $arr['role'] = 'subscriber';
                    // $arr['access_level'] = 10;
                    // $email = sanitize_remove_tags($_POST['email']);
                    // $password = sanitize_remove_tags($_POST['password']);
                    // $cnf_password = sanitize_remove_tags($_POST['cnf_password']);
                    // $arr['email'] = $email;
                    // $arr['password'] = md5($password);
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
                 
                       
        }
        else{
            $_SESSION['msg'][] = "You are not logged in";
            return false;
        }
    }
   
}


