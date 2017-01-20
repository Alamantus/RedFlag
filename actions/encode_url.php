<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:34 PM
 */

require_once('../classes/EasyCrypt.php');

$url = isset($_POST['url']) ? $_POST['url'] : false;

$easycrypt = new EasyCrypt();

echo urlencode($easycrypt->encrypt($url));
