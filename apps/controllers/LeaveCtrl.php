<?php 

class LeaveCtrl 
{

    public function request_for_leave($arr)
    {

        if (authenticate()==true) {
                $accnt = new Account();
                $user = $accnt->getLoggedInAccount();
                $leaveObj = new Model('leaves');
                $leaves = $leaveObj->filter_index(array('user_id'=>$user['id'],'from_date'=>$arr['from_date']));
                if ($leaves==false) {
                $leaveObj->store(
                    array(
                        'user_id'=>$user['id'],
                        'from_date'=>$arr['from_date'],
                        'to_date'=>$arr['to_date'],
                        'start_time'=>$arr['start_time'],
                        'leave_group'=>$arr['leave_group'],
                        'end_time'=>$arr['end_time'],
                        'status'=>'pending',
                        'approved'=>0
                        )
                );
                $_SESSION['msg'][] = "Request sent";
                return true;
                }else{
                $_SESSION['msg'][] = "You have already requested for leave starting from this date";
                return false;
                }
        }
        else{
            $_SESSION['msg'][] = "You are not logged in";
            return false;
        }
    }
    public function get_my_leaves_log()
    {
        if (authenticate()==true) {
                $accnt = new Account();
                $user = $accnt->getLoggedInAccount();
                $leaveObj = new Model('leaves');
                $leave_records = $leaveObj->filter_index(array('user_id'=>$user['id']));
                if ($leave_records==false) {
                    $_SESSION['msg'][] = "No log found";
                    return array();
                }else{
                    return $leave_records;
                }
        }
        else{
            $_SESSION['msg'][] = "You are not logged in";
            return false;
        }
    }
}


