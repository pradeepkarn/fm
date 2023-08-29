<?php 

function gal_media()
{
    $media = new Media();
    $media_folder = RPATH. "/media/images/pages/";
    $media->dir = $media_folder;
    return $media->read_files("ASC");
}

function del_media($img_src)
{
    $imgname = explode("/",$img_src);
    $imgname = end($imgname);
    $media_src = RPATH ."/media/images/pages/{$imgname}";
    $mddb = new Mydb('pk_media');
    $mddb->getData(['media_file'=>$imgname]);
    $mddb->deleteData();
    $media = new Media();
    return $media->dltMedia($media_src);
}

function gal_upload_media($file_name)
{
    if (isset($_FILES['media_file']) && isset($_POST['csrf_token'])) {
        $file = $_FILES['media_file'];
        $media_title = sanitize_remove_tags($_POST['media_title']);
        $media_folder = "images/pages";
        $imgname = $file_name;
        $dir_name = "/media/images/pages/";
        $media = new Media();
        $file_ext = explode(".",$file["name"]);
        $ext = end($file_ext);
        $medi_file_name = $imgname.".".$ext;
        $media->upload_media($file,$media_folder,$imgname,$file['type']);
        $db = new Mydb('pk_media');
        $db->createData(['media_file'=>$medi_file_name,'dir_name'=>$dir_name,'media_title'=>$media_title]);
    }
}