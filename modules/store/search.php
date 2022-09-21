<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_MOD_SEARCH' ) ) die( 'Stop!!!' );

if (file_exists(NV_ROOTDIR . '/modules/' . $m_values['module_file'] . '/language/' . NV_LANG_DATA . '.php')) {
    require_once NV_ROOTDIR . '/modules/' . $m_values['module_file'] . '/language/' . NV_LANG_DATA . '.php';
}

// Fetch Limit
$db->sqlreset()->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $m_values['module_data'] . '_rows')
    ->where("(" . nv_like_logic('title', $dbkeywordhtml, $logic) . "
		OR " . nv_like_logic('bodytext', $dbkeywordhtml, $logic) . "
		OR " . nv_like_logic('keywords', $dbkeywordhtml, $logic) . "
        OR " . nv_like_logic('sdt', $dbkeywordhtml, $logic) . "
        OR " . nv_like_logic('email', $dbkeywordhtml, $logic) . ")");

$num_items += $db->query($db->sql())->fetchColumn();

$db->select('id, title, alias, catalog, bodytext, keywords')
    ->order('id DESC')
    ->limit($limit)
    ->offset(($page - 1) * $limit);

$tmp_re = $db->query($db->sql());

if ($num_items) {
    $array_cat_alias = array();

    $sql_cat = 'SELECT id, alias FROM ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_catalogy';
    $re_cat = $db_slave->query($sql_cat);
    while (list ($_catid, $_catalias) = $re_cat->fetch(3)) {
        $array_cat_alias[$_catid] = $_catalias;
    }

    $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m_values['module_name'];

    while (list($id, $title, $alias, $catalog, $bodytext, $keywords) = $tmp_re->fetch(3)) {
        $content = $keywords . $bodytext;

        $url = $link . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat_alias[$catalog] . '/' . $alias . $global_config['rewrite_exturl'];

        $result_array[] = array(
            'link' => $url,
            'title' => '[' . $lang_module['store'] . '] ' . BoldKeywordInStr($title, $key, $logic),
            'content' => BoldKeywordInStr($content, $key, $logic)
        );
    }
}