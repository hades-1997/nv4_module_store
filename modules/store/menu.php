<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_ADMIN' ) ) die( 'Stop!!!' );
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_catalogy WHERE status=1 ORDER BY weight ASC';
$result = $db->query($sql);
while ($row = $result->fetch()) {
    $array_item[$row['id']] = array(
        'key' => $row['id'],
        'title' => $row['title'],
        'alias' => $row['alias']
    );
}