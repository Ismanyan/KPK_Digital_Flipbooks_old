<?php
session_start();
function acakCaptcha() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";

    //untuk menyatakan $pass sebagai array
    $pass = array();

   //masukkan -2 dalam string length
    $panjangAlpha = strlen($alphabet) - 2;
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $panjangAlpha);
        $pass[] = $alphabet[$n];
    }

   //ubah array menjadi string
    return implode($pass);
}

 // untuk mengacak captcha
$code = acakCaptcha();
$_SESSION["code"] = $code;

//lebar dan tinggi captcha
$wh = imagecreatetruecolor(150, 50);

//background color merah
$bgc = imagecolorallocate($wh, 192,57,43);

//text color abu-abu
$fc = imagecolorallocate($wh, 223, 230, 233);
imagefill($wh, 0, 0, $bgc);

//( $image , $fontsize , $string , $fontcolor )
imagestring($wh, 15, 50, 15,  $_SESSION["code"], $fc);

//buat gambar
header('content-type: image/jpg');
imagejpeg($wh);
imagedestroy($wh);
?>
