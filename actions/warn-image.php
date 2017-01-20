<?php
/**
 * Created by PhpStorm.
 * User: rantenesse
 * Date: 1/20/2017
 * Time: 9:44 AM
 */
require_once('../classes/Terminology.php');

$text = isset($_GET['text']) ? $_GET['text'] : Terminology::$site_name;

// Set the content-type
header('Content-Type: image/png');

$image_width = 600;
$image_height = 400;

// Create the image
$im = imagecreatetruecolor($image_width, $image_height);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, $image_width, $image_height, $black);

// Replace path by your own font path
$font = '../resources/Ubuntu-B.ttf';
$font_size = 20;

// Get text measurements.
$text_bounds = imagettfbbox($font_size, 0, $font, $text);

// $text_bounds[2] is the lower-right x coordinate (width) of the text.
$text_width = $text_bounds[2] - $text_bounds[0];
$text_height = $text_bounds[7] - $text_bounds[1];
$text_x_center_placement = ceil(($image_width - $text_width) / 2);
$text_y_center_placement = ceil(($image_height - $text_height) / 2);

// Add the text
imagettftext($im, $font_size, 0, $text_x_center_placement, $text_y_center_placement, $white, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
