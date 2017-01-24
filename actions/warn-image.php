<?php
/**
 * Created by PhpStorm.
 * User: rantenesse
 * Date: 1/20/2017
 * Time: 9:44 AM
 */
require_once('../classes/Terminology.php');

$text = isset($_GET['text']) ? urldecode($_GET['text']) : Terminology::$site_name;
$width = isset($_GET['width']) ? intval($_GET['width']) : 600;
$height = isset($_GET['height']) ? intval($_GET['height']) : 400;

$text = wordwrap($text, 30, "\n");

// Set the content-type
header('Content-Type: image/png');

// Create the image
$im = imagecreatetruecolor($width, $height);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$red = imagecolorallocate($im, 255, 56, 96);
imagefilledrectangle($im, 0, 0, $width, $height, $red);

// Replace path by your own font path
$font = '../resources/Ubuntu-B.ttf';
$font_size = 24;

// Get text measurements.
$text_bounds = imagettfbbox($font_size, 0, $font, $text);

// $text_bounds[2] is the lower-right x coordinate (width) of the text.
$text_width = $text_bounds[2] - $text_bounds[0];
$text_height = $text_bounds[7] - $text_bounds[1];
$text_x_center_placement = ceil(($width - $text_width) / 2);
$text_y_center_placement = ceil(($height - $text_height) / 2);

// Add the text
if ($text !== Terminology::$site_name) {
    $warning_text = 'Warning:';
    $warning_text_bounds = imagettfbbox($font_size, 0, $font, $warning_text);
    $warning_text_width = $warning_text_bounds[2] - $warning_text_bounds[0];
    $warning_text_height = $warning_text_bounds[7] - $warning_text_bounds[1];
    $warning_text_x_center_placement = ceil(($width - $warning_text_width) / 2);
    $warning_text_y_center_placement = ceil(($height - $warning_text_height) / 2);
    imagettftext($im, $font_size, 0, $warning_text_x_center_placement, $warning_text_y_center_placement + ($warning_text_height * 1.5), $white, $font, $warning_text);
}

imagettftext($im, $font_size, 0, $text_x_center_placement, $text_y_center_placement, $white, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
