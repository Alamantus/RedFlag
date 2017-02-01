<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/21/2017
 * Time: 7:47 AM
 */

require_once('../resources/constants.php');
require_once('../classes/EasyCrypt.php');
require_once('../classes/DBControl.php');
require_once('../classes/Hashids/HashGenerator.php');
require_once('../classes/Hashids/Hashids.php');

$easycrypt = new EasyCrypt();
$db = new DBControl('../resources/redflag.db');
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
WHERE `active`=1;
');

if ($db->query($update)) {
    if ($db->query($query)) {
        $hashed = array();

        // $terms array for sorting alphabetically after it's decrypted.
        $terms = array();

        foreach($db->all_results as $key => $row) {
            $term = $easycrypt->decrypt($row['term']);
            $terms[$key] = $term;
            $row['id'] = $hashids->encode(intval($row['id']));
            $row['term'] = $term;
            $hashed[] = $row;
        }

        array_multisort($terms, SORT_ASC, $hashed);

        // header('Content-Type: application/json');
        echo json_encode($hashed);
    } else {
        echo 'query failed';
    }
} else {
    echo 'update failed';
}
