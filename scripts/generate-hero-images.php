<?php

$dir = __DIR__.'/../public/images/hero';
if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

function gradientFill($img, int $w, int $h, array $top, array $bottom): void
{
    for ($y = 0; $y < $h; $y++) {
        $ratio = $y / max($h - 1, 1);
        $r = (int) ($top[0] + ($bottom[0] - $top[0]) * $ratio);
        $g = (int) ($top[1] + ($bottom[1] - $top[1]) * $ratio);
        $b = (int) ($top[2] + ($bottom[2] - $top[2]) * $ratio);
        imageline($img, 0, $y, $w, $y, imagecolorallocate($img, $r, $g, $b));
    }
}

function drawSun($img, int $cx, int $cy, int $radius, int $color): void
{
    imagefilledellipse($img, $cx, $cy, $radius * 2, $radius * 2, $color);
}

function drawMountain($img, array $points, int $color): void
{
    imagefilledpolygon($img, $points, $color);
}

function saveSlide(string $path, callable $draw): void
{
    $w = 1920;
    $h = 1080;
    $img = imagecreatetruecolor($w, $h);
    $draw($img, $w, $h);
    imagejpeg($img, $path, 88);
    imagedestroy($img);
    echo 'Created '.basename($path).PHP_EOL;
}

saveSlide($dir.'/croatia-dubrovnik.jpg', function ($img, $w, $h) {
    gradientFill($img, $w, $h, [25, 120, 210], [8, 45, 95]);
    $sun = imagecolorallocate($img, 255, 220, 120);
    drawSun($img, (int) ($w * 0.78), (int) ($h * 0.22), 70, $sun);
    $sea = imagecolorallocate($img, 12, 110, 170);
    imagefilledrectangle($img, 0, (int) ($h * 0.62), $w, $h, $sea);
    $wall = imagecolorallocate($img, 210, 180, 140);
    imagefilledrectangle($img, (int) ($w * 0.08), (int) ($h * 0.42), (int) ($w * 0.55), (int) ($h * 0.62), $wall);
    $roof = imagecolorallocate($img, 180, 70, 50);
    for ($i = 0; $i < 8; $i++) {
        $x = (int) ($w * (0.1 + $i * 0.05));
        imagefilledpolygon($img, [$x, (int) ($h * 0.42), $x + 60, (int) ($h * 0.42), $x + 30, (int) ($h * 0.34)], $roof);
    }
    label($img, $w, $h, 'Dubrovnik, Croatia');
});

saveSlide($dir.'/croatia-plitvice.jpg', function ($img, $w, $h) {
    gradientFill($img, $w, $h, [120, 210, 255], [20, 120, 80]);
    $water = imagecolorallocate($img, 30, 160, 210);
    imagefilledellipse($img, (int) ($w * 0.35), (int) ($h * 0.55), (int) ($w * 0.45), (int) ($h * 0.18), $water);
    imagefilledellipse($img, (int) ($w * 0.62), (int) ($h * 0.62), (int) ($w * 0.35), (int) ($h * 0.14), $water);
    $forest = imagecolorallocate($img, 18, 95, 45);
    drawMountain($img, [0, (int) ($h * 0.55), (int) ($w * 0.35), (int) ($h * 0.25), (int) ($w * 0.7), (int) ($h * 0.48), $w, (int) ($h * 0.58), $w, $h, 0, $h], $forest);
    label($img, $w, $h, 'Plitvice Lakes, Croatia');
});

saveSlide($dir.'/egypt-pyramids.jpg', function ($img, $w, $h) {
    gradientFill($img, $w, $h, [255, 190, 90], [190, 110, 45]);
    drawSun($img, (int) ($w * 0.72), (int) ($h * 0.24), 85, imagecolorallocate($img, 255, 240, 170));
    $sand = imagecolorallocate($img, 220, 180, 95);
    imagefilledrectangle($img, 0, (int) ($h * 0.58), $w, $h, $sand);
    $pyramid = imagecolorallocate($img, 196, 148, 70);
    drawMountain($img, [(int) ($w * 0.18), (int) ($h * 0.58), (int) ($w * 0.34), (int) ($h * 0.22), (int) ($w * 0.5), (int) ($h * 0.58)], $pyramid);
    drawMountain($img, [(int) ($w * 0.42), (int) ($h * 0.58), (int) ($w * 0.56), (int) ($h * 0.28), (int) ($w * 0.7), (int) ($h * 0.58)], imagecolorallocate($img, 175, 130, 60));
    drawMountain($img, [(int) ($w * 0.58), (int) ($h * 0.58), (int) ($w * 0.67), (int) ($h * 0.36), (int) ($w * 0.76), (int) ($h * 0.58)], imagecolorallocate($img, 160, 118, 55));
    label($img, $w, $h, 'Giza Pyramids, Egypt');
});

saveSlide($dir.'/egypt-nile.jpg', function ($img, $w, $h) {
    gradientFill($img, $w, $h, [255, 150, 80], [70, 110, 180]);
    drawSun($img, (int) ($w * 0.2), (int) ($h * 0.18), 60, imagecolorallocate($img, 255, 230, 150));
    $nile = imagecolorallocate($img, 20, 95, 160);
    imagefilledrectangle($img, 0, (int) ($h * 0.52), $w, (int) ($h * 0.72), $nile);
    $palm = imagecolorallocate($img, 30, 120, 45);
    imagefilledrectangle($img, (int) ($w * 0.12), (int) ($h * 0.35), (int) ($w * 0.14), (int) ($h * 0.52), $palm);
    imagefilledellipse($img, (int) ($w * 0.1), (int) ($h * 0.34), 120, 50, $palm);
    imagefilledellipse($img, (int) ($w * 0.16), (int) ($h * 0.34), 120, 50, $palm);
    $temple = imagecolorallocate($img, 190, 150, 95);
    imagefilledrectangle($img, (int) ($w * 0.62), (int) ($h * 0.34), (int) ($w * 0.78), (int) ($h * 0.52), $temple);
    imagefilledrectangle($img, (int) ($w * 0.66), (int) ($h * 0.26), (int) ($w * 0.74), (int) ($h * 0.34), $temple);
    label($img, $w, $h, 'Luxor and Nile, Egypt');
});

function label($img, int $w, int $h, string $text): void
{
    $white = imagecolorallocate($img, 255, 255, 255);
    $shadow = imagecolorallocatealpha($img, 0, 0, 0, 40);
    imagefilledrectangle($img, 40, $h - 120, 720, $h - 35, $shadow);
    imagestring($img, 5, 60, $h - 95, $text, $white);
}
