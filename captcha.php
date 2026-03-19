<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('imagecreatetruecolor')) {
    die('GD library is not enabled.');
}

$code = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 6);
$_SESSION["captcha_code"] = $code;

header("Content-Type: image/png");

$width = 160;
$height = 50;

$image = imagecreatetruecolor($width, $height);

$bg = imagecolorallocate($image, 245, 245, 245);
$textColor = imagecolorallocate($image, 20, 40, 120);
$lineColor = imagecolorallocate($image, 180, 180, 180);
$dotColor = imagecolorallocate($image, 120, 120, 120);

imagefill($image, 0, 0, $bg);

for ($i = 0; $i < 6; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
}

for ($i = 0; $i < 120; $i++) {
    imagesetpixel($image, rand(0, $width - 1), rand(0, $height - 1), $dotColor);
}

imagestring($image, 5, 40, 18, $code, $textColor);

imagepng($image);
imagedestroy($image);
exit();
?>
