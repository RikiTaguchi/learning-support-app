<?php
include('../common/domain_info.php');
include('../common/phpqrcode/qrlib.php');

$table_id = $_GET['table_id'];
$img_id = $_GET['img_id'];
$img_extention = $_GET['img_extention'];

$img_info = 'table_id=' . $table_id . '&img_id=' . $img_id . '&img_extention=' . $img_extention;
$get_stamp_url = $domain . '/e/get_stamp.php?' . $img_info;
$qr_name = $table_id . '_' . $img_id . '_qr.png';
$qr_path = '../common/qr/' . $qr_name;

QRcode::png($get_stamp_url, $qr_path, QR_ECLEVEL_H);

header('Content-Type: image/png');
readfile($qr_path);
