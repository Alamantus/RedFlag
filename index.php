<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:34 PM
 */

require_once('Display.php');

$warn_type = isset($_GET['type']) ? $_GET['type'] : false;
$url = isset($_GET['url']) ? $_GET['url'] : false;

Display::render_page($warn_type, $url);
