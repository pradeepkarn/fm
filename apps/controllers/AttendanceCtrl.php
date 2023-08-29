<?php 

class AttendanceCtrl 
{

    public function make_me_present()
    {
        if (authenticate()==true) {
                $accnt = new Account();
                $user = $accnt->getLoggedInAccount();
                $attndce = new Model('attendance');
                $present = $attndce->filter_index(array('user_id'=>$user['id'],'signin_on'=>date('Y-m-d')));
                if ($present==false) {
                $attndce->store(array('user_id'=>$user['id'],'signin_on'=>date('Y-m-d'),'signin_time'=>date('H:i:s')));
                $_SESSION['msg'][] = "Attendence marked successfully";
                return;
                }else{
                $_SESSION['msg'][] = "You have already marked the attendance";
                return;
                }
        }
        else{
            $_SESSION['msg'][] = "You are not logged in";
            return false;
        }
    }
    public function check_today_attendance()
    {
        if (authenticate()==true) {
                $accnt = new Account();
                $user = $accnt->getLoggedInAccount();
                $attndce = new Model('attendance');
                $present = $attndce->filter_index(array('user_id'=>$user['id'],'signin_on'=>date('Y-m-d')));
                if ($present==false) {
                    return false;
                }else{
                    return true;
                }
        }
        else{
            $_SESSION['msg'][] = "You are not logged in";
            return false;
        }
    }
    public function get_my_attendance_log()
    {
        if (authenticate()==true) {
                $accnt = new Account();
                $user = $accnt->getLoggedInAccount();
                $attndce = new Model('attendance');
                $present = $attndce->filter_index(array('user_id'=>$user['id']));
                if ($present==false) {
                    $_SESSION['msg'][] = "No log found";
                    return array();
                }else{
                    return $present;
                }
        }
        else{
            $_SESSION['msg'][] = "You are not logged in";
            return false;
        }
    }
}


