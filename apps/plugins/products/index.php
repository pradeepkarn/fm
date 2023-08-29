<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "products";
$content_group = "product";
import("apps/plugins/{$plugin_dir}/function.php");

if ("{$url[0]}/{$url[1]}" == "admin/$plugin_dir") {
    switch ($path) {
        case "admin/$plugin_dir":
            if (isset($_POST['add_new_content'])) {
                $pageid = addContent($type = $content_group);
                if ($pageid == false) {
                    echo js_alert("Duplicate slug, Change slug");
                }
            }
            import("apps/plugins/{$plugin_dir}/show_contents.php");
            break;

        case "admin/{$plugin_dir}/edit/{$GLOBALS['url_last_param']}":
            if (isset($_POST['update_banner'])) {
                $contentid = $_POST['update_banner_page_id'];
                $banner = $_FILES['banner'];
                $banner_name = time() . uniqid("_banner_") . USER['id'];
                change_my_banner($contentid = $contentid, $banner = $banner, $banner_name = $banner_name);
            }
            import("apps/plugins/{$plugin_dir}/edit_content.php");
            break;
        case "admin/{$plugin_dir}/edit/{$GLOBALS['url_2nd_last_param']}/update":
            if (isset($_POST['page_id']) && isset($_POST['update_page'])) {
                if (updatePage() === true) {
                    echo js_alert("Update");
                    echo js("location.reload();");
                }
            }
            break;
        case "admin/{$plugin_dir}/delete/{$GLOBALS['url_last_param']}":
            if (is_superuser() == false) {
                header("Location:/" . home . "/admin/{$plugin_dir}");
            } else {
                if (delContent($id = $GLOBALS['url_last_param']) != false) {
                    echo js_alert("Deleted Successfully");
                    header("Location:/" . home . "/admin/{$plugin_dir}");
                } else {
                    echo js_alert("Invalid activity");
                    header("Location:/" . home . "/admin/{$plugin_dir}");
                }
            }
            break;
        default:
            if (count($url) >= 3) {
                if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/add-more-img") {
                    if (isset($_FILES['add_more_img']) && $_FILES['add_more_img']['name'] != "") {
                        import("apps/controllers/ContentDetailsCtrl.php");
                        $listObj = new ContentDetailsCtrl;
                        if ($listObj->add_more_img() == true) {
                            echo js_alert('Uploaded');
                            msg_ssn("msg");
                            echo js('location.reload();');
                            return;
                        } else {
                            echo js_alert('Not updated');
                            msg_ssn("msg");
                            return;
                        }
                        msg_ssn("msg");
                        return;
                    }
                    break;
                }
                if ($url[2] == 'remove-this-review-ajax') {
                    if(isset($_POST['review_id'])){
                        if (is_superuser()) {
                            (new Model('bookmarks'))->destroy($_POST['review_id']);
                            echo RELOAD;
                        };
                    }
                    return;
                }
                if ($url[2] == 'remove-this-dm-review-ajax') {
                    if(isset($_POST['dm_review_id'])){
                        if (is_superuser()) {
                            (new Model('review'))->destroy($_POST['dm_review_id']);
                            // myprint($_POST);
                            echo RELOAD;
                        };
                    }
                    return;
                }
                if ($url[2] == 'add-review-ajax') {
                    if(isset($_POST['salon_id'])){
                        if (is_superuser()) {
                            $db = new Dbobjects;
                            $db->tableName = "review";
                            $arr['name'] = sanitize_remove_tags($_POST['name_of_user']);
                            $arr['message'] = sanitize_remove_tags($_POST['review_message']);
                            $arr['rating'] = intval($_POST['star_point']);
                            $arr['email'] = generate_dummy_email('usr');
                            $arr['item_id'] = $_POST['salon_id'];
                            $arr['item_group'] = $_POST['salon'];
                            $arr['status'] = "published";
                            $db->insertData = $arr;
                            try {
                                $db->create();
                                $_SESSION['msg'][] = "Review added";
                                echo msg_ssn(return:true);
                                echo RELOAD;
                                exit;
                            } catch (PDOException $th) {
                                $_SESSION['msg'][] = "Not added";
                                echo msg_ssn(return:true);
                                exit;
                            }
                            
                        };
                    }
                    return;
                }
                if ($url[2] == 'add-new-item') {
                    import("apps/plugins/{$plugin_dir}/add-new-item.php");
                    return;
                }
                if ($url[2] == 'add-new-item-ajax') {
                    if ($_POST['page_title'] == "") {
                        echo js_alert('Empty name is not allowed');
                        return;
                    }
                    if ($_FILES['banner']['name'] == "") {
                        echo js_alert('Please choose a product image');
                        return;
                    }
                    // print_r($_POST);
                    $pageid = addContent($type = $content_group);

                    if (isset($_FILES['banner']) && $_FILES['banner']["error"] == 0 && filter_var($pageid, FILTER_VALIDATE_INT)) {
                        $contentid = $pageid;
                        $banner = $_FILES['banner'];
                        $banner_name = time() . uniqid("_banner_") . USER['id'];
                        change_my_banner($contentid = $contentid, $banner = $banner, $banner_name = $banner_name);
                    }
                    if (filter_var($pageid, FILTER_VALIDATE_INT)) {
                        echo js_alert('added');
                        $home = home;
                        echo js("location.href='/$home/admin/$plugin_dir/edit/$pageid';");
                    }
                    return;
                }
                if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/add-more-detail") {
                    if (isset($_POST['add_more_detail']) && isset($_POST['add_more_heading']) && isset($_POST['content_id']) && isset($_POST['content_group'])) {
                        import("apps/controllers/ContentDetailsCtrl.php");
                        $listObj = new ContentDetailsCtrl;
                        if ($listObj->add_more_detail() == true) {
                            echo js_alert('Added');
                            echo js('location.reload();');
                            return;
                        } else {
                            echo js_alert(msg_ssn(return: true));
                            echo js_alert('Not added');
                            return;
                        }
                        msg_ssn("msg");
                        return;
                    }
                    break;
                }
                if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/delete-content-details") {
                    if (isset($_POST['content_details_delete_id'])) {
                        import("apps/controllers/ContentDetailsCtrl.php");
                        $listObj = new ContentDetailsCtrl;
                        if ($listObj->destroy($_POST['content_details_delete_id']) == true) {
                            echo js('location.reload();');
                        } else {
                            echo js_alert('Not Deleted');
                        }
                        msg_ssn("msg");
                        return;
                    }
                    break;
                }
                if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/update-content-details-ajax") {
                    if (isset($_POST['content_detail_id'])) {
                        import("apps/controllers/ContentDetailsCtrl.php");
                        $listObj = new ContentDetailsCtrl;
                        if ($listObj->update_more_detail($_POST['content_detail_id']) == true) {
                            echo js('location.reload();');
                            exit;
                        } else {
                            echo js_alert('Not Deleted');
                        }
                        msg_ssn("msg");
                        return;
                    }
                    break;
                }
                if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/color-delete-ajax") {
                    if (isset($_POST['pid'])) {
                        if (removeColorList($_POST['pid'], $_POST['color_delete']) == true) {
                            echo js('location.reload();');
                        } else {
                            echo js_alert('Not Deleted');
                        }
                        msg_ssn("msg");
                        return;
                    }
                    break;
                }
            }
            if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/get-user-list-ajax") {
                $prodObj = new Model('pk_user');
                // $employees = $userObj->index();
                $search_data = sanitize_remove_tags($_POST['code']);
                $arr['mobile'] = $search_data;
                $obj = $prodObj->filter_index($arr);
                if (count($obj) > 0) {
                    $mbl = $obj[0]['mobile'];
                    $vndrid = $obj[0]['id'];
                    if ($obj[0]['user_group'] == 'vendor' || $obj[0]['user_group'] == 'admin') {
                        $vendor = <<<USR
                        <input checked type="radio" name="vendor_id" value="$vndrid"> <b>$mbl</b>
                    USR;
                        echo $vendor;
                    }else{
                        echo "Please enter vendor mobile";
                    }
                }
                return;
            }
            // if ($url[1]=='delete') {
            //     if (is_superuser()===false) {
            //         header("Location:/".home);
            //       }
            //       else{
            //         if(delContent($id=$GLOBALS['url_last_param']) != false){
            //             // echo js_alert("Deleted Successfully");
            //             if ($GLOBALS['url_2nd_last_param']!='page') {
            //                 header("Location:/".home."/{$plugin_dir}/{$GLOBALS['url_2nd_last_param']}");
            //                 // echo js('location.href=/'.home.'/'.$GLOBALS['url_2nd_last_param']);
            //             }
            //             else{
            //                 header("Location:/".home."/{$plugin_dir}");
            //             }

            //         }
            //         else{
            //             echo js_alert("Invalid activity");
            //             header("Location:/".home."/{$plugin_dir}");
            //         }
            //       }
            //     break;
            // }
            import("apps/view/404.php");
            break;
    }
}
