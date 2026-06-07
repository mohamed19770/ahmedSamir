<?php

if (! extension_loaded('gd')) {
    fwrite(STDERR, "GD extension required\n");
    exit(1);
}

$dir = __DIR__.'/../public/images';
if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$w = 1200;
$h = 630;
$img = imagecreatetruecolor($w, $h);
$bg = imagecolorallocate($img, 12, 74, 110);
$accent = imagecolorallocate($img, 56, 189, 248);
$white = imagecolorallocate($img, 255, 255, 255);
imagefilledrectangle($img, 0, 0, $w, $h, $bg);
imagefilledrectangle($img, 0, $h - 8, $w, $h, $accent);
imagestring($img, 5, 420, 280, 'Destination2Go', $white);
imagestring($img, 3, 330, 320, 'Gulf Tourism & GCC Travel Agency', $white);
imagejpeg($img, $dir.'/og-default.jpg', 90);
imagedestroy($img);

$logo = imagecreatetruecolor(512, 512);
imagesavealpha($logo, true);
$trans = imagecolorallocatealpha($logo, 0, 0, 0, 127);
imagefill($logo, 0, 0, $trans);
$lb = imagecolorallocate($logo, 12, 74, 110);
imagefilledellipse($logo, 256, 256, 480, 480, $lb);
imagestring($logo, 5, 170, 240, 'D2Go', $white);
imagepng($logo, $dir.'/logo.png');
imagedestroy($logo);

echo "Generated SEO images in {$dir}\n";
