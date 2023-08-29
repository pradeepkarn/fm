<?php
$home = home; 
// header("Content-Type: image/png");
if (isset($_POST['qrcode_docs_id']) && isset($_POST['qrcode_docs_link'])) {
    $imgsrc = "/".media_root."/docs/{$_POST['qrcode_docs_link']}";
$text = "<a href='$imgsrc' download>Download</a>";
$file = RPATH."/media/qr/qr_{$_POST['qrcode_docs_id']}.png";
$imgsrc = "/".media_root."/qr/qr_{$_POST['qrcode_docs_id']}.png";
// $file = false;
//other parameters
$ecc = 'H';
$pixel_size = 15;
$frame_size = 2;
// Generates QR Code and Save as PNG
QRcode::png($text, $file=$file, $ecc, $pixel_size, $frame_size);
echo "<a target='_blank' href='/$home/generate-qr-code/?qrcode_docs_id={$_POST['qrcode_docs_id']}&qrcode_docs_link={$_POST['qrcode_docs_link']}'><img id='qrcode_img{$_POST['qrcode_docs_id']}' src='$imgsrc'></a>";
return;
}
if (isset($_GET['qrcode_docs_id']) && isset($_GET['qrcode_docs_link'])) {
header("Content-Type: image/png");
$imgsrc = media_root."/docs/{$_GET['qrcode_docs_link']}";
$domain = MY_DOMAIN;
$text = "/$imgsrc";
$ecc = 'H';
$pixel_size = 15;
$frame_size = 2;
// Generates QR Code and Save as PNG
QRcode::png($text, $file=false, $ecc, $pixel_size, $frame_size);
return;
}