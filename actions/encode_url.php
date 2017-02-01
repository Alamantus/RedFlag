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

//echo var_dump($warnings);

$easycrypt = new EasyCrypt();
$db = new DBControl('../resources/redflag.db');
$hashids = new Hashids\Hashids(HASHID_CODE);

$url_hash = hash('md5', $url);
$encoded_url = $easycrypt->encrypt($url);
$encoded_url_hash = hash('md5', $encoded_url);

//$check_connection_exists = ('
//SELECT `id` FROM `connections` AS c
//JOIN `links` AS l ON l.`id`=c.`link`
//JOIN `warnings` AS w ON w.`id`=c.`warning`
//WHERE l.`hash`="' . $url_hash . '"
//AND w.`id` IN (' . implode(', ', $warnings) . ')
//');

function unhash_warnings ($value) {
    $hashids = new Hashids\Hashids(HASHID_CODE);
    // hashids->decode() always returns an array. Since we know only one value is here, choose that one.
    return $hashids->decode($value)[0];
}

function increment_warning_used_times ($db, $warnings) {
    $db->query('UPDATE `warnings` SET `used_times`=`used_times` + 1 WHERE id IN (' . implode(', ', $warnings) . ');');
}

$check_url_exists = ('
SELECT `id` FROM `links`
WHERE `hash`="' . $encoded_url_hash . '";
');

if ($db->query($check_url_exists)) {
    $link_id = null;
//    echo var_dump($db->all_results);
//    echo var_dump($db->first_result);
    if ($db->first_result !== null) {
//        echo 'record found';
        $link_id = $db->first_result['id'];
    } else {
//        echo 'result does not exist';
        $add_query = 'INSERT INTO `links` (`hash`, `link`, `created`) VALUES ("' . $encoded_url_hash . '", "' . $encoded_url . '", ' . time() . ');';
        if ($db->query($add_query)) {
//            echo 'record added successfully';
            $link_id = $db->last_insert_id;
        } else {
            echo 'failed';
        }
    }

    $raw_warning_ids = array_map('unhash_warnings', $warnings);

    increment_warning_used_times($db, $raw_warning_ids);

    $ids_array = $raw_warning_ids;
    array_unshift($ids_array, intval($link_id));
//    echo var_dump($ids_array);
    echo $hashids->encode($ids_array);
} else {
    echo 'failed';
}
