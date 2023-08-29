<?php
class ContentDetailsCtrl
{
    private $dbTableObj;
    public function __construct()
    {
        $this->dbTableObj = new Model('content_details');
    }

    public function add_more_img()
    {

        if (isset($_FILES['add_more_img']) && $_FILES['add_more_img']['name'] != "") {
            // if (isset($_POST['image_color'])) {
            //     if ($_POST['image_color']=="") {
            //         $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>Please select color or add new color before uploading</span>";
            //         return;
            //     }
            // }
            $content_id = sanitize_remove_tags($_POST['content_id']);
            $moreimg = $this->dbTableObj->filter_index(array('content_id' => $content_id, 'content_group' => 'product_more_img'));
            $old_image = $moreimg != false ? count($moreimg) : 0;
            if ($old_image >= 20) {
                $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>You can add maximum 20 images</span>";
                return;
            }

            $fl = $_FILES['add_more_img'];



            $obj_grp = $_POST['content_group'];
            $obj_id = $content_id;
            $arr['content_id'] = $content_id;
            $arr['content_group'] = sanitize_remove_tags($_POST['content_group']);
            // $arr['color'] = sanitize_remove_tags($_POST['image_color']);

            $file_with_ext = $fl['name'];
            if (!empty($fl['name'])) {
                $only_file_name = filter_name($file_with_ext);
                $only_file_name =  $only_file_name . "_{$obj_id}_{$obj_grp}_" . random_int(100000, 999999);
                $target_dir = RPATH . "/media/images/pages/";
                $file_ext_arr = explode(".", $file_with_ext);
                $ext = end($file_ext_arr);
                $target_file = $target_dir . "{$only_file_name}." . $ext;


                if (($fl['type'] == "image/png" || $fl['type'] == "image/jpeg" || $fl['type'] == "image/jpg" || $fl['type'] == "image/JPEG" || $fl['type'] == "image/JPG" || $fl['type'] == "image/webp")) {
                    if (move_uploaded_file($fl['tmp_name'], $target_file)) {
                        $_SESSION['msg'][] = "File $file_with_ext has been uploaded";
                        $filename = $only_file_name . "." . $ext;
                        $arr['heading'] = "img";
                        $arr['content'] = $filename;
                        $md = new Model('pk_media');
                        $md->store(array('media_file' => $filename, 'dir_name' => "/media/images/pages/" . $filename, 'media_title' => $filename));
                        $this->dbTableObj->store($arr);
                        return true;
                    }
                } else {
                    $_SESSION['msg'][] = "$file_with_ext is invalid file";
                }
            }
        }
    }

    public function add_more_detail()
    {

        if (isset($_POST['add_more_detail']) && isset($_POST['add_more_heading']) && isset($_POST['content_id']) && isset($_POST['content_group'])) {
            if ($_POST['content_id'] == "") {
                $_SESSION['msg'][] = "Content id is required";
                return;
            }
            if (filter_var($_POST['content_id'], FILTER_VALIDATE_INT) == false) {
                $_SESSION['msg'][] = "Content id is invalid";
                return;
            }

            if ($_POST['add_more_heading'] == "") {
                $_SESSION['msg'][] = "Heading should not be empty";
                return;
            }
            if ($_POST['add_more_detail'] == "") {
                $_SESSION['msg'][] = "Description should not be empty";
                return;
            }
            if (!isset($_POST['duration'])) {
                $_SESSION['msg'][] = "Please add duration";
                return;
            }
            if (isset($_POST['is_featured'])) {
                $arr['is_featured'] = 1;
            } else {
                $arr['is_featured'] = 0;
            }
            if (!isset($_POST['duration_unit'])) {
                $_SESSION['msg'][] = "Please select duration unit";
                return;
            }
            if (!isset($_POST['price'])) {
                $_SESSION['msg'][] = "Please add price";
                return;
            }
            $jsnobj = [];
            if (isset($_POST['services'])) {
                $jsnobj['services'] = $_POST['services'];
                $arr['json_obj'] = json_encode($jsnobj);
            }

            $arr['content_id'] = sanitize_remove_tags($_POST['content_id']);
            $arr['content_group'] = sanitize_remove_tags($_POST['content_group']);
            $arr['heading'] = sanitize_remove_tags($_POST['add_more_heading']);
            $arr['duration'] = floatval($_POST['duration']);
            $arr['duration_unit'] = strval($_POST['duration_unit']);
            $arr['price'] = floatval($_POST['price']);
            $arr['content'] = $_POST['add_more_detail'];
            return $this->dbTableObj->store($arr);
        }
    }

    //delete
    public function destroy($id, $csrf = false)
    {
        if (isset($id) && filter_var($id, FILTER_VALIDATE_INT) == true) {
            if ($csrf == true) {
                if (verify_csrf($_POST['csrf_token'], $refresh = true) == false) {
                    $_SESSION['msg'][] = "Invalid CSRF";
                    return false;
                }
            }
            try {
                $pobj = $this->dbTableObj->show($id);
                if (($pobj['content'] != "") && ($pobj['content_group'] == 'product_more_img')) {
                    $target_dir = RPATH . "/media/images/pages/";
                    if (file_exists($target_dir . $pobj['content'])) {
                        unlink($target_dir . $pobj['content']);
                    }
                }
                $this->dbTableObj->destroy($id);
                $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>Item deleted successfully</sapn>";
                return true;
            } catch (Exception $e) {
                $_SESSION['msg'][] = "Item not deleted";
                return false;
            }
        } else {
            return false;
        }
    }
    //update
    public function update_more_detail($id, $csrf = false)
    {
        if (isset($id) && filter_var($id, FILTER_VALIDATE_INT) == true) {
            if ($csrf == true) {
                if (verify_csrf($_POST['csrf_token'], $refresh = true) == false) {
                    $_SESSION['msg'][] = "Invalid CSRF";
                    return false;
                }
            }
            try {
                $pobj = $this->dbTableObj->show($id);
                if (($pobj['content'] != "") && ($pobj['content_group'] == 'product_more_detail')) {
                    $arr['heading'] = $_POST['heading'];
                    $arr['content'] = $_POST['content'];
                    $arr['duration'] = floatval($_POST['duration']);
                    $arr['duration_unit'] = strval($_POST['duration_unit']);
                    $arr['price'] = floatval($_POST['price']);
                    $jsnobj = [];
                    if (isset($_POST['services'])) {
                        $jsnobj['services'] = $_POST['services'];
                        $arr['json_obj'] = json_encode($jsnobj);
                    }
                }
                if (isset($_POST['is_featured'])) {
                    $arr['is_featured'] = 1;
                } else {
                    $arr['is_featured'] = 0;
                }
                $this->dbTableObj->update($id, $arr);
                $_SESSION['msg'][] = "<span class='alert text-white bg-success p-1'>Item updated successfully</sapn>";
                return true;
            } catch (Exception $e) {
                $_SESSION['msg'][] = "<span class='alert text-white bg-danger p-1'>Item not updated</sapn>";
                return false;
            }
        } else {
            return false;
        }
    }
}
