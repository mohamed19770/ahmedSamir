<?php

/**
 * Download real hero photos into public/images/hero/
 * Sources: Pexels (free license). Run: php scripts/download-hero-images.php
 */

$dir = __DIR__.'/../public/images/hero';
if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$images = [
    'croatia-dubrovnik.jpg' => 'https://images.pexels.com/photos/3601424/pexels-photo-3601424.jpeg?auto=compress&cs=tinysrgb&w=3840',
    'croatia-plitvice.jpg' => 'https://images.pexels.com/photos/2835436/pexels-photo-2835436.jpeg?auto=compress&cs=tinysrgb&w=3840',
    'egypt-pyramids.jpg' => 'https://images.pexels.com/photos/71241/pexels-photo-71241.jpeg?auto=compress&cs=tinysrgb&w=3840',
    'egypt-nile.jpg' => 'https://images.pexels.com/photos/2901209/pexels-photo-2901209.jpeg?auto=compress&cs=tinysrgb&w=3840',
];

foreach ($images as $filename => $url) {
    $path = $dir.'/'.$filename;
    echo "Downloading {$filename}...\n";

    $ctx = stream_context_create([
        'http' => [
            'header' => "User-Agent: Destination2Go/1.0\r\n",
            'timeout' => 120,
        ],
    ]);

    $data = @file_get_contents($url, false, $ctx);
    if ($data === false || strlen($data) < 10000) {
        echo "  FAILED — keeping existing file if present.\n";
        continue;
    }

    file_put_contents($path, $data);
    echo '  OK — '.number_format(strlen($data) / 1024, 1)." KB\n";
}

echo "Done.\n";
