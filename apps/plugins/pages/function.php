<?php 

function upload_base64($base64string='',$uploadpath = RPATH.'/media/images/pages/',$name="bnr") {
    $uploadpath   = $uploadpath;
    $parts        = explode(";base64,", $base64string);
    $imageparts   = explode("image/", @$parts[0]);
    $imagetype    = $imageparts[1];
    $imagebase64  = base64_decode($parts[1]);
    $file         = $uploadpath . $name . '.png';
    file_put_contents($file, $imagebase64);
    return $name.".png";
}
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
       
        $db->insertData['status'] = $_POST['page_status'];
       
        $db->insertData['banner'] = $_POST['page_banner'];
        

        $db->insertData['update_date'] = date("Y-m-d h:i:sa", time());
       
   
        if (isset($_POST['page_show_title']) && $_POST['page_show_title']==="on") {
            $db->insertData['show_title'] = 1;
        }
        else{
            $db->insertData['show_title'] = 0;
        }
        if (check_slug_globally($_POST['slug'])==0) {
            $db->insertData['slug'] = $_POST['slug'];
        }
        if(isset($_POST['banner_base64']) && $_POST['banner_base64']!=""){
            $name = uniqid('banner_').time();
            $imgname = upload_base64($_POST['banner_base64'],RPATH.'/media/images/pages/',$name);
            $oldpath = RPATH.'/media/images/pages/'.$cat['banner'];
            if ($cat['banner']!="" && file_exists($oldpath)) {
                unlink($oldpath);
            }
            $db->insertData['banner'] = $imgname;
        }
        return $db->update();
    }
}
function addContent($type="page")
{
    if (isset($_POST['add_new_content'])) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $db->insertData['title'] = $_POST['page_title'];
        $db->insertData['content'] = 'Write your content here';
       
        if (isset($_POST['status'])) {
            $db->insertData['status'] = $_POST['status'];
        }else{
            $db->insertData['status'] = 'draft';
        }
        
        $db->insertData['slug'] = $_POST['slug'];
        $db->insertData['content_group'] = $type;
        $db->insertData['content_type'] = "page";
        $db->insertData['created_by'] = $_SESSION['user_id'];
        $slug = generate_slug($_POST['slug']);
        if (check_slug_globally($slug)==0) {
            $db->insertData['slug'] = $slug;
            return $db->create();
        }
        else{
            $_SESSION['msg'][] = "Please change slug";
            return false;
        }
    }
}
function delContent($id=null)
{
    if ($id > 0) {
        $db = new Dbobjects();
        $db->tableName = "content";
        $qry['id'] = $id;
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
