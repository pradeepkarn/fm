<?php
class ContentCtrl{
    private $dbTableObj;
    public function __construct()
    {
        $this->dbTableObj = new Model('content');
    }

    public function addContent()
    {

        if (isset($_POST['page_title']) && isset($_POST['slug']) && isset($_POST['content_group'])) {
                  $arr['title'] = sanitize_remove_tags($_POST['page_title']);
                  $arr['created_by'] = $_SESSION['user_id'];
                  $arr['status'] = "listed";
                  $arr['content_group'] = sanitize_remove_tags($_POST['content_group']);
                  $slug_exists = $this->dbTableObj->exists(['slug'=>$_POST['slug']]);
                  if ($slug_exists==true) {
                    $slug = generate_slug(sanitize_remove_tags($_POST['slug']),99999);
                    if ($slug==false) {
                      $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>Invalid slug</span>";
                      return;
                    }
                    $arr['slug'] = $slug;
                  }
                  else{
                    $arr['slug'] = sanitize_remove_tags(str_replace(" ","-",$_POST['slug']));
                  }
                 
                  if ($arr['title']=="") {
                    $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>Empty name is not allowed</span>";
                    return;
                  }
                //   if ($csrf==true) {
                //     if(verify_csrf($_POST['csrf_token'],$refresh=true)==false){
                //         $_SESSION['msg'][] = "Invalid CSRF";
                //         return false;
                //     }
                //  }
                    $contentid = $this->dbTableObj->store($arr);
                  if(filter_var($contentid,FILTER_VALIDATE_INT)==true){
                    $_SESSION['msg'][] = "<span class='alert text-white bg-success p-1'>Item created successfully</span>";
                    return $contentid;
                  }
                  else{
                    $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>Item not Created</span>";
                    return false;
                  }
              }
    }
    //update
    public function updateContent($content_id)
    {
            if($this->dbTableObj->exists(array('id'=>$content_id)!=true)){
              return $_SESSION['msg'] = "Object not found";
            }
            if (isset($_POST['page_title'])) {
              $arr['title'] = $_POST['page_title'];
            }
            if (isset($_POST['page_content'])) {
              $arr['content'] = $_POST['page_content'];
            }
            if (isset($_POST['parent_id'])) {
                $arr['parent_id'] = $_POST['parent_id'];
            }
            if (isset($_POST['page_status'])) {
              $arr['status'] = $_POST['page_status'];
            }
            if (isset($_POST['page_content_type'])) {
              $arr['content_type'] = $_POST['page_content_type'];
            }
            if (isset($_POST['page_content_category'])) {
              $arr['category'] = $_POST['page_content_category'];
            }
            if (isset($_POST['is_active'])) {
              $arr['is_active'] = $_POST['is_active'];
            }
            if (isset($_POST['page_banner'])) {
              $arr['banner'] = $_POST['page_banner'];
            }
            if (isset($_POST['post_category'])) {
              $arr['post_category'] = $_POST['post_category'];
            }
            if (isset($_POST['price'])) {
              $arr['price'] = sanitize_remove_tags($_POST['price']);
            }
            if (isset($_POST['page_content_info'])) {
              $arr['content_info'] = $_POST['page_content_info'];
            }
            $arr['update_date'] = date("Y-m-d h:i:sa", time());
            // $author = getData('pk_user',$_SESSION['user_id']);
            if (isset($_POST['page_show_title']) && $_POST['page_show_title']==="on") {
                $arr['show_title'] = 1;
            }
            else{
                $arr['show_title'] = 0;
            }
            if (check_slug_globally($_POST['slug'])==0) {
                $arr['slug'] = $_POST['slug'];
            }
            return $this->dbTableObj->update($content_id,$arr);
        
    }
    //delete
    public function destroy($id,$csrf=false)
    {
        if (isset($id) && filter_var($id,FILTER_VALIDATE_INT)==true) {
            if ($csrf==true) {
                if(verify_csrf($_POST['csrf_token'],$refresh=true)==false){
                    $_SESSION['msg'][] = "Invalid CSRF";
                    return false;
                }
             }
            try {
                $this->dbTableObj->destroy($id);
                $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>Item deleted successfully</sapn>";
                return true;
            }catch (Exception $e) {
                $_SESSION['msg'][] = "Item not deleted";
                return false;
            }
        }
        else{
            return false;
        }
    }
}

