<?php

// Benchmark script for reading image dimensions (width, height, exif orientation) from image files
// using Imagine or plain exif_read_data()
//
// This is to determine how much there is a performance gain of using exif_read_data()
// to read the image dimensions and orientation, in order to determine whether the image
// has to be rotated or resized, before opening the image using Imagine for rotation or resizing.

require_once (__DIR__ . '/vendor/autoload.php');

$imagedir =__DIR__ . '/testimages';
$images = scandir($imagedir);

echo "Reading images using exif_read_data...\n";
$time_start = microtime(true);
$count = 0;
foreach ($images as $image) {
    if (substr($image, -4) != '.jpg') continue;
    $count++;
    $exif = exif_read_data($imagedir . DIRECTORY_SEPARATOR . $image);
    $size = $exif['COMPUTED']['Width'] . 'x' . $exif['COMPUTED']['Height'];
    $orientation = $exif['Orientation'];
    echo "  Image $image: Size $size, Orientation $orientation\n";
}
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "exif_read_data: $count images read in $time seconds\n\n";
$mem_usage = memory_get_usage();
$mem_peak = memory_get_peak_usage();
echo 'The script is now using: <strong>' . round($mem_usage / 1024) . "KB</strong> of memory.\n";
echo 'Peak usage: <strong>' . round($mem_peak / 1024) . "KB</strong> of memory.\n\n";

echo "Reading images using \Imagine\Imagick\Imagine...\n";
$imagine = new \Imagine\Imagick\Imagine();
$time_start = microtime(true);
$count = 0;
foreach ($images as $image) {
    if (substr($image, -4) != '.jpg') continue;
    $count++;
    $ii = $imagine->open($imagedir . DIRECTORY_SEPARATOR . $image);
    $size = $ii->getSize();
    $metadata = $ii->metadata();
    $orientation = (isset($metadata['ifd0.Orientation']) ? $metadata['ifd0.Orientation'] : 1);
    echo "  Image $image: Size $size, Orientation $orientation\n";
}
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "\Imagine\Imagick\Imagine: $count images read in $time seconds\n\n";
$mem_usage = memory_get_usage();
$mem_peak = memory_get_peak_usage();
echo 'The script is now using: <strong>' . round($mem_usage / 1024) . "KB</strong> of memory.\n";
echo 'Peak usage: <strong>' . round($mem_peak / 1024) . "KB</strong> of memory.\n\n";


echo "Reading images using \Imagine\Gd\Imagine...\n";
$imagine = new \Imagine\Gd\Imagine();
$time_start = microtime(true);
$count = 0;
foreach ($images as $image) {
    if (substr($image, -4) != '.jpg') continue;
    $count++;
    $ii = $imagine->open($imagedir . DIRECTORY_SEPARATOR . $image);
    $size = $ii->getSize();
    $metadata = $ii->metadata();
    $orientation = (isset($metadata['ifd0.Orientation']) ? $metadata['ifd0.Orientation'] : 1);
    echo "  Image $image: Size $size, Orientation $orientation\n";
}
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "\Imagine\Gd\Imagine: $count images read in $time seconds\n\n";
$mem_usage = memory_get_usage();
$mem_peak = memory_get_peak_usage();
echo 'The script is now using: <strong>' . round($mem_usage / 1024) . "KB</strong> of memory.\n";
echo 'Peak usage: <strong>' . round($mem_peak / 1024) . "KB</strong> of memory.\n\n";

