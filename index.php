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

$id = isset($_GET['id']) ? urldecode($_GET['id']) : false;
$page = isset($_GET['page']) ? urldecode($_GET['page']) : false;

$easycrypt = new EasyCrypt();
$db = new DBControl('./resources/warner.db');
$hashids = new Hashids\Hashids(HASHID_CODE);

$id_array = $hashids->decode($id);

$warnings_ids = array_slice($id_array, 1);

if ($id) {
    $query = 'SELECT `link` FROM `links` WHERE `id`=' . $id_array[0] . ';';

    if ($db->query($query)) {
        if ($db->first_result !== null) {
            $url = $easycrypt->decrypt($db->first_result['link']);

            $warnings_query = ('
SELECT `term` FROM `warnings`
WHERE `id` IN (' . implode(', ', $warnings_ids) . ');
            ');

            if ($db->query($warnings_query)) {
                if ($db->results_count > 0) {
                    $warnings = array();

                    foreach($db->all_results as $result) {
                        $warnings[] = $easycrypt->decrypt($result['term']);
                    }

                    sort($warnings);

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
} elseif ($page) {
    switch ($page) {
        case 'about': {
            Display::render_about_page();
            break;
        }
        default: {
            Display::render_main_page('no_page');
        }
    }
} else {
    Display::render_main_page();
}
