<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:34 PM
 */

require_once('../resources/constants.php');
require_once('../classes/EasyCrypt.php');
require_once('../classes/DBControl.php');
require_once('../classes/Hashids/HashGenerator.php');
require_once('../classes/Hashids/Hashids.php');

$warnings = isset($_POST['warnings']) ? json_decode($_POST['warnings']) : false;
$url = isset($_POST['url']) ? $_POST['url'] : false;

$easycrypt = new EasyCrypt();
$db = new DBControl('../resources/warner.db');
$hashids = new Hashids\Hashids(HASHID_CODE);

$url_hash = hash('md5', $url);
$encoded_url = $easycrypt->encrypt($url);
$encoded_url_hash = hash('md5', $encoded_url);

$check_connection_exists = ('
SELECT `id` FROM `connections` AS c
JOIN `links` AS l ON l.`id`=c.`link` 
JOIN `warnings` AS w ON w.`id`=c.`warning` 
WHERE l.`hash`="' . $url_hash . '"
AND w.`id` IN (' . implode(', ', $warnings) . ')
');

$check_url_exists = ('
SELECT `id` FROM `links`
WHERE `hash`="' . $url_hash . '";
');

if ($db->query($check_url_exists)) {
    $link_id = null;
    if ($db->first_result !== false) {
//        echo 'record found';
        $link_id = $db->first_result['id'];
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
