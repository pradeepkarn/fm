<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "cart";
import("apps/plugins/{$plugin_dir}/function.php");
$home = home;
if (authenticate()==true) {
    
}
if (isset($_SESSION['customer_email'])) {
    $mycart = new Model('customer_order');
    $mycart = $mycart->filter_index(array('customer_email'=>$_SESSION['customer_email'],'status'=>'hold'));
    if ($mycart!=false) {
        echo js("location.href='/$home/checkout/hold-items';");
        return;
    }
}
if ($url[0] == "{$plugin_dir}") {
switch ($path) {
    case "{$plugin_dir}":
        import("apps/plugins/{$plugin_dir}/mycart.php");
        break;    
    default:
        if ($url[1]=='ajax-buy-now') {
            if (isset($_POST['item_id']) && filter_var($_POST['item_id'],FILTER_VALIDATE_INT)) {
                $prodid = $_POST['item_id'];
                $product = (new Model('content'))->show($prodid);
                if ($product==false) {
                    die();
                }
                else{
                    //
                    //check item in cart, if yes, qty by 1 only
                    if(isset($_SESSION['cart'])){
                        if(!array_key_exists($prodid,$_SESSION['cart'])){
                            // add_to_cart($prodid);
                            if(add_to_cart($prodid)==false){
                                echo js_alert('Product is out of stock');
                                return;
                            }
                        }
                        echo js("location.href='/$home/$plugin_dir/cart-items';");
                        return;
                    }
                    //if not, create new row in my_order table
                    else{
                        // add_to_cart($prodid);
                        if(add_to_cart($prodid)==false){
                            echo js_alert('Product is out of stock');
                            return;
                        }
                        echo js("location.href='/$home/$plugin_dir/cart-items';");
                        return;
                    }
                }
            }
            die();
        }
        if ($url[1]=='ajax-add-to-cart') {
            if (isset($_POST['item_id']) && filter_var($_POST['item_id'],FILTER_VALIDATE_INT)) {
                $prodid = $_POST['item_id'];
                $product = (new Model('content'))->show($prodid);
                if ($product==false) {
                    die();
                }
                else{
                    if(add_to_cart($prodid)==false){
                        echo js_alert('Product is out of stock');
                        return;
                    }
                    if(isset($_POST['page']) && $_POST['page']=="home"){
                        echo "<h3>Added in cart <i class='fa-solid fa-check'></i></h3>";
                        return;
                    }
                    echo js("location.href='/$home/$plugin_dir/cart-items';");
                }
            }
            die();
        }
        if ($url[1]=='ajax-remove-from-cart') {
            if (isset($_POST['item_id']) && filter_var($_POST['item_id'],FILTER_VALIDATE_INT)) {
                $prodid = $_POST['item_id'];
                $product = (new Model('content'))->show($prodid);
                if ($product==false) {
                    die();
                }
                else{
                    if(isset($_SESSION['cart'])){
                        remove_from_cart($prodid);
                        echo js('location.reload();');
                        return;
                    }
                }
            }
            die();
        }
        else if ($url[1]=='cart-items') {
            import("apps/plugins/{$plugin_dir}/mycart.php");
            break;
        }
          break;
          die();
    }
}
