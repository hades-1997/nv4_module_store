<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) or ! defined( 'NV_IS_MODADMIN' ) ) die( 'Stop!!!' );
define('STORE', $db_config['dbsystem']. '.' .NV_PREFIXLANG. '_' . $module_data);
define('STORE_ADD', $db_config['dbsystem']. '.' .$db_config['prefix']. '_location');
define( 'NV_IS_FILE_ADMIN', true );


$allow_func = array( 'main', 'catalogy', 'add', 'config');

function getOutputJson( $json )
{
	global $global_config, $db, $lang_global, $lang_module, $language_array, $nv_parse_ini_timezone, $countries, $module_info, $site_mods;

	@Header( 'Content-Type: application/json' );
	@Header( 'Content-Type: text/html; charset=' . $global_config['site_charset'] );
	@Header( 'Content-Language: ' . $lang_global['Content_Language'] );
	@Header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', strtotime( '-1 day' ) ) . " GMT" );
	@Header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', NV_CURRENTTIME - 60 ) . " GMT" );

	echo json_encode( $json );
	unset( $GLOBALS['db'], $GLOBALS['lang_module'], $GLOBALS['language_array'], $GLOBALS['nv_parse_ini_timezone'],$GLOBALS['countries'], $GLOBALS['module_info'], $GLOBALS['site_mods'], $GLOBALS['lang_global'], $GLOBALS['global_config'], $GLOBALS['client_info'] );

	exit();
}
// Get Config Module
$sql = 'SELECT config_name, config_value FROM ' . NV_PREFIXLANG . '_' . $module_data . '_config';
$list = $nv_Cache->db($sql, '', $module_name);
$page_config = array();
foreach ($list as $values) {
    $page_config[$values['config_name']] = $values['config_value'];
}

global $global_array_cat;
$global_array_cat = array();
$sql = 'SELECT * FROM '. STORE . '_catalogy WHERE status > 0';
$list = $nv_Cache->db($sql, 'id', $module_name);
if (!empty($list)) {
    foreach ($list as $l) {
        $global_array_cat[$l['id']] = $l;
        $global_array_cat[$l['id']]['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'],true);
        $global_array_cat[$l['id']]['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $global_array_cat[$l['id']]['image'] ;
    }
}

$list_cata = $db->query('SELECT * FROM '. NV_PREFIXLANG . '_'. $module_data . '_catalogy WHERE status > 0')->fetchAll();
