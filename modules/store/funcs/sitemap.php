<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_MOD_STORE' ) ) die( 'Stop!!!' );

$url = array();

$cacheFile = NV_LANG_DATA . '_Sitemap_' . NV_CACHE_PREFIX . '.cache';
$cacheTTL = 7200;

if( ( $cache = $nv_Cache->getItem( $module_name, $cacheFile, $cacheTTL ) ) != false ){
    $url = unserialize( $cache );
} else
    $sql = 'SELECT id, title, alias, catalog, add_time FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE status=1';
    $result = $db_slave->query($sql);

    while (list($id, $title, $alias, $catalog, $add_time) = $result->fetch(3)) {
        $catalias = $global_array_cat[$catalog]['alias'];
        $url[] = array(
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $catalias . '/' . $alias . $global_config['rewrite_exturl'],
            'publtime' => $add_time
        );
    }{

    $cache = serialize($url);
    $nv_Cache->setItem( $module_name, $cacheFile, $cache );
}

nv_xmlSitemap_generate( $url );
die();