<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:34 PM
 */

require_once('../classes/EasyCrypt.php');
require_once('../classes/DBControl.php.php');
require_once('../classes/Hashids/Hashids.php');

$url = isset($_POST['url']) ? $_POST['url'] : false;

$easycrypt = new EasyCrypt();
$db = new DBControl();
$hashids = new Hashids\Hashids('Protect your eyes!');

$encoded_url = urlencode($easycrypt->encrypt($url));
$encoded_url_hash = hash('md5', $encoded_url);

$query = 'SELECT `id` FROM `links` WHERE `hash`="' . $encoded_url_hash . '"';

if ($db->query($query)) {
    if ($db->results_count > 0) {
        echo $hashids->encode($db->results->fetch());
    } else {
        $add_query = 'INSERT INTO `links` (`hash`, `link`) VALUES ("' . $encoded_url_hash . '", "' . $encoded_url . '");';
        if ($db->query($add_query)) {
            // figure out the new id and go from there.
        }
    }
} else {
    echo 'Please try again later';
}
