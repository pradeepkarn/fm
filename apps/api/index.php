<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['urlend'] = end($url);
$GLOBALS['urlprev'] = prev($url);
if (count($url)<=1) {
    $sapi_type = php_sapi_name();
    if (substr($sapi_type, 0, 3) == 'cgi')
        header("Status: 404 Not Found");
    else
        header("HTTP/1.1 404 Not Found");
    header("Content-Type: application/json");
    $msg['msg'] = "404, Page not found";
    echo json_encode($msg);
    die();
}
if ($url[0] == "api") {
    if ("{$url[1]}" == "v1") {
        import("apps/api/v1/index.php");
        return;
    }
    if ("{$url[1]}" == "v2") {
        import("apps/api/v2/index.php");
        return;
    }
}