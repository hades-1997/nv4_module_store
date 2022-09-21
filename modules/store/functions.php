<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );

define( 'NV_IS_MOD_STORE', true );
define('STORE', $db_config['dbsystem']. '.' .NV_PREFIXLANG. '_' . $module_data);
define('STORE_ADD', $db_config['dbsystem']. '.' .$db_config['prefix']. '_location');

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;

// Get Config Module
$sql = 'SELECT config_name, config_value FROM ' . NV_PREFIXLANG . '_' . $module_data . '_config';
$list = $nv_Cache->db($sql, '', $module_name);
$page_config = array();
foreach ($list as $values) {
    $page_config[$values['config_name']] = $values['config_value'];
}

function tinhthanh($tinhthanh =0){
	global $db,$module_data,$db_config;
	$sql = 'SELECT  provinceid, title, alias, type FROM ' .$db_config['dbsystem']. '.' .$db_config['prefix']. '_location_province WHERE provinceid="' . $tinhthanh.'"';
	$data = $db->query($sql)->fetch();
	return $data['title'];
}

function quanhuyen($id =0){
	global $db,$module_data,$db_config;
	$sql = 'SELECT districtid, title, alias, type FROM ' .$db_config['dbsystem']. '.' .$db_config['prefix']. '_location_district WHERE districtid="' . $id.'"';
	$data = $db->query($sql)->fetch();
	return $data['title'];
}

// LẤY DANH SÁCH CATALOGY

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

$count_op = sizeof($array_op);
if($count_op == 1){
	// LẤY id danh mục ra
	$catid_tam = $db->query("SELECT id FROM ". STORE . "_catalogy WHERE status > 0 AND alias ='" .$array_op[0] ."'")->fetchColumn();

	if($catid_tam > 0) {
		$catid = $catid_tam;
		$op = 'catalogy';
	}
}
if($count_op == 2)
{
	if(!empty($array_op[1]))
	{

		$id_tam = $db->query("SELECT id FROM ". STORE . "_rows WHERE status > 0 AND alias ='" .$array_op[1] ."'")->fetchColumn();

		if($id_tam > 0) {
			$id = $id_tam;
			$op = 'detail';
		} else {
			$id_tinhthanh = $db->query("SELECT provinceid FROM " . STORE_ADD."_province WHERE alias ='" .$array_op[1] ."'")->fetchColumn();
			if($id_tinhthanh > 0){
				$op = 'map';
			}
		}
	}
}

