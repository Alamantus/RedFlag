<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:34 PM
 */

require_once('../classes/EasyCrypt.php');
require_once('../classes/DBControl.php');
require_once('../classes/Hashids/HashGenerator.php');
require_once('../classes/Hashids/Hashids.php');

$url = isset($_POST['url']) ? $_POST['url'] : false;

$easycrypt = new EasyCrypt();
$db = new DBControl('../resources/warner.db');
$hashids = new Hashids\Hashids('Protect your eyes!');

$encoded_url = $easycrypt->encrypt($url);
$encoded_url_hash = hash('md5', $encoded_url);

$query = 'SELECT `id` FROM `links` WHERE `hash`="' . $encoded_url_hash . '"';

if ($db->query($query)) {
    if ($db->first_result !== false) {
//        echo 'record found';
        echo $hashids->encode($db->first_result['id']);
    } else {
//        echo 'result does not exist';
        $add_query = 'INSERT INTO `links` (`hash`, `link`) VALUES ("' . $encoded_url_hash . '", "' . $encoded_url . '");';
        if ($db->query($add_query)) {
//            echo 'record added successfully';
            echo $hashids->encode($db->last_insert_id);
        } else {
            echo 'failed';
        }
    }
} else {
    echo 'failed';
}
