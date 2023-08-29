<?php 
if (!isset($_POST['longitude']) || sanitize_remove_tags($_POST['longitude'])=="") {
    echo js_alert("longitude is required field");
    return;
}
if (!isset($_POST['latitude']) || sanitize_remove_tags($_POST['latitude'])=="") {
    echo js_alert("latitude is required field");
    return;
}
if (!isset($_POST['location_name']) || sanitize_remove_tags($_POST['location_name'])=="") {
    echo js_alert("Location Name is required field");
    return;
}
$locObj = new Model('locations');
$data['longitude'] = $_POST['longitude'];
$data['latitude'] = $_POST['latitude'];
$data['location_name'] = $_POST['location_name'];
$locid = $locObj->store($data);
if (filter_var($locid,FILTER_VALIDATE_INT)) {
    echo js_alert("Location created");
    echo RELOAD;
}