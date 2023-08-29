<?php
function myprint($data = null)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}
function pkAjax($button, $url, $data, $response, $event = 'click', $method = "post", $progress = false, $return = false)
{
  $progress_code = "";
  if ($progress == true) {
    $progress_code = "xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                  $('.progress-bar').width(percentComplete + '%');
                  $('.progress-bar').html(percentComplete+'%');
              }
          }, false);
          return xhr;
          },";
  }
  $home = home;
  $ajax = "<script>
  $(document).ready(function() {
      $('{$button}').on('{$event}',function(event) {
          event.preventDefault();
          if (typeof tinyMCE != 'undefined') {
            tinyMCE.triggerSave();
          }
          $.ajax({
              $progress_code
              url: '/{$home}{$url}',
              method: '$method',
              data: $('{$data}').serializeArray(),
              dataType: 'html',
              success: function(resultValue) {
                  $('{$response}').html(resultValue)
              }
          });
      });
  });
  </script>";
  if ($return == true) {
    return $ajax;
  }
  echo $ajax;
}
function pkAjax_form($button, $data, $response, $event = 'click', $progress = false)
{
  $progress_code = "";
  if ($progress == true) {
    $progress_code = "xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                  $('.progress-bar').width(percentComplete + '%');
                  $('.progress-bar').html(percentComplete+'%');
              }
          }, false);
          return xhr;
          },";
  }
  $ajax = "<script>
  $(document).ready(function (e) {
    $('{$data}').on('submit',(function(e) {
        e.preventDefault();
        if (typeof tinyMCE != 'undefined') {
          tinyMCE.triggerSave();
        }
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          $progress_code
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(resultValue){
              $('{$response}').html(resultValue)
            }
        });
    }));
    $('{$button}').on('{$event}', function() {
      $('{$data}').submit();
  });
});
</script>";
  echo $ajax;
}
function get_content_by_slug($slug)
{
  $obj = new Model('content');
  $cont =  $obj->filter_index(array('slug' => $slug, 'content_group' => 'page'));
  if (count($cont) == 1) {
    return $cont[0];
  } else {
    return false;
  }
}
function generate_username_by_email($email, $try = 100)
{
  if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
    $db = new Model('pk_user');
    $arr['email'] = sanitize_remove_tags($email);
    $emailarr = explode("@", $arr['email']);
    $username = $emailarr[0];
    $dbusername = $db->exists(array('username' => $username));
    if ($dbusername == true) {
      $i = 1;
      while ($dbusername == true) {
        $dbusername = $db->exists(array('username' => $username . $i));
        if ($dbusername == false) {
          return $username . $i;
        }
        if ($i == $try) {
          break;
        }
        $i++;
      }
    } else {
      return $username;
    }
  } else {
    return false;
  }
}
function generate_username_by_email_trans($email, $try = 100, $db = null)
{
  if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
    if ($db == null) {
      $db = new Dbobjects;
    }
    $db->tableName = 'pk_user';
    $arr['email'] = sanitize_remove_tags($email);
    $emailarr = explode("@", $arr['email']);
    $username = $emailarr[0];
    $dbusername = $db->filter(array('username' => $username));
    if (count($dbusername) > 0) {
      $i = 1;
      while (count($dbusername) > 0) {
        $dbusername = $db->filter(array('username' => $username . $i));
        if (count($dbusername) > 0) {
          return $username . $i;
        }
        if ($i == $try) {
          break;
        }
        $i++;
      }
    } else {
      return $username;
    }
  } else {
    return false;
  }
}
function generate_dummy_email($prefix = null)
{
  return rand(1000, 9999) . "_" . uniqid($prefix) . "@example.com";
}
function bsmodal($id = "", $title = "", $body = "", $btn_id, $btn_text = "Action", $btn_class = "btn btn-primary", $size = "modal-sm", $modalclasses = "")
{
  $str = "
<div class='modal fade' id='$id' tabindex='-1' aria-hidden='true'>
<div class='modal-dialog $size'>
<div class='modal-content'>
<div class='modal-header'>
    <h5 class='modal-title'>$title</h5>
    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
</div>
<div class='modal-body'>
$body
</div>
<div class='modal-footer'>
    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
    <button type='button' id='$btn_id' class='$btn_class'>$btn_text</button>
</div>
</div>
</div>
</div>";
  return $str;
}
function popmodal($id = "", $title = "", $body = "", $btn_id, $btn_text = "Action", $btn_class = "btn btn-primary", $size = "modal-sm", $close_btn_class = "")
{
  $str = "
<div class='modal fade' id='$id' tabindex='-1' aria-hidden='true'>
<div class='modal-dialog $size'>
<div class='modal-content'>
<div class='modal-header'>
    <h5 class='modal-title'>$title</h5>
    <button type='button' class='$close_btn_class btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
</div>
<div class='modal-body'>
$body
</div>
<div class='modal-footer'>
    <button type='button' class='$close_btn_class btn btn-secondary' data-bs-dismiss='modal'>Close</button>
    <button type='button' id='$btn_id' class='$btn_class'>$btn_text</button>
</div>
</div>
</div>
</div>";
  return $str;
}
function generate_slug($slug, $try = 1000)
{
  if ($slug !== "") {
    $db = new Model('content');
    $slug = str_replace(" ", "-", sanitize_remove_tags($slug));
    $dbslug = $db->exists(array('slug' => $slug));
    if ($dbslug == true) {
      $i = 1;
      while ($dbslug == true) {
        $dbslug = $db->exists(array('slug' => $slug . $i));
        if ($dbslug == false) {
          return $slug . $i;
        }
        if ($i == $try) {
          return false;
          break;
        }
        $i++;
      }
    } else {
      return $slug;
    }
  } else {
    return false;
  }
}
function ajaxLoad($loadId)
{
  $ajax = "<script>
$(document).ready(function() {
          
  $(document).ajaxStart(function(){
  $('{$loadId}').css('display', 'block');
});
$(document).ajaxComplete(function(){
  $('{$loadId}').css('display', 'none');
});
});
</script>";
  echo $ajax;
}
function ajaxLoadModal($loadId)
{
  $ajax = "<script>
$(document).ready(function() {
          
  $(document).ajaxStart(function(){
  $('{$loadId}').modal('show');
});
$(document).ajaxComplete(function(){
  $('{$loadId}').modal('hide');
});
});
</script>";
  echo $ajax;
}
function ajaxActive($qry)
{
  $ajax = "<script>
$(document).ready(function() {
  $('{$qry}').css({'visibility':'hidden'});
  $(document).ajaxStart(function(){
  $('{$qry}').css({'visibility':'visible'});
});
$(document).ajaxComplete(function(){
  $('{$qry}').css({'visibility':'hidden'});
});
});
</script>";
  echo $ajax;
}
function removeSpace($str)
{
  $str = str_replace(" ", "_", sanitize_remove_tags($str));
  $str = str_replace("/", "_", $str);
  $str = str_replace("\\", "_", $str);
  $str = str_replace("&", "_", $str);
  $str = str_replace(";", "", $str);
  $str = str_replace(";", "", $str);
  $str = strtolower($str);
  return $str;
}
function filter_name($file_with_ext = "")
{
  $only_file_name = pathinfo($file_with_ext, PATHINFO_FILENAME);
  $only_file_name =  sanitize_remove_tags(str_ireplace(" ", "_", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("(", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace(")", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("'", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("\"", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("&", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace(";", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("#", "", $only_file_name));
  return $only_file_name;
}
function getAccessLevel()
{
  if (isset($_SESSION['user_id'])) {
    $db = new Dbobjects();
    $db->tableName = "pk_user";
    $qry['id'] = $_SESSION['user_id'];
    $db->insertData = $qry;
    if (count($db->filter($qry)) != 0) {
      return $db->pk($_SESSION['user_id'])['access_level'];
    } else {
      false;
    }
  } else {
    false;
  }
}
function updateMyProfile()
{
  if (isset($_SESSION['user_id'])) {
    $db = new Mydb('pk_user');
    if (isset($_POST['update_profile_by_admin'])) {
      $qry['id'] = $_POST['update_profile_by_admin'];
    } else {
      $qry['id'] = $_SESSION['user_id'];
    }
    if (isset($_POST['password']) && ($_POST['password'] != "")) {
      $qry['password'] = md5($_POST['password']);
    }


    if (count($db->filterData($qry)) > 0) {
      if (isset($_POST['update_my_profile'])) {
        $upqry['name'] = sanitize_remove_tags($_POST['my_name']);
        $upqry['mobile'] = sanitize_remove_tags($_POST['my_mobile']);
        $upqry['updated_at'] = date('y-m-d h:m:s');
        $db->updateData($upqry);
      }
    } else {
      false;
    }
  } else {
    false;
  }
}

function getTableRowById($tablename, $id)
{
  $db = new Mydb($tablename);
  $qry['id'] = $id;
  if (count($db->filterData($qry)) > 0) {
    return $db->pkData($id);
  } else {
    false;
  }
}
function check_slug_globally($slug = null)
{
  $count = 0;
  $var = ['categories', 'content'];
  for ($i = 0; $i < count($var); $i++) {
    $db = new Dbobjects();
    $db->tableName = $var[$i];
    $qry['slug'] = $slug;
    $count += count($db->filter($qry));
  }
  return $count;
}

function all_books($ord = "DESC", $limit = 100, $post_cat = "", $catid = "")
{
  $novels = array();
  $novelobj = new Model('content');
  $arr['content_group'] = 'book';
  if ($post_cat != "") {
    $arr['post_category'] = $post_cat;
  }
  if ($catid != "") {
    $arr['parent_id'] = $catid;
  }
  $novels = $novelobj->filter_index($arr, $ord, $limit);
  if ($novels == false) {
    $novels = array();
  }
  return $novels;
}
function all_cats()
{
  $novels = array();
  $novelobj = new Model('content');
  $arr['content_group'] = 'listing_category';
  $novels = $novelobj->filter_index($arr);
  if ($novels == false) {
    $novels = array();
  }
  return $novels;
}
function js_alert($msg = "")
{
  return "<script>alert('{$msg}');</script>";
}
function js($msg = "")
{
  return "<script>{$msg}</script>";
}
function matchData($var1 = "null", $var2 = "null", $print = "Pradeep Karn")
{
  if ($var1 == $var2) {
    echo $print;
  }
}
function views($post_category = 'general', $cont_type = 'post')
{
  $views = array();
  $db = new Mydb('content');
  $data = $db->filterData(['post_category' => $post_category, 'content_type' => $cont_type]);
  foreach ($data as $key => $value) {
    $views[] = $value['views'];
  }
  $views = array_sum($views);
  return $views;
}
function pk_excerpt($string = null, $limit = 50, $strip_tags = true)
{
  if ($strip_tags === true) {
    $string = strip_tags($string);
  }
  if (strlen($string) > $limit) {
    // truncate string
    $stringCut = substr($string, 0, $limit);
    $endPoint = strrpos($stringCut, ' ');
    //if the string doesn't contain any space then it will cut without word basis.
    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    $string = $string . "...";
  }
  return $string;
}
function filterUnique($table, $col, $ord = "DESC")
{
  $db = new Mydb($table);
  if (count($db->filterDistinct($col)) > 0) {
    return $db->filterDistinct($col, $ord, 100000);
  } else {
    return false;
  }
}
//categories start
function create_category()
{

  global $conn;
  $parent_id = legal_input($_POST['parent_id']);
  $category_name = legal_input($_POST['category_name']);
  $catdb = new Model('content');
  $arr['title'] = $category_name;
  $arr['parent_id'] = $parent_id;
  $new_cat_id = $catdb->store($arr);
  // $query=$conn->prepare("INSERT INTO categories (parent_id, category_name) VALUES (?,?)");
  // $query->bind_param('is',$parent_id,$category_name);
  // $exec= $query->execute();
  if ($new_cat_id != false) {
    return $new_cat_id;
  } else {
    return false;
  }
}

function multilevel_categories($parent_id = 0, $radio = true, $category_group = "listing_category")
{
  $catdb = new Model('content');
  $exec = $catdb->filter_index(array('parent_id' => $parent_id, 'content_group' => $category_group));
  $catData = [];
  if ($exec != false) {
    foreach ($exec as $key => $row) {
      $catData[] = [
        'id' => $row['id'],
        'parent_id' => $row['parent_id'],
        'category_name' => $row['title'],
        'nested_categories' => multilevel_categories($row['id'], $radio, $category_group),
        'radio' => $radio
      ];
    }

    return $catData;
  } else {
    return $catData = [];
  }
}

function display_list($nested_categories)
{
  $rd = null;
  $home = home;
  $list = '<ul class="list-none">';
  foreach ($nested_categories as $nested) {
    if ($nested['radio'] == true) {
      $rd = '<input type="radio" name="parent_id" value=' . $nested['id'] . '> ';
    }
    $list .= '<li>' . $rd . "<a href='/{$home}/admin/categories/edit/{$nested['id']}' class='text-deco-none'>" . $nested['category_name'] . '</a></li>';
    if (!empty($nested['nested_categories'])) {
      $list .= display_list($nested['nested_categories']);
    }
  }
  $list .= '</ul>';
  return $list;
}

function display_option($nested_categories, $mark = ' ')
{
  $option = null;
  foreach ($nested_categories as $nested) {

    $option .= '<option value="' . $nested['id'] . '">' . $mark . $nested['category_name'] . '</option>';

    if (!empty($nested['nested_categories'])) {
      $option .= display_option($nested['nested_categories'], $mark . '-');
    }
  }
  return $option;
}
function getData($table, $id)
{
  return (new Model($table))->show($id);
}
// convert illegal input to legal input
function legal_input($value)
{
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);
  return $value;
}
function getCatTree($parent_id)
{
  $db = new Model('content');
  $listings = $db->filter_index(array('content_group' => 'listing_category', 'parent_id' => $parent_id), $ord = "DESC", $limit = "1000", $change_order_by_col = "");
  if ($listings == false) {
    $listings = array();
  }
  $listing_data = array();
  foreach ($listings as $key => $uv) {
    $listing_data[] = array(
      'id' => $uv['id'],
      'title' => $uv['title'],
      'info' => $uv['content_info'],
      'description' => $uv['content'],
      'image' => "/media/images/pages/" . $uv['banner'],
      'category' => ($uv['parent_id'] == 0) ? 'Main' : getData('content', $uv['parent_id'])['title'],
      'status' => $uv['status'],
      'child' => getCatTree($uv['id'])
    );
  }
  return $listing_data;
}
//cart count
$GLOBALS['cart_cnt'] = 0;
// if (authenticate()===true) {
//    $cartObj = new Model('my_order');
//    $mycart = $cartObj->filter_index(array('user_id'=>$_SESSION['user_id'],'status'=>'cart'));
//    if ($mycart==false) {
//     $mycart = array();
//    }
//    $GLOBALS['cart_cnt'] = count($mycart);
// }

if (isset($_SESSION['cart'])) {
  $GLOBALS['cart_cnt'] = count($_SESSION['cart']);
}
function change_my_banner($contentid, $banner, $banner_name = "img")
{
  if (isset($banner)) {
    $file = $banner;
    $media_folder = "images/pages";
    $imgname = $banner_name;
    $media = new Media();
    $page = new Dbobjects();
    $page->tableName = 'content';
    $pobj = $page->pk($contentid);
    $target_dir = RPATH . "/media/images/pages/";
    if ($pobj['banner'] != "") {
      if (file_exists($target_dir . $pobj['banner'])) {
        unlink($target_dir . $pobj['banner']);
        $_SESSION['msg'][] = "Old image was replaced";
      }
    }
    $file_ext = explode(".", $file["name"]);
    $ext = end($file_ext);
    $page->insertData['banner'] = $imgname . "." . $ext;
    $page->update();
    $media->upload_media($file, $media_folder, $imgname, $file['type']);
  }
}

function user_data_by_token($token, $col = 'email')
{
  $user = new Model('pk_user');
  $arr['app_login_token'] = $token;
  $user = $user->filter_index($arr);
  if (!count($user) > 0) {
    return false;
  } else {
    return $user[0][$col];
  }
}

function nested_array_unique($nested_array)
{
  $flattened = array_map('serialize', $nested_array);
  $flattened = array_unique($flattened);
  return array_map('unserialize', $flattened);
}

function num_to_words($number)
{
  $no = floor($number);
  $point = round($number - $no, 2) * 100;
  $hundred = null;
  $digits_1 = strlen($no);
  $i = 0;
  $str = array();
  $words = array(
    '0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety'
  );
  $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
  while ($i < $digits_1) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += ($divider == 10) ? 1 : 2;
    if ($number) {
      $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
      $hundred = ($counter == 1 && $str[0]) ? ' ' : null;
      $str[] = ($number < 21) ? $words[$number] .
        " " . $digits[$counter] . $plural . " " . $hundred
        :
        $words[floor($number / 10) * 10]
        . " " . $words[$number % 10] . " "
        . $digits[$counter] . $plural . " " . $hundred;
    } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " .
    $words[$point = $point % 10] : '';
  //  echo $result . "Rupees  " . $points . " Paise";
  return $result;
}
function view_count($book_id)
{
  $db = new Dbobjects;
  $sql = "SELECT SUM(qty) as view
  FROM content 
  WHERE content_group = 'chapter' and qty >  0 and parent_id = $book_id";
  if (count($db->show($sql)) > 0) {
    return ($db->show($sql)[0])['view'];
  } else {
    return 0;
  }
}

function img_or_null($img = null)
{
  if ($img == "") {
    return null;
  }
  if (file_exists(MEDIA_ROOT . "images/pages/" . $img)) {
    return "/media/images/pages/" . $img;
  }
}
function dp_or_null($img = null)
{
  if ($img == "") {
    return null;
  }
  if (file_exists(MEDIA_ROOT . "images/profiles/" . $img)) {
    return "/media/images/profiles/" . $img;
  }
}

function get_content_by_seler_comapny($created_by = null)
{
  $obj = new Model('content');
  if ($created_by == null) {
    return $obj->filter_index(array("content_group" => 'company'));
  }
  return $obj->filter_index(array("content_group" => 'company', 'created_by' => $created_by));
}
function obj($arr)
{
  return (object) $arr;
}
function arr($obj)
{
  return (array) $obj;
}
function go_to($link = "")
{
  $home = home;
  $var = <<<RED
            <script>
                location.href="/$home/$link";
            </script>
            RED;
  return $var;
}
function get_user_by_token($token = null)
{
  $user = (new Model('pk_user'))->filter_index(array('app_login_token' => $token));
  if (count($user) > 0) {
    $u = (object) $user[0];
    $email = $u->email;
    $emlarr = explode("@", $u->email);
    if (end($emlarr) == 'example.com') {
      $email = null;
    }
    return array(
      "id" => $u->id,
      "first_name" => $u->first_name,
      "last_name" => $u->last_name,
      "mobile" => $u->mobile,
      "email" => $email,
      "dob" => $u->dob,
      "gender" => $u->gender,
      "image" => $u->image,
      "user_group" => $u->user_group,
      "updated_at" => $u->updated_at
    );
  } else {
    return false;
  }
}

function row_xists($table, $query)
{
  return (new Model($table))->exists($query);
}

function upload_file($ext_arr = [], $file, $media_dir = "images/pages/", $any_name)
{
  if ($file['name'] != "" && $file['error'] == UPLOAD_ERR_OK) {
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (in_array($ext, $ext_arr)) {
      $imgname = str_replace(" ", "_", $any_name) . uniqid("_") . "." . $ext;
      $dir = MEDIA_ROOT . $media_dir . $imgname;
      $upload = move_uploaded_file($file['tmp_name'], $dir);
      if ($upload) {
        return $imgname;
      }
      return false;
    }
    return false;
  }
  return false;
}
function is_fav_content($user_id, $content_id)
{
  $coObj = new Model('bookmarks');
  $ord = $coObj->filter_index(['user_id' => $user_id, 'content_id' => $content_id, 'content_group' => 'fav']);
  if (count($ord) > 0) {
    return true;
  } else {
    return false;
  }
}

function msg_ssn($var = 'msg', $return = false)
{
  if (isset($_SESSION[$var])) {
    if ($return == true) {
      $returnmsg = null;
      foreach ($_SESSION[$var] as $msg) {
        $returnmsg .= "{$msg}\\n";
      }
      unset($_SESSION[$var]);
      return $returnmsg;
    }
    foreach ($_SESSION[$var] as $msg) {
      echo "{$msg}<br>";
    }
    unset($_SESSION[$var]);
  }
}

function emaillog($msg = "")
{
  $file = MEDIA_ROOT . "docs/email.log";
  $log_file = fopen($file, 'a');
  $message = date('Y-m-d H:i:s') . " $msg\n";
  fwrite($log_file, $message);
  fclose($log_file);
}

// coupon area
function if_coupon_is_used($cpcode, $userid)
{
  $obj = new Model('service_booking');
}
function colpon_list_glb($group = null)
{
  $proms = new Model('coupons');
  if ($group == null) {
    return $proms->index();
  } else {
    return $proms->filter_index(array('coupon_group' => $group));
  }
}
function colpon_detail_glb($id)
{
  $proms = new Model('coupons');
  return $proms->show($id);
}
function colpon_detail_by_code_glb($code)
{
  $proms = new Model('coupons');
  $cpns = $proms->filter_index(array('code' => $code));
  if (count($cpns) > 0) {
    return $cpns[0];
  } else {
    return false;
  }
}


function get_discounted_coupon_amt($amount, $code, $user_id, $obj = null)
{
  $data['msg'] = null;
  $data['amt'] = 0;
  $discamt = 0;
  if ($obj == null) {
    $obj = new Dbobjects;
  }
  $proms = $obj;

  $tessql = "select * from salon_bookings where coupon = '$code' and status <> 'cancelled' and user_id = $user_id;";
  $cpn = $obj->show($tessql);
  if (count($cpn) > 0) {
    $msg = "Coupon already used";
    $data['msg'] = $msg;
    $data['amt'] = 0;
    return $data;
  }

  $proms->tableName = 'coupons';
  $cpns = $proms->filter(array('code' => $code));
  if (count($cpns) > 0) {

    $cp = $cpns[0];
    if ($cp['expiry_date'] < date('Y-m-d H:i:s')) {
      $msg = "Coupon expired";
      $data['msg'] = $msg;
      $data['amt'] = 0;
      return $data;
    }
    $dvl = $cp['discount_value'];
    $dtyp = $cp['discount_type'];
    if ($amount >= $cp['min_purchase_amt']) {
      if ($dtyp == "%") {
        $discamt = round(($amount * $dvl * 0.01), 2);
      } else {
        $discamt = $dvl;
      }
      $msg = "Coupon applied";
    } else {
      $msg = "Coupon not applied for this amount";
      $discamt = 0;
    }
    $data['msg'] = $msg;
    $data['amt'] = $discamt;
    return $data;
  } else {
    $msg = "Invalid coupon";
    $data['msg'] = $msg;
    $data['amt'] = $discamt;
    return $data;
  }
}
// Coupon area end
function email_has_valid_dns($email = 'email@example.com'): bool
{
  return (new Email_validator_lcl)->validate($email);
}
function day_check($openings, $day)
{
  $defaultTime = '00:00'; // Default time if the day is not found
  $day = strtolower($day); // Convert the input day to lowercase for case-insensitive matching

  foreach ($openings as $timing) {
    if ($timing['day'] === $day) {
      return (object)[
        'open_day' => true,
        'open_time' => $timing['open'],
        'close_time' => $timing['close']
      ];
    }
  }

  return (object)[
    'open_day' => false,
    'open_time' => $defaultTime,
    'close_time' => $defaultTime
  ];
}

function showStars($rating)
{
  $maxRating = 5;
  $roundedRating = round($rating * 2) / 2; // Round to nearest 0.5

  $starsHtml = '';
  for ($i = 0; $i < $maxRating; $i++) {
    if ($i < $roundedRating) {
      $starsHtml .= '★'; // Full star
    } else if ($i == floor($roundedRating) && $roundedRating % 1 !== 0) {
      $starsHtml .= '½'; // Half star
    } else {
      $starsHtml .= '☆'; // Empty star
    }
  }

  return $starsHtml;
}

function msg_set($msg, $var = 'msg')
{
  $_SESSION[$var][] = $msg;
}
