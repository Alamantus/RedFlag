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

$warning_id = isset($_GET['id']) ? urldecode($_GET['id']) : false;
$preselected_warning = isset($_GET['preselected']) ? urldecode($_GET['preselected']) : '';
$page = isset($_GET['page']) ? urldecode($_GET['page']) : false;

$easycrypt = new EasyCrypt();
$db = new DBControl('./resources/redflag.db');
$hashids = new Hashids\Hashids(HASHID_CODE);

$id_array = $hashids->decode($warning_id);

$warnings_array = array_slice($id_array, 1);

if ($warning_id) {
    $query = 'SELECT `link` FROM `links` WHERE `id`=' . $id_array[0] . ';';

    if ($db->query($query)) {
        if ($db->first_result !== null) {
            $url = $easycrypt->decrypt($db->first_result['link']);

            $warnings_query = ('
SELECT `term` FROM `warnings`
WHERE `id` IN (' . implode(', ', $warnings_array) . ');
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
                    Display::render_main_page(array('error' => 'no_results'));
                }
            } else {
                Display::render_main_page(array('error' => 'no_warnings'));
            }
        } else {
            Display::render_main_page(array('error' => 'no_link'));
        }
    } else {
        // echo $db->error;
        Display::render_main_page(array('error' => 'failed'));
    }
} elseif ($page) {
    switch ($page) {
        case 'about': {
            Display::render_about_page();
            break;
        }
        case 'newwarning': {
            Display::render_propose_page();
            break;
        }
        default: {
            Display::render_main_page(array('error' => 'no_page'));
        }
    }
} else {
    Display::render_main_page(array('preselected' => $preselected_warning));
    // Display::render_main_page();
}
