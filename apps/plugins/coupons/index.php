<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "coupons";
$home = home;
import("apps/plugins/{$plugin_dir}/function.php");

if ("{$url[0]}/{$url[1]}" == "admin/{$plugin_dir}") {
    if (!isset($url[2])) {
        import("apps/plugins/{$plugin_dir}/item-list.php");
        return;
    }
    if (count($url)>=3) {
        if ($url[2]=='get-coupon-list-ajax') {
                $prodObj = new Model('coupons');
                // $employees = $userObj->index();
                $search_data = sanitize_remove_tags($_POST['code']);
                $arr['code'] = $search_data;
                $obj = $prodObj->filter_index($arr);
                if (count($obj)>0) {
                    if (isset($_POST['ignore_id'])) {
                        $obj = $prodObj->show($_POST['ignore_id']);
                        if ($obj['code']!=$arr['code']) {
                            echo "This code is already registered";
                            return;
                        }else{
                            return;
                        }
                    }
                    echo "This code is already registered";
                    return;
                }
                return;
        }
        if ($url[2]=='add-new-item') {
            import("apps/plugins/{$plugin_dir}/item-add.php");
            return;
        }
        if ($url[2]=='edit-item') {
            import("apps/plugins/{$plugin_dir}/item-edit.php");
            return;
        }
        if ($url[2]=='add-this-coupon-ajax') {
            $arr['code'] = $_POST['code'];
            if ( $_POST['code']  == "") {
                echo "Empty coupon is code not allowed";
                return;
            }
            $cpObj = new Model('coupons');
            $cp_exists = count($cpObj->filter_index($arr));
            if ($cp_exists) {
                echo "Please try with new coupon code, entered code has already been registered";
                return;
            }
            $arr['name'] = $_POST['name'];
            $arr['details'] = $_POST['details'];
            $arr['coupon_group'] = $_POST['coupon_group'];
            $arr['discount_type'] = $_POST['discount_type'];
            $arr['discount_value'] = $_POST['discount_value']!=""?$_POST['discount_value']:0;
            $arr['min_purchase_amt'] =  $_POST['min_purchase_amt']!=""?$_POST['min_purchase_amt']:0;
           
            if ( $_POST['created_at']  == "") {
                echo "Please provide Create Date";
                return;
            }
            if ( $_POST['created_at']  == "") {
                echo "Please provide Expiry Date";
                return;
            }
            $arr['created_at'] = $_POST['created_at'];
            $arr['expiry_date'] = $_POST['expiry_date'];
            $arr['created_by'] = $_SESSION['user_id'];
            // print_r($arr);
            // return;
            $coupon_id = $cpObj->store($arr);
            if ($coupon_id!=false) {
                echo js("location.href='/$home/admin/coupons';");
            }
            else{
                echo "Coupon not created";
            }
            return;
        }
        if ($url[2]=='edit-this-coupon-ajax') {
            $arr['code'] = $_POST['code'];
            if ( $_POST['code']  == "") {
                echo "Empty coupon is code not allowed";
                return;
            }
            $cpObj = new Model('coupons');
            $cp_exists = count($cpObj->filter_index($arr));
            if ($cp_exists) {
                if (isset($_POST['cpid'])) {
                    $obj = $cpObj->show($_POST['cpid']);
                    if ($obj['code']!=$arr['code']) {
                        echo "Please try with new coupon code, entered code has already been registered";
                        return;
                    }
                }
            }
            $cpid = $_POST['cpid'];
            $arr['name'] = $_POST['name'];
            $arr['details'] = $_POST['details'];
            $arr['coupon_group'] = $_POST['coupon_group'];
            $arr['discount_type'] = $_POST['discount_type'];
            $arr['discount_value'] = $_POST['discount_value']!=""?$_POST['discount_value']:0;
            $arr['min_purchase_amt'] =  $_POST['min_purchase_amt']!=""?$_POST['min_purchase_amt']:0;
            if ( $_POST['created_at']  == "") {
                echo "Please provide Create Date";
                return;
            }
            if ( $_POST['created_at']  == "") {
                echo "Please provide Expiry Date";
                return;
            }
            $arr['created_at'] = $_POST['created_at'];
            $arr['expiry_date'] = $_POST['expiry_date'];
            $arr['created_by'] = $_SESSION['user_id'];
            // print_r($arr);
            // return;
            $coupon_id = $cpObj->update($cpid,$arr);
            if ($coupon_id!=false) {
                echo js("location.href='/$home/admin/coupons';");
            }
            else{
                echo "Coupon not created";
            }
            return;
        }
        if ($url[2]=='remove-this-coupon-ajax') {
            (new Model('coupons'))->destroy($_POST['remove_id']);
            echo js("location.href='/$home/admin/$plugin_dir';");
            return;
        }
        // if ($url[2]=='add-new-item-ajax') {
        //     if ($_POST['page_title']=="") {
        //         echo js_alert('Empty name is not allowed');
        //         return;
        //     }
        //     $pageid = addContent($type="content");
            
        //     if (isset($_FILES['banner']) && $_FILES['banner']["error"]==0 && filter_var($pageid,FILTER_VALIDATE_INT)) {
        //         $contentid = $pageid;
        //         $banner=$_FILES['banner'];
        //         $banner_name = time().uniqid("_banner_").USER['id'];
        //         change_my_banner($contentid=$contentid,$banner=$banner,$banner_name=$banner_name);
        //     }
        //     if (filter_var($pageid,FILTER_VALIDATE_INT)) {
        //         echo js_alert('added');
        //         $home = home;
        //         echo js("location.href='/$home/admin/contents';");
        //     }
        //     return;
        // }
        // if ($url[2]=='edit-item-ajax') {
        //     if ($_POST['page_title']=="") {
        //         echo js_alert('Empty name is not allowed');
        //         return;
        //     }
        //     print_r($_POST);
        //     $pageid = addContent($type="content");
            
        //     if (isset($_FILES['banner']) && $_FILES['banner']["error"]==0 && filter_var($pageid,FILTER_VALIDATE_INT)) {
        //         $contentid = $pageid;
        //         $banner=$_FILES['banner'];
        //         $banner_name = time().uniqid("_banner_").USER['id'];
        //         change_my_banner($contentid=$contentid,$banner=$banner,$banner_name=$banner_name);
        //     }
        //     if (filter_var($pageid,FILTER_VALIDATE_INT)) {
        //         echo js_alert('added');
        //         $home = home;
        //         echo js("location.href='/$home/admin/$plugin_dir';");
        //     }
        //     return;
        // }
        
    
    }
       
 
}

