<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/21/2017
 * Time: 7:47 AM
 */

require_once('../resources/constants.php');
require_once('../classes/DBControl.php');
require_once('../classes/Hashids/HashGenerator.php');
require_once('../classes/Hashids/Hashids.php');

$db = new DBControl('../resources/warner.db');
$hashids = new Hashids\Hashids(HASHID_CODE);

// Time in seconds before a proposed timestamp expires.
$expire_timestamp = DAYS_UNTIL_PROPOSED_EXPIRES * 24 * 60 * 60;

$update = ('
UPDATE `warnings`
SET `active`=0
WHERE `is_proposed`=1
AND `created`<' . (time() - $expire_timestamp) . '
AND `used_times`<' . PROPOSED_USE_THRESHOLD . ';
');

$query = ('
SELECT * FROM `warnings`
WHERE `active`=1
ORDER BY `term` ASC;
');

if ($db->query($update)) {
    if ($db->query($query)) {
        header('Content-Type: application/json');
        echo json_encode($db->all_results);
    } else {
        echo 'query failed';
    }
} else {
    echo 'update failed';
}
