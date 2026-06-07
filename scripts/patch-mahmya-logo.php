<?php

$path = __DIR__.'/../public/images/hero/mahmya-island.jpg';
$im = imagecreatefromjpeg($path);

if (! $im) {
    fwrite(STDERR, "Failed to load image.\n");
    exit(1);
}

$w = imagesx($im);
$h = imagesy($im);
$sx = (int) ($w * 0.30);
$sy = (int) ($h * 0.16);
$sampleX = min((int) ($w * 0.30), $w - 1);
$sampleY = min((int) ($h * 0.08), $h - 1);

$c = imagecolorat($im, $sampleX, $sampleY);
$r = ($c >> 16) & 0xFF;
$g = ($c >> 8) & 0xFF;
$b = $c & 0xFF;

for ($y = 0; $y <= $sy; $y++) {
    for ($x = 0; $x <= $sx; $x++) {
        $edge = max(($x / max($sx, 1)) * 0.4, ($y / max($sy, 1)) * 0.3);
        $fade = max(0, min(1, 1 - $edge));

        $existing = imagecolorat($im, $x, $y);
        $er = ($existing >> 16) & 0xFF;
        $eg = ($existing >> 8) & 0xFF;
        $eb = $existing & 0xFF;

        $nr = (int) ($r * $fade + $er * (1 - $fade));
        $ng = (int) ($g * $fade + $eg * (1 - $fade));
        $nb = (int) ($b * $fade + $eb * (1 - $fade));

        $col = imagecolorallocate($im, $nr, $ng, $nb);
        imagesetpixel($im, $x, $y, $col);
    }
}

imagejpeg($im, $path, 92);
imagedestroy($im);

echo "Logo area patched ({$sx}x{$sy}).\n";
