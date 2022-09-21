<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['config'];

$array_config = array();

if ($nv_Request->isset_request('submit', 'post')) {
    $array_config['viewtype'] = $nv_Request->get_int('viewtype', 'post', 0);
	$array_config['facebookapi'] = $nv_Request->get_string('facebookapi', 'post', '');
    $array_config['per_page'] = $nv_Request->get_int('per_page', 'post', '0');
	$array_config['per_home'] = $nv_Request->get_int('per_home', 'post', '0');
	$array_config['per_row'] = $nv_Request->get_int('per_row', 'post', '0');
    $array_config['related_articles'] = $nv_Request->get_int('related_articles', 'post', '0');
    $array_config['alias_lower'] = $nv_Request->get_int('alias_lower', 'post', 0);
	$array_config['thaoluan'] = $nv_Request->get_int('thaoluan', 'post', 0);
	$array_config['key_map'] = $nv_Request->get_string('key_map', 'post', '');
    $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_config SET config_value = :config_value WHERE config_name = :config_name');
    foreach ($array_config as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }

    $nv_Cache->delMod($module_name);
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
}

$array_config['viewtype'] = 0;
$array_config['per_page'] = '5';
$array_config['per_home'] = '4';
$array_config['per_row'] = '3';
$array_config['facebookapi'] = '';
$array_config['related_articles'] = '5';
$array_config['alias_lower'] = 1;
$array_config['thaoluan'] = 0;
$array_config['key_map'] = '';

$sql = 'SELECT config_name, config_value FROM ' . NV_PREFIXLANG . '_' . $module_data . '_config';
$result = $db->query($sql);
while (list ($c_config_name, $c_config_value) = $result->fetch(3)) {
    $array_config[$c_config_name] = $c_config_value;
}
$xtpl = new XTemplate('config.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('FORM_ACTION', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('DATA', $array_config);
$xtpl->assign('THAOLUAN', $array_config['thaoluan'] ? ' checked="checked"' : '');

$xtpl->assign('ALIAS_LOWER', $array_config['alias_lower'] ? ' checked="checked"' : '');

$view_array = array(
    $lang_module['config_view_type_1'],
    $lang_module['config_view_type_2'],
    $lang_module['config_view_type_3'],
    $lang_module['config_view_type_4'],
    $lang_module['config_view_type_5']
);
foreach ($view_array as $key => $title) {
    $xtpl->assign('VIEWTYPE', array(
        'id' => $key,
        'title' => $title,
        'selected' => $array_config['viewtype'] == $key ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.loop');
}
for ($i = 5; $i <= 30; ++$i) {
    $xtpl->assign('PER_PAGE', array(
        'key' => $i,
        'title' => $i,
        'selected' => $i == $array_config['per_page'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.per_page');
}
for ($i = 4; $i <= 30; ++$i) {
    $xtpl->assign('PER_HOME', array(
        'key' => $i,
        'title' => $i,
        'selected' => $i == $array_config['per_home'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.per_home');
}

for ($i = 0; $i <= 30; ++$i) {
    $xtpl->assign('PER_ROW', array(
        'key' => $i,
        'title' => $i,
        'selected' => $i == $array_config['per_row'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.per_row');
}

for ($i = 0; $i <= 30; ++$i) {
    $xtpl->assign('RELATED_ARTICLES', array(
        'key' => $i,
        'title' => $i,
        'selected' => $i == $array_config['related_articles'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.related_articles');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
