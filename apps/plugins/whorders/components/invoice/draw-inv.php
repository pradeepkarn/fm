<?php 

import("phpqrcode/qrlib.php");
header("Content-type: text/html");
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");
if (isset($_GET['tid'])) {
    $ord = get_order_by_uinique_id($uid = $_GET['tid'])[0];
    // echo "<pre>";
    // print_r($ord);
    // echo "</pre>";
}
$home = home;
// name color code #3AB548, course name color code 116, 116, 116,


$template = RPATH."/media/inv_templates/low-invoice.png";


$font = RPATH."/static/fonts/Myriad-Pro-Bold-SemiCondensed.otf";
$font_tranng = RPATH."/static/fonts/NeueFrutigerWorld-Regular.ttf";

$fontsize = 18;

$candName = pk_excerpt($ord['name'],35);
$idNumber = "";
$storename = "Mashail Al-Qasr";

$certNumber = strtoupper($_GET['tid']);

$cust_vat = "1234567890";
$inv_num = strtoupper($_GET['tid']);

// price

// qty
if (isset($_POST['cand_name'])) {
    $candName = $_POST['cand_name'];
    if (trim($_POST['cand_name'])=="") {
        $candName = "No Name";
    }
}
if (isset($_POST['course_id'])) {
    $crs = getData('content',$_POST['course_id']);
    $time_unit = $crs['is_offline']?"Days":"Hours";
    $training_hrs = "Training Hours: ".$crs['course_duration'] ." ". $time_unit;


    $time_start=strtotime($crs['start_date']);
    $month_start=date("F",$time_start);
    $year_start=date("Y",$time_start);

    $time_end=strtotime($crs['end_date']);
    $month_end=date("F",$time_end);
    $year_end=date("Y",$time_end);

    $training_hrs2 = "$month_start/$month_end $year_end";
}

if (isset($_POST['cand_id']) && isset($_POST['cart_id'])) {
    $candid = sanitize_remove_tags($_POST['cand_id']);
    $cartid = sanitize_remove_tags($_POST['cart_id']);
    $certNumber = "certificate_".$candid."_".$cartid;
}


function imagecreatefromfile( $filename ) {
    if (!file_exists($filename)) {
        throw new InvalidArgumentException('File "'.$filename.'" not found.');
    }
    switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
        case 'jpeg':
            return imagecreatefromjpeg($filename);
        break;

        case 'jpg':
            return imagecreatefromjpeg($filename);
        break;

        case 'png':
            return imagecreatefrompng($filename);
        break;

        case 'gif':
            return imagecreatefromgif($filename);
        break;

        default:
            throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
        break;
    }
}
$canvas = imagecreatefrompng($template);



$canvas_width  = imagesx($canvas);
$canvas_height  = imagesy($canvas);
// $ratio = $canvas_height/$canvas_width;

// $canvas_width = $canvas_width*(0.25);
// $canvas_height = $ratio*$canvas_width;

$color = imagecolorallocate($canvas,58, 181, 72);



//candidate name
$size = 40;
$namlen = strlen($candName);
// if ($namlen>=30) {
//     $size = 50;
//     // $candName_arr = str_split($candName,15);
// }
// if ($namlen>=40) {
//     $size = 50;
//     // $candName_arr = str_split($candName,20);
// }
// if ($namlen>=50) {
//     $size = 50;
//     // $candName_arr = str_split($candName,25);
// }
// $size = 150;

// Customer name
$candName = wordwrap($candName,200,"\n");
$bbox = imagettfbbox($size, 0, $font, $candName);
// $cand_name_x = ($canvas_width / 2) - ($bbox[4] / 2);
$cand_name_x = 400;
imagettftext($canvas,$size,0,$cand_name_x,730,$color=$color,$font_filename=$font,$text=$candName);



// store name
$size = 40;
$crsname = strlen($storename);
// if ($crsname>=30) {
//     $size = 18;
//     // $storename_arr = str_split($storename,15);
// }
// if ($crsname>=40) {
//     $size = 18;
//     // $storename_arr = str_split($storename,20);
// }
// if ($crsname>=50) {
//     $size = 18;
//     // $storename_arr = str_split($storename,25);
// }

// $crs_color = imagecolorallocate($canvas,116, 116, 116);
$crs_color  = imagecolorallocate($canvas,58, 181, 72);
$storename = wordwrap($storename,200,"\n");
$bbox_crs = imagettfbbox($size, 0, $font, $storename);
// $crs_name_x = ($canvas_width / 2) - ($bbox_crs[4] / 2);
$crs_name_x = 1500;
imagettftext($canvas,$size,0,$crs_name_x,720,$color=$crs_color,$font_filename=$font,$text=$storename);


// Inv num
$size = 30;

$inv_num_color = imagecolorallocate($canvas,58, 181, 72);
$inv_num = wordwrap($inv_num,200,"\n");
$bbox_crs = imagettfbbox($size, 0, $font, $inv_num);
// $crs_name_x = ($canvas_width / 2) - ($bbox_crs[4] / 2);
$inv_num_x = 1495;
imagettftext($canvas,$size,0,$inv_num_x,868,$color=$inv_num_color,$font_filename=$font,$text=$inv_num);

// Inv num
$inv_date = $ord['created_at'];
$inv_date_color = imagecolorallocate($canvas,58, 181, 72);
$inv_date = wordwrap($inv_date,200,"\n");
// $bbox_crs = imagettfbbox($size, 0, $font, $inv_num);
// $crs_name_x = ($canvas_width / 2) - ($bbox_crs[4] / 2);
$inv_date_x = 2000;
imagettftext($canvas,$size=30,0,$inv_date_x,870,$color=$inv_date_color,$font_filename=$font,$text=$inv_date);

$total_qty = 0;
$discount = $ord['discount_amt'];
$net_amt = $ord['amount'];
$vat_amt = 0; 
$inv_amt = $ord['amount']+$vat_amt;
$i = 1;
$total_amt = $ord['amount']+$ord['discount_amt'];
$len = 0;
foreach ($ord['purchased_items'] as $od):
$tax_percentage = $od['tax_on_price_wot'];
$price_wot = $od['item_price_wot'];
$total_qty += $od['color_cart_qty'];

$amt = $od['item_price']*$od['color_cart_qty'];
// $total_amt += $amt;

$tprice_y = 1110+$len;
imagettftext($canvas,$size=30,0,130,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$i);
imagettftext($canvas,$size=30,0,300,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=ucwords($od['item_name']));
imagettftext($canvas,$size=30,0,1400,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$od['color_cart_qty']);
imagettftext($canvas,$size=30,0,1700,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$od['item_price']);
imagettftext($canvas,$size=30,0,2100,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$amt);

$i++; $len+=75; 
endforeach;    


//Traning detail
$size = 40;
$cust_vat = wordwrap($cust_vat,100,"\n");
$bbox_trnhrs = imagettfbbox($size, 0, $font, $cust_vat);
// $trngcrs_name_x = ($canvas_width / 2) - ($bbox_trnhrs[4] / 2)+35;
$cust_vat_x = 400;
imagettftext($canvas,$size,0,$cust_vat_x,860,$color=$crs_color,$font_filename=$font,$text=$cust_vat);

// total qty
$size = 35;
$total_qty = wordwrap($total_qty,100,"\n");
$tprice_x = 2100;
$tprice_y = 2570;
imagettftext($canvas,$size,0,$tprice_x,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$total_qty);
// total price
$size = 35;
$total_price = wordwrap($total_amt,100,"\n");
$tprice_x = 2100;
$tprice_y = 2650;
imagettftext($canvas,$size,0,$tprice_x,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$total_amt);
// discount
$size = 35;
$discount = wordwrap($discount,100,"\n");
$tprice_x = 2100;
$tprice_y = 2730;
imagettftext($canvas,$size,0,$tprice_x,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$discount);
// net price
$size = 35;
$net_amt = wordwrap($net_amt,100,"\n");
$tprice_x = 2100;
$tprice_y = 2810;
imagettftext($canvas,$size,0,$tprice_x,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$net_amt);
// vat amount
$size = 35;
$vat_amt = wordwrap($vat_amt,100,"\n");
$tprice_x = 2100;
$tprice_y = 2890;
imagettftext($canvas,$size,0,$tprice_x,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$vat_amt);
// Invoice amt
$size = 35;
$inv_amt = wordwrap(round($inv_amt));
$tprice_x = 2100;
$tprice_y = 2970;
imagettftext($canvas,$size,0,$tprice_x,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$inv_amt);
// Invoice amt
$size = 35;
$invoice_amt_words = ucwords(num_to_words($inv_amt));
$tprice_x = 400;
$tprice_y = 2960;
imagettftext($canvas,$size,0,$tprice_x,$tprice_y,$color=$crs_color,$font_filename=$font_tranng,$text=$invoice_amt_words);





$pdflink = "/media/generated_docs/$certNumber.pdf";
$text = "http:/{$home}{$pdflink}";
$file = RPATH."/media/generated_docs/$certNumber.qr.png";
// $file = false;
//other parameters
$ecc = 'H';
$pixel_size = 15;
$frame_size = 2;
// Generates QR Code and Save as PNG
QRcode::png($text, $file=$file, $ecc, $pixel_size, $frame_size);

$qrcode = RPATH."/media/generated_docs/$certNumber.qr.png";
$qr_img = imagecreatefromfile($qrcode);
//ht widht qr img
list($width, $height) = getimagesize($qrcode);
// resize qr image fit to frame
$new_width = 300;
$new_height = $new_width/1;
// put qr image on template
$qr_x = 125;
$qr_y = 2540;
imagecopyresampled($canvas, $qr_img, $qr_x, $qr_y, 0, 0, $new_width, $new_height, $width, $height);


//generate and save real time image
imagepng($canvas,$filename="media/generated_docs/$certNumber.png",$quality=-1);
//detroy after generating
imagedestroy($canvas);

$imagelink = "/media/generated_docs/$certNumber.png";
$pdflink = "/media/generated_docs/$certNumber.pdf";

$data['msg'] = "success";
$data['data'] = $imagelink;

 
import('fpdf184/fpdf.php');
$image_root = RPATH.$imagelink;
$cert = imagecreatefrompng($image_root);
$cert_width  = imagesx($cert);
$cert_height  = imagesy($cert);
$ratio = $cert_width/$cert_height;
$hgt = $cert_height*0.5;
$wth = $hgt*$ratio;
$pdf = new FPDF('P','mm',array($hgt,$wth));
$pdf->AddPage();
$pdf->Image($image_root,0,0,$wth,$hgt,'png');
$dir = RPATH."/media/generated_docs/";
$filename= $certNumber.".pdf"; 
$pdf->Output("F",$dir.$filename,true);
// echo json_encode($data);
$home = home;
$img =  "<img style='width:100%; height:100%; object-fit: contain;' class='my-3' src='/{$home}{$imagelink}'>" ;
echo "<a class='btn btn-success my-3' target='_blank' href='/{$home}{$pdflink}' download>$img</a>" ;
if (file_exists($qrcode)) {
    unlink($qrcode);
}
// echo js('location.reload(true);');
die();
