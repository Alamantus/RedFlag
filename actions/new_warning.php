<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/23/2017
 * Time: 8:28 PM
 */

$new_warning = (isset($_POST['new_warning'])) ? htmlspecialchars($_POST['new_warning']) : false;

if ($new_warning) {
    require_once('../resources/constants.php');
    require_once('../classes/EasyCrypt.php');
    require_once('../classes/DBControl.php');
    require_once('../classes/Hashids/HashGenerator.php');
    require_once('../classes/Hashids/Hashids.php');

    $easycrypt = new EasyCrypt();
    $db = new DBControl('../resources/redflag.db');
    $hashids = new Hashids\Hashids(HASHID_CODE);

    $now = time();
    $insert_query = ('
INSERT INTO `warnings` (`term`, `created`, `is_proposed`)
VALUES ("' . $easycrypt->encrypt(ucwords($new_warning)) . '", ' . $now . ', 1);
    ');

    if ($db->query($insert_query)) {
        echo ('
<div class="level-item">
    Inserted successfully!
</div>
<div class="level-item">
    <a class="button is-info" href="/~' . $hashids->encode($db->last_insert_id) . '">
        Use your new warning now
    </a>
</div>
        ');
    } else {
        echo $db->error;
        // echo 'failed';
    }
} else {
    echo 'no warning';
}
