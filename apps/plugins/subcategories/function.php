<?php 

function uploadBanner($banner_name)
{
    if (isset($_FILES['banner']) && isset($_POST['update_banner'])) {
        $file = $_FILES['banner'];
        $media_folder = "images/pages";
        $imgname = $banner_name;
        $media = new Media();
        $page = new Dbobjects();
        $page->tableName = 'content';
        $page->pk($_POST['update_banner_page_id']);
        $file_ext = explode(".",$file["name"]);
        $ext = end($file_ext);
        $page->insertData['banner'] = $imgname.".".$ext;
        $page->update();
        $media->upload_media($file,$media_folder,$imgname,$file['type']);
    }
}

function updatePage()
{
    if (isset($_POST['page_id']) && isset($_POST['update_page'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $cat = $db->pk($_POST['page_id']);
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = $_POST['page_content'];
        // $db->insertData['other_content'] = $_POST['page_other_content'];
        $db->insertData['status'] = $_POST['page_status'];
        $db->insertData['content_type'] = $_POST['page_content_type'];
        if (isset($_POST['page_content_category'])) {
            $db->insertData['category'] = $_POST['page_content_category'];
        }
        if ($_POST['parent_id']) {
            $db->insertData['parent_id'] = $_POST['parent_id'];
        }
        if (isset($_POST['page_content_info'])) {
            $db->insertData['content_info'] = $_POST['page_content_info'];
         }
        if (isset($_POST['page_other_content'])) {
            $db->insertData['other_content'] = $_POST['page_other_content'];
        }
        $db->insertData['banner'] = $_POST['page_banner'];
        $db->insertData['post_category'] = $_POST['post_category'];
        // $db->insertData['content_info'] = $_POST['page_content_info'];
        $db->insertData['update_date'] = date("Y-m-d h:i:sa", time());
        $author = new Mydb('pk_user');
        $auth_user = $author->pkData($_SESSION['user_id'])['id'];
        $db->insertData['created_by'] = $auth_user;
        $db->insertData['author'] = $_POST['page_author'];;
        if (isset($_POST['page_show_title']) && $_POST['page_show_title']==="on") {
            $db->insertData['show_title'] = 1;
        }
        else{
            $db->insertData['show_title'] = 0;
        }
        if (check_slug_globally($_POST['slug'])==0) {
            $db->insertData['slug'] = $_POST['slug'];
        }
        return $db->update();
    }
}
function addContent($type="listing_category")
{
    // $cats = (new Model('content'))->filter_index(array('content_group'=>'listing_category'));
    // if ($cats!=false) {
    //     foreach ($cats as $key => $cv) {
    //         $cats = (new Model('content'))->exists(array('content_group'=>'listing_category','id'=>$cv['parent_id']));
    //         if ($cats==false) {
    //             (new Model('content'))->update($cv['id'],array('parent_id'=>0));
    //         }
    //     }
    // }
    if (isset($_POST['add_new_content'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $db->insertData['title'] = $_POST['page_title'];
        if (isset($_POST['content'])) {
            $db->insertData['content'] = $_POST['content'];
        }
        if (isset($_POST['parent_id'])) {
            $db->insertData['parent_id'] = intval($_POST['parent_id']);
        }else{
            $_SESSION['msg'][] = "Invalid parent category";
            return;
        }
        if (isset($_POST['page_content_info'])) {
            $db->insertData['content_info'] = $_POST['page_content_info'];
         }
        if (isset($_POST['page_other_content'])) {
            $db->insertData['other_content'] = $_POST['page_other_content'];
        }
        $db->insertData['status'] = 'listed';
        $db->insertData['slug'] = $_POST['slug'];
        $db->insertData['content_group'] = $type;
        $db->insertData['content_type'] = "category";
        $db->insertData['created_by'] = $_SESSION['user_id'];
        
        $slug = generate_slug($_POST['slug']);
        if (check_slug_globally($slug)==0) {
            $db->insertData['slug'] = $slug;
            return $db->transact();
        }
        else{
            return false;
        }
    }
}
function delContent($id)
{
    if ($id > 0) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $qry['id'] = $id;
        $childrenobj = new Model('content');
        $children = $childrenobj->filter_index(array('parent_id'=>$id));
        if ($children!=false) {
            foreach ($children as $key => $child) {
                if ((new Model('content'))->exists(array('parent_id'=>$db->pk($id)['parent_id']))==true) {
                    $childrenobj->update($child['id'],array('parent_id'=>$db->pk($id)['parent_id']));
                }
                else{
                    $childrenobj->update($child['id'],array('parent_id'=>0));
                }
                
            }
        }
        // $qry['status'] = 'trash';
        if(count($db->filter($qry))>0){
            $db->pk($id);
            return $db->delete();
        }
        else{
            return false;
        }
        
    }
    else{
        return false;
    }
}

function getCat($id=null)
{
    if ($id !=null) {
        $db = new Dbobjects();
        $db->tableName = "categories";
        $qry['id'] = $id;
        if(count($db->filter($qry))>0){
            return $db->pk($id)['name'];
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}



// if(isset($_POST['addcat'])){   
//     $msg=create_category();     
// }

// insert query
