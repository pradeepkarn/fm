<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php
if (authenticate()===false) {
    header("Location:/".home);
  }
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$url['end'] = end($url);
$url['prev'] = prev($url);
$plugin_dir = "admin";
$home = home;
const sidebar_bg = "bg-admin";
const navbar_bg = "bg-admin";
import("apps/admin/function.php");
import("apps/controllers/controllers.php");
$pass = PASS;
if ($url[0] == "{$plugin_dir}") {
switch ($path) {
    case "admin":
      if(!$pass){
        header("Location:/".home."/admin");
        return;
      }
        import("apps/admin/dashboard.php");
        break;
   
  default:
//   register plugin here
        if ($url[1]=="") {
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
            import("apps/admin/dashboard.php");
            return;
        }
        // else if($url[1]=="bookings"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/bookings/index.php");
        //   break;
        // }
        // else if($url[1]=="service-categories"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/service-categories/index.php");
        //   break;
        // }
        // else if($url[1]=="transportations"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/transportations/index.php");
        //   break;
        // }
        // else if($url[1]=="maintenance"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/maintenance/index.php");
        //   break;
        // }
        // else if($url[1]=="salon"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/salon/index.php");
        //   break;
        // }
        // else if($url[1]=="companies"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/companies/index.php");
        //   break;
        // }
        // else if($url[1]=="plans"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/plans/index.php");
        //   break;
        // }
        else if($url[1]=="users"){
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
          import("apps/plugins/users/index.php");
          break;
        }
        else if($url[1]=="faqs"){
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
          import("apps/plugins/faqs/index.php");
          break;
        }
        // else if($url[1]=="promotions"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/promotions/index.php");
        //   break;
        // }
        // else if($url[1]=="orders"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/orders/index.php");
        //   break;
        // }
        // else if($url[1]=="whorders"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/whorders/index.php");
        //   break;
        // }
        // else if($url[1]=="generate-report"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/admin/components/orders/report.php");
        //   break;
        // }
        // else if($url[1]=="save-locations-ajax"){
        //   if(!$pass){
        //     return;
        //   }
        //   import("apps/admin/components/locations/loc-store-ajax.php");
        //   break;
        // }
        else if($url[1]=="offers"){
          if(!$pass){
            header("Location:/".home);
            return;
          }
          import("apps/plugins/offers/index.php");
          break;
        }
        // else if($url[1]=="wallets"){
        //   if(!$pass){
        //     header("Location:/".home);
        //     return;
        //   }
        //   import("apps/plugins/wallets/index.php");
        //   break;
        // }
        // else if($url[1]=="generate-csv"){
        //   if(!$pass){
        //     header("Location:/".home);
        //     return;
        //   }
        //   $csv = new Pkcsv;
          
        //   switch ($_GET['report_obj']) {
        //     case 'users':
        //       $usrObj = new Model('pk_user');
        //       $data_array = $usrObj->index();
        //       break;
        //     case 'premium-users':
        //       $usrObj = new Model('pk_user');
        //       $data_array = $usrObj->filter_index(array('role'=>'premium'));
        //       break;
        //     case 'listings':
        //       $contObj = new Model('content');
        //       $data_array = $contObj->filter_index(array('content_group'=>'product'));
        //       break;
        //     case 'packages':
        //       $contObj = new Model('content');
        //       $data_array = $contObj->filter_index(array('content_group'=>'package'));
        //       break;
        //     default:
        //       die();
        //       break;
        //   }
        //   if ($data_array==false) {
        //     die();
        //   }
        //   $csv->download_send_headers($_GET['report_obj']."_data.csv");
        //   echo $csv->array2csv($data_array);
        //   die();
        //   break;
        // }
        // else if($url[1]=="packages"){
        //   if(getAccessLevel()>2){
        //     header("Location:/".home);
        //     return;
        //   }
        //   import("apps/plugins/packages/index.php");
        //   break;
        // }
        // else if($url[1]=="manage-team"){
        //   import("apps/admin/screens/team.index.php");
        //   break;
        // }
        else if($url[1]=="categories"){
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
          import("apps/plugins/categories/index.php");
          break;
        }
        else if($url[1]=="subcategories"){
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
          import("apps/plugins/subcategories/index.php");
          break;
        }
        else if($url[1]=="pages"){
          import("apps/plugins/pages/index.php");
          break;
        }
        // else if($url[1]=="purchase-orders"){
        //   import("apps/admin/purchase-orders.php");
        //   break;
        // }
        else if($url[1]=="sliders"){
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
          import("apps/plugins/sliders/index.php");
          break;
        }
        else if($url[1]=="mainbanners"){
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
          import("apps/plugins/mainbanners/index.php");
          break;
        }
        // else if($url[1]=="reviews"){
        //   if(!is_superuser()){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/reviews/index.php");
        //   break;
        // }
        else if($url[1]=="contents"){
          if(!$pass){
            header("Location:/".home."/admin");
            return;
          }
          import("apps/plugins/contents/index.php");
          break;
        }
        // else if($url[1]=="services"){
        //   if(getAccessLevel()>5){
        //     header("Location:/".home."/admin");
        //     return;
        //   }
        //   import("apps/plugins/services/index.php");
        //   break;
        // }
        // else if($url[1]=="courses"){
        //   if(getAccessLevel()>5){
        //     header("Location:/".home."/admin/my-account");
        //     return;
        //   }
        //   import("apps/admin/services.php");
        //   break;
        // }
        // else if($url[1]=="releases"){
        //   if(getAccessLevel()>5){
        //     header("Location:/".home."/admin/my-account");
        //     return;
        //   }
        //   import("apps/admin/service-releases.php");
        //   break;
        // }
        // else if($url[1]=="my-account"){
        //   import("apps/admin/pages/my-account.php");
        //   break;
        // }
        else if($url[1]=="edit-account"){
          if(is_superuser()==false){
            header("Location:/".home);
            return;
          }
          import("apps/admin/pages/edit-account.php");
          break;
        }
        else if($url[1]=="change-password"){
          if(is_superuser()==false){
            header("Location:/".home);
            return;
          }
          import("apps/admin/pages/change-password.php");
          break;
        }
        else if($url[1]=="add-user"){
          if(is_superuser()==false){
            header("Location:/".home);
            return;
          }
          import("apps/admin/pages/add-user.php");
          break;
        }
        else if($url[1]=="enquiries"){
          if(!$pass){
            header("Location:/".home."/admin");
          }
          import("apps/admin/pages/enquiries.php");
          break;
        }
        // else if($url[1]=="reviews"){
        //   if(!$pass){
        //     header("Location:/".home."/admin");
        //   }
        //   import("apps/admin/pages/reviews.php");
        //   break;
        // }
        else if($url[1]=="comments"){
          if(!$pass){
            header("Location:/".home."/admin");
          }
          import("apps/admin/pages/comments.php");
          break;
        }
        // else if($url[1]=="all-customers"){
        //   if(is_superuser()==false){
        //     header("Location:/".home);
        //     return;
        //   }
        //   import("apps/admin/pages/all-customers.php");
        //   break;
        // }
        else if($url[1]=="all-users"){
          if(is_superuser()==false){
            header("Location:/".home);
            return;
          }
          $context = array();
          if (isset($_GET['user_group'])) {
            if (in_array($_GET['user_group'],['admin','customer','vendor'])) {
              $user_group = $_GET['user_group'];
              $context['user_group'] = $user_group;
            }else{
              $context['user_group']='all';
            }
          }
          import("apps/admin/pages/all-users.php",$context);
          break;
        }
        // else if($url[1]=="all-whmanagers"){
        //   if(is_superuser()==false){
        //     header("Location:/".home);
        //     return;
        //   }
        //   import("apps/admin/pages/all-whmanagers.php");
        //   break;
        // }
        // else if($url[1]=="attendance"){
        //   if(is_superuser()==false){
        //     header("Location:/".home);
        //     return;
        //   }
        //   import("apps/admin/pages/all-attendance.php");
        //   break;
        // }
        // else if($url[1]=="attendance-detail"){
        //   if(is_superuser()==false){
        //     header("Location:/".home);
        //     return;
        //   }
        //   import("apps/admin/pages/attendance-detail.php");
        //   break;
        // }
        else if($url[1]=="coupons"){
          if(!$pass){
            header("Location:/".home."/admin");
          }
          import("apps/plugins/coupons/index.php");
          break;
        }
        // else if($url[1]=="ad-banners"){
        //   if(getAccessLevel()!=1){
        //     header("Location:/".home."/admin");
        //   }
        //   import("apps/plugins/ad-banners/index.php");
        //   break;
        // }
        // else if($url[1]=="filter-serv"){
        //   if(getAccessLevel()==1){
        //     import("apps/admin/ajaxpages/serv.ajax.php");
        //     return;
        //   }
        //   else{
        //     return false;
        //   } 
        //   break;
        // }
        // else if($url[1]=="manage-docs"){
        //   if(getAccessLevel()==1){
        //     import("apps/admin/pages/manage.docs.php");
        //     return;
        //   }
        //   else{
        //     return false;
        //   } 
        //   break;
        // }
        // else if($url[1]=="manage-certificates"){
        //   if(getAccessLevel()==1){
        //     import("apps/admin/pages/manage.certificates.php");
        //     return;
        //   }
        //   else{
        //     return false;
        //   } 
        //   break;
        // }
        // else if($url[1]=="generate-qr-code"){
        //   if(getAccessLevel()==1){
        //     import("apps/admin/pages/generate-qr-code.php");
        //     return;
        //   }
        //   else{
        //     return false;
        //   } 
        //   break;
        // }
        // else if($url[1]=="course-certificates"){
        //   if(getAccessLevel()==1){
        //     import("apps/admin/pages/user-course-certificates.php");
        //     return;
        //   }
        //   else{
        //     return false;
        //   } 
        //   break;
        // }
        else if($url[1]=="change-my-password"){
          if(is_superuser()==false){
            header("Location:/".home);
            return;
          }
          if (authenticate()==true) {
            $ac = new Account();
            $user = $ac->getLoggedInAccount();
            
            if (isset($_POST['old_pass'])) {
              if ($user['password']===md5($_POST['old_pass'])) {
                if ((strlen($_POST['new_pass'])>5) && (strlen($_POST['cnf_new_pass'])>5)){
                  $new_pass = md5($_POST['new_pass']);
                  $cnf_new_pass = md5($_POST['cnf_new_pass']);
                  if ($new_pass===$cnf_new_pass) {
                    $newpas = new Mydb('pk_user');
                    $newpas->pk($_SESSION['user_id']);
                    if($newpas->updateData(['password' => $cnf_new_pass])==true){
                      echo js_alert("Password Changed");
                      echo js("location.reload();");
                    }
                    else{
                      echo js_alert("Invalid input");
                    }
                  }
                }
              }
              else{
                echo js_alert("Invalid old password");
              }
            }
          }
          break;
        }
        else if($url[1]=="update-personal-info"){
          if(is_superuser()==false){
            echo js_alert("Access denied");
            return;
          }
          if (authenticate()==true) {
            $ac = new Account();
            $user = $ac->getLoggedInAccount();
            
            if (isset($_POST['name']) && isset($_POST['my_mobile']) && isset($_POST['user_id'])) {
              if ($_POST['name']!="") {
                    $newpas = new Mydb('pk_user');
                    $newpas->pk($_POST['user_id']);
                    if (isset($_POST['gender'])) {
                      $arr['gender'] = sanitize_remove_tags($_POST['gender']);
                    }
                    if (isset($_POST['name']) ) {
                      $arr['name'] = sanitize_remove_tags($_POST['name']);
                    }
                    if (isset($_POST['user_group']) ) {
                      $arr['user_group'] = sanitize_remove_tags($_POST['user_group']);
                    }
                    if (isset($_POST['city']) ) {
                      $arr['city'] = sanitize_remove_tags($_POST['city']);
                    }
                 
                    $is_dup_mob = (new Model('pk_user'))->exists(array('mobile'=>sanitize_remove_tags($_POST['my_mobile'])));
                    $arr['mobile'] = $is_dup_mob?null:sanitize_remove_tags($_POST['my_mobile']);
                    $arr['isd_code'] = $_POST['dial_code'];
                    if (isset($_POST['change_pass'])) {
                      if ($_POST['my_password']!="") {
                        $arr['password'] = md5($_POST['my_password']);
                      }
                    }
                   
                    if($newpas->updateData($arr)==true){
                        $username = $newpas->pk($_POST['user_id'])['username'];
                        $id = $newpas->pk($_POST['user_id'])['id'];
                        $old_img = $newpas->pk($_POST['user_id'])['image'];
                        if (isset($_FILES['profile_image'])) {
                          if (!empty($_FILES['profile_image']['tmp_name'])) {
                            $img_upload = false;
                            $file_type = mime_content_type($_FILES['profile_image']['tmp_name']);
                            if ($file_type =="image/png" || $file_type =="image/jpg" || $file_type =="image/jpeg") {
                                $img_upload = true;
                            }
                            if($img_upload==false){
                                $msg['msg'][] = ['invalid_file' => mime_content_type($_FILES['profile_image']['tmp_name'])];
                            }
                          if($img_upload==true){
                            $file_name_arr = explode(".",$_FILES['profile_image']['name']);
                            $ext = end($file_name_arr);
                            $target_dir = RPATH ."/media/images/profiles/";
                            $new_img = "{$username}_{$id}.".$ext;
                            $new_file = $target_dir.$new_img;
                            $old_file = $target_dir.$old_img;
                              if (($old_img!="") && ( file_exists($old_file)==true) ){
                                  unlink($old_file);
                              }
                              if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $new_file)) {
                                $msg['msg'][] = "Image uploaded";
                                $arr = null;
                                $arr['image'] = "$new_img";
                                $newpas->updateData($arr);
                              }
                            }
                          }
                        }

                      echo js_alert("Updated");
                      // echo js("location.reload();");
                      if (isset($_POST['page'])) {
                        echo js("location.href='/$home/admin/all-users/?user_group={$_POST['page']}';");
                        return;
                      }
                      echo js("location.href='/$home/admin/all-users';");
                      return;
                    }
                    else{
                      echo js_alert("Invalid input");
                    }
                  }
                  else{
                    echo js_alert("Empty data is not allowed");
                  }
                }
              }
              break;
            }
            else if($url[1]=="add-personal-info"){
              if(is_superuser()==false){
                echo js_alert("Access denied");
                return;
              }
                if (is_superuser()==true) {
                  $usr = new UserCtrl;
                    $userid = $usr->addUser($csrf=true);
                    echo "<span class='bg-warning text-dark'>";
                      msg_ssn("msg");
                    echo "</span>";
                    if (filter_var($userid,FILTER_VALIDATE_INT)==true) {
                      echo js("location.href='/$home/admin/all-users';");
                    }
                  }
                  break;
                }
            else if($url[1]=="add-vendor-ajax"){
              if(is_superuser()==false){
                echo js_alert("Access denied");
                return;
              }
                if (is_superuser()==true) {
                  $usr = new UserCtrl;
                    $userid = $usr->add_user_by_group($csrf=true);
                    echo "<span class='bg-warning text-dark'>";
                      msg_ssn("msg");
                    echo "</span>";
                    if (filter_var($userid,FILTER_VALIDATE_INT)==true) {
                      echo js("location.href='/$home/admin/all-users/?user_group=vendor';");
                    }
                  }
                  break;
                }
            else if($url[1]=="add-salesman-ajax"){
              if(is_superuser()==false){
                echo js_alert("Access denied");
                return;
              }
                if (is_superuser()==true) {
                  $usr = new UserCtrl;
                    $userid = $usr->add_employee($csrf=true);
                    echo "<span class='bg-warning text-dark'>";
                      msg_ssn("msg");
                    echo "</span>";
                    if (filter_var($userid,FILTER_VALIDATE_INT)==true) {
                      echo js("location.href='/$home/admin/all-users';");
                    }
                  }
                  break;
                }
            else if($url[1]=="user-delete"){
              if(is_superuser()==false){
                echo js_alert("Access denied");
                return;
              }
              if (is_superuser()==true) {
                if(is_superuser()==false){
                  echo js_alert("Access denied");
                  return;
                }
                $userdlt = getData('pk_user',$_POST['delete-user-id'])['user_group'];
                $usr = new UserCtrl;
                  $userid = $usr->destroy($_POST['delete-user-id'],$csrf=true);
                  msg_ssn("msg");
                  if (filter_var($userid,FILTER_VALIDATE_INT)==true) {
                    echo js("location.href='/$home/admin/all-users/?user_group=$userdlt';");
                  }
                }
              break;
            }
            else{
              import("apps/view/404.php");
              break;
            }
          import("apps/view/404.php");
          break;
    }
}
