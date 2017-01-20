<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:34 PM
 */

require_once('./classes/Display.php');
require_once('./classes/EasyCrypt.php');

$warn_type1 = isset($_GET['type1']) ? $_GET['type1'] : false;
$warn_type2 = isset($_GET['type2']) ? $_GET['type2'] : false;
$warn_type3 = isset($_GET['type3']) ? $_GET['type3'] : false;
// $url = isset($_GET['url']) ? urldecode($_GET['url']) : false;
$url = isset($_GET['encodedbundle']) ? urldecode($_GET['encodedbundle']) : false;

$easycrypt = new EasyCrypt();

$warn_types = array();
if ($warn_type1) {
    array_push($warn_types, $warn_type1);
}
if ($warn_type2) {
    array_push($warn_types, $warn_type2);
}
if ($warn_type3) {
    array_push($warn_types, $warn_type3);
}

if ($url) {
    Display::render_warning_page($easycrypt->decrypt($url));
} else {
    Display::render_main_page();
}
