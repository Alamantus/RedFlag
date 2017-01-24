<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:34 PM
 */

require_once('./resources/constants.php');
require_once('./classes/Display.php');
require_once('./classes/EasyCrypt.php');
require_once('./classes/DBControl.php');
require_once('./classes/Hashids/HashGenerator.php');
require_once('./classes/Hashids/Hashids.php');

$warn_type1 = isset($_GET['type1']) ? $_GET['type1'] : false;
$warn_type2 = isset($_GET['type2']) ? $_GET['type2'] : false;
$warn_type3 = isset($_GET['type3']) ? $_GET['type3'] : false;
// $url = isset($_GET['url']) ? urldecode($_GET['url']) : false;
$id = isset($_GET['id']) ? urldecode($_GET['id']) : false;

$easycrypt = new EasyCrypt();
$db = new DBControl('./resources/warner.db');
$hashids = new Hashids\Hashids(HASHID_CODE);

$id_array = $hashids->decode($id);

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

$warnings_ids = array_slice($id_array, 1);

if ($id) {
    $query = 'SELECT `link` FROM `links` WHERE `id`=' . $id_array[0] . ';';

    if ($db->query($query)) {
        if ($db->first_result !== null) {
            $url = $easycrypt->decrypt($db->first_result['link']);

            $warnings_query = ('
SELECT `term` FROM `warnings`
WHERE `id` IN (' . implode(', ', $warnings_ids) . ')
ORDER BY `term` ASC;
            ');

            if ($db->query($warnings_query)) {
                if ($db->results_count > 0) {
                    $warnings = array();

                    foreach($db->all_results as $result) {
                        $warnings[] = $easycrypt->decrypt($result['term']);
                    }

                    Display::render_warning_page($url, $warnings);
                } else {
                    Display::render_main_page('no_results');
                }
            } else {
                Display::render_main_page('no_warnings');
            }
        } else {
            Display::render_main_page('no_link');
        }
    } else {
        echo $db->error;
        Display::render_main_page('failed');
    }
} else {
    Display::render_main_page();
}
