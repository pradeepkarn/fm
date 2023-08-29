<?php 
function addService()
{
   if (isset($_POST['csrf_token']) && isset($_POST['add_new_service_admin'])) {
      if (isset($_POST['csrf_token']) === true) {
          $db = new Dbobjects();
          $db->tableName = "service";
          $qry = null;
          $qry['title'] = $_POST['service_title'];
          $qry['description'] = $_POST['service_desc'];
          $qry['price'] = $_POST['service_price'];
          $qry['sale_price'] = $_POST['sale_price'];
          $qry['content_group'] = $_POST['content_group'];
          $qry['max_booking'] = $_POST['max_booking'];
          if (isset($_POST['cid'])) {
            $qry['if_release_cid'] = $_POST['cid'];
          }
        //   $qry['service_duration'] = $_POST['service_duration'];
        //   $qry['service_starting_date'] = $_POST['service_starting_date'];
        //   $qry['service_ending_date'] = $_POST['service_ending_date'];
        //   $qry['service_duration_type'] = $_POST['service_duration_type'];
        //   $qry['service_starts'] = $_POST['service_starts'];
        //   $qry['service_ends'] = $_POST['service_ends'];
        //   $qry['gmap_lat'] = $_POST['gmap_lat'];
        //   $qry['gmap_long'] = $_POST['gmap_long'];
          $qry['category'] = $_POST['category'];
          
          $qry['activation'] = 1;

          $qry['created_by'] = $_SESSION['user_id'];
          $db->insertData = $qry;
          $qry = null;
          $service_id = $db->create();
          if($service_id>0){
            echo js("alert('added'); location.reload();");
          }
          else{
              echo js_alert("Failed");
              return;
          }
         
         
      }
   }
   if (isset($_POST['csrf_token']) && isset($_FILES['add_my_service_admin_image'])) {
    $file = $_FILES['add_my_service_admin_image'];
    if(($file['type']=="image/png") || ($file['type']=="image/jpeg") || ($file['type']=="image/jpg")){
         if(($file['size']/1024/1024)<5.1024){
             if (isset($service_id) && $service_id>1) {
             $media_folder = "images/categories/products";
             $imgname = "serv_".$service_id."_".$_SESSION['user_id']."_".rand(100,999);
             $fullname = $imgname.time();
             $file_ext = explode(".",$file['name']);
             $ext = end($file_ext);
             if ($file['name']!="") {
             $media = new Media();
             $media->upload_media($file,$media_folder,$fullname,$file['type']);
             $dbimg = new Dbobjects();
             $dbimg->tableName = "service";
             $oldimg = $dbimg->pk($pk = $service_id);
             $dbimg->insertData['image'] = "products/".$fullname.".".$ext;
             $md = new Media;
             $media_src = $_SERVER['DOCUMENT_ROOT']."/".media_root."/images/categories/".$oldimg['image'];
             if ($oldimg['image']!="products/product.png") {
                $md->dltMedia($media_src);
             }
             $dbimg->update();
             $dbimg->insertData = null;
             $dbimg = null;
             return;
            }
        }
        else{
            echo js("alert('Failed'); location.reload();");
            return;
        }
     }
         else{
             echo 'Image waas not uploaded, image size should have been of 5MB';
             return;
         }
     }
     else{
         echo 'Invalid image format';
         return;
     }
    
}
}
function updateService()
{
   if (isset($_POST['csrf_token']) && isset($_POST['update_my_service_admin'])) {
      if (isset($_POST['csrf_token']) === true) {
          $db = new Dbobjects();
          $db->tableName = "service";
          $db->pk($_POST['update_my_service_admin']);
          $qry = null;
          $qry['title'] = $_POST['service_title'];
          $qry['description'] = $_POST['service_desc'];
          $qry['price'] = $_POST['service_price'];
          $qry['sale_price'] = $_POST['sale_price'];
          $qry['max_booking'] = $_POST['max_booking'];
        //   $qry['service_duration'] = $_POST['service_duration'];
        //   $qry['service_starting_date'] = $_POST['service_starting_date'];
        //   $qry['service_ending_date'] = $_POST['service_ending_date'];
        //   $qry['service_duration_type'] = $_POST['service_duration_type'];
        //   $qry['service_starts'] = $_POST['service_starts'];
        //   $qry['service_ends'] = $_POST['service_ends'];
        //   $qry['gmap_lat'] = $_POST['gmap_lat'];
        //   $qry['gmap_long'] = $_POST['gmap_long'];
          $qry['category'] = $_POST['category'];
          $db->insertData = $qry;
          $qry = null;
          if($db->update()>0){
            echo js("alert('Updated'); location.reload();");
          }
          else{
              echo js_alert("Failed");
          }
         
         
      }
   }
   if (isset($_POST['csrf_token']) && isset($_FILES['update_my_service_admin_image'])) {
       $file = $_FILES['update_my_service_admin_image'];
       if ($file['name']!="") {
       if(($file['type']=="image/png") || ($file['type']=="image/jpeg") || ($file['type']=="image/jpg")){
            if(($file['size']/1024/1024)<5.1024){
                $media_folder = "images/categories/products";
                $imgname = "serv_".$_POST['service_id']."_".$_SESSION['user_id']."_".rand(100,999);
                $fullname = $imgname.time();
                $file_ext = explode(".",$file['name']);
                $ext = end($file_ext);
               
                $media = new Media();
                $media->upload_media($file,$media_folder,$fullname,$file['type']);
                $dbimg = new Dbobjects();
                $dbimg->tableName = "service";
                $oldimg = $dbimg->pk($pk = $_POST['service_id']);
                $dbimg->insertData['image'] = "products/".$fullname.".".$ext;
                $md = new Media;
                $media_src = $_SERVER['DOCUMENT_ROOT']."/".media_root."/images/categories/".$oldimg['image'];
                if ($oldimg['image']!="products/product.png") {
                    $md->dltMedia($media_src);
                 }
                $dbimg->update();
                $dbimg->insertData = null;
                $dbimg = null;
                echo js("alert('Updated'); location.reload();");
            }
        }
            else{
                echo 'Maximum image size should be 5MB';
                return;
            }
        }
        else{
            echo 'Invalid file format';
            return;
        }
       
   }
}
function getAllServices($limit="0,99999",$userid=0,$contype="jg")
{
    $db = new Mydb('service');
        if (getAccessLevel()<=1) {
            if ($userid!=0) {
                $arr = null;
                $arr['created_by'] = $userid;
                $arr['content_group'] = $contype;
                if(count($db->filterData($arr,"DESC",$limit))>0){
                    return $db->filterData($arr,"DESC",$limit);
                }
                else{
                    return false;
                }
            }
            else{
                if(count($db->allData("DESC",$limit))>0){
                    return $db->allData("DESC",$limit);
                }
                else{
                    return false;
                }
            }
        }
        elseif(getAccessLevel()<=5){
            $arr = null;
            $arr['created_by'] = $_SESSION['user_id'];
            if(count($db->filterData($arr,"DESC",$limit))>0){
                return $db->filterData($arr,"DESC",$limit);
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    
}
function getAllBookings($limit="0,999999",$userid=0)
{
    $db = new Mydb('booking_data');
        if (getAccessLevel()<=1) {
            // if(count($db->allData())>0){
            // return $db->allData("DESC",$limit);
            // }
            if ($userid!=0) {
                $arr = null;
                $arr['seller_id'] = $userid;
                if(count($db->filterData($arr,"DESC",$limit))>0){
                    return $db->filterData($arr,"DESC",$limit);
                }
                else{
                    return false;
                }
            }
            else{
                if(count($db->allData("DESC",$limit))>0){
                    return $db->allData("DESC",$limit);
                }
                else{
                    return false;
                }
            }
            
        }
        elseif(getAccessLevel()<=5){
            $arr = null;
            $arr['seller_id'] = $_SESSION['user_id'];
            if(count($db->filterData($arr,"DESC",99999999))>0){
                return $db->filterData($arr,"DESC",99999999);
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

}
function filterBookingsByStatus($status="all",$limit="0,999999",$userid=0)
{
        $arr = array();
        $data = getAllBookings($limit,$userid);
        if ($data==false) {
            return false;
        }
        $curnt_time = time();
        foreach ($data as $key => $v) {
            $start_time = strtotime(explode("to",$v['booking_slot'])[0]);
            $end_time = strtotime(explode("to",$v['booking_slot'])[1]);
            // $minute = ($start_time-$curnt_time)/60;
            if ($v['status']=="new") {
                if (strtotime($v['booking_date']) == strtotime(date("d-m-Y"))) {
                
                            if ($v['booking_date']==date("d-m-Y")) {
                                if ($start_time > $curnt_time) {
                                $arr['upcoming'][] = $v;
                                }
                                if (($start_time <= $curnt_time) && ($curnt_time <= $end_time)) {
                                    $arr['ongoing'][] = $v;
                                }
                                if ($curnt_time>$end_time) {
                                    $arr['completed'][] = $v;
                                }
                            }
                            
                    
                    }
                    elseif (strtotime($v['booking_date']) > strtotime(date("d-m-Y"))) {
                    
                                $arr['upcoming'][] = $v;
                            }
                    
                    elseif (strtotime($v['booking_date']) < strtotime(date("d-m-Y"))) {
                    
                                $arr['completed'][] = $v;
                            }
                }
                elseif ($v['status']=="cancelled"){
                    $arr['cancelled'][] = $v;
                }
                elseif ($v['status']=="failed"){
                    $arr['failed'][] = $v;
                }
                elseif ($v['status']=="expired"){
                    $arr['expired'][] = $v;
                }
                elseif ($v['status']=="served"){
                    $arr['served'][] = $v;
                }
        }
        if ($status=="all") {
            return $data;
        }
        elseif ($status=="upcoming") {
            if(!isset($arr['upcoming'])){
                return false;
            }
            return $arr['upcoming'];
        }
        elseif ($status=="ongoing") {
            if(!isset($arr['ongoing'])){
                return false;
            }
            return $arr['ongoing'];
        }
        elseif ($status=="completed") {
            if(!isset($arr['completed'])){
                return false;
            }
            return $arr['completed'];
        }
        elseif ($status=="cancelled") {
            if(!isset($arr['cancelled'])){
                return false;
            }
            return $arr['cancelled'];
        }
        elseif ($status=="failed") {
            if(!isset($arr['failed'])){
                return false;
            }
            return $arr['failed'];
        }
        elseif ($status=="expired") {
            if(!isset($arr['expired'])){
                return false;
            }
            return $arr['expired'];
        }
        elseif ($status=="served") {
            if(!isset($arr['served'])){
                return false;
            }
            return $arr['served'];
        }
        
  
}

function filterOrdersByStatus($status="all",$limit="0,999999",$userid=0)
{
        $arr = array();
        $data = getAllBookingPurchses($limit,$userid);
        if ($data==false) {
            return false;
        }
        $curnt_time = time();
        foreach ($data as $key => $v) {
            $start_time = strtotime(explode("to",$v['booking_slot'])[0]);
            $end_time = strtotime(explode("to",$v['booking_slot'])[1]);
            // $minute = ($start_time-$curnt_time)/60;
            if ($v['status']=="new") {
                if (strtotime($v['booking_date']) == strtotime(date("d-m-Y"))) {
                
                            if ($v['booking_date']==date("d-m-Y")) {
                                if ($start_time > $curnt_time) {
                                $arr['upcoming'][] = $v;
                                }
                                if (($start_time <= $curnt_time) && ($curnt_time <= $end_time)) {
                                    $arr['ongoing'][] = $v;
                                }
                                if ($curnt_time>$end_time) {
                                    $arr['completed'][] = $v;
                                }
                            }
                            
                    
                    }
                    elseif (strtotime($v['booking_date']) > strtotime(date("d-m-Y"))) {
                    
                                $arr['upcoming'][] = $v;
                            }
                    
                    elseif (strtotime($v['booking_date']) < strtotime(date("d-m-Y"))) {
                    
                                $arr['completed'][] = $v;
                            }
                }
                elseif ($v['status']=="cancelled"){
                    $arr['cancelled'][] = $v;
                }
                elseif ($v['status']=="failed"){
                    $arr['failed'][] = $v;
                }
                elseif ($v['status']=="expired"){
                    $arr['expired'][] = $v;
                }
                elseif ($v['status']=="served"){
                    $arr['served'][] = $v;
                }
        }
        if ($status=="all") {
            return $data;
        }
        elseif ($status=="upcoming") {
            if(!isset($arr['upcoming'])){
                return false;
            }
            return $arr['upcoming'];
        }
        elseif ($status=="ongoing") {
            if(!isset($arr['ongoing'])){
                return false;
            }
            return $arr['ongoing'];
        }
        elseif ($status=="completed") {
            if(!isset($arr['completed'])){
                return false;
            }
            return $arr['completed'];
        }
        elseif ($status=="cancelled") {
            if(!isset($arr['cancelled'])){
                return false;
            }
            return $arr['cancelled'];
        }
        elseif ($status=="failed") {
            if(!isset($arr['failed'])){
                return false;
            }
            return $arr['failed'];
        }
        elseif ($status=="expired") {
            if(!isset($arr['expired'])){
                return false;
            }
            return $arr['expired'];
        }
        elseif ($status=="served") {
            if(!isset($arr['served'])){
                return false;
            }
            return $arr['served'];
        }
        
  
}

function getAllBookingPurchses($limit="0,999999",$userid=0)
{
    $db = new Mydb('booking_data');
        if (getAccessLevel()<=1) {
            // if(count($db->allData())>0){
            // return $db->allData("DESC",$limit);
            // }
            if ($userid!=0) {
                $arr = null;
                $arr['user_id'] = $userid;
                if(count($db->filterData($arr,"DESC",$limit))>0){
                    return $db->filterData($arr,"DESC",$limit);
                }
                else{
                    return false;
                }
            }
            else{
                if(count($db->allData("DESC",$limit))>0){
                    return $db->allData("DESC",$limit);
                }
                else{
                    return false;
                }
            }
        }
        elseif(getAccessLevel()<=10){
            $arr = null;
            $arr['user_id'] = $_SESSION['user_id'];
            if(count($db->filterData($arr,"DESC",99999999))>0){
                return $db->filterData($arr,"DESC",99999999);
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

}
