<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if (! defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (! nv_function_exists('nv_block_store')) {
    /**
     * nv_block_config_store()
     *
     * @param mixed $module
     * @param mixed $data_block
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_store($module, $data_block, $lang_block)
    {
        global $site_mods;

        $html = '';

        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['numrow'] . ':</label>';
        $html .= '<div class="col-sm-18"><input type="text" class="form-control" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></div>';
        $html .= '</div>';
        return $html;
    }

    /**
     * nv_block_config_store_submit()
     *
     * @param mixed $module
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_store_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        return $return;
    }

    /**
     * nv_block_store()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_block_store($block_config)
    {
        global $site_mods, $module_config, $global_config, $nv_Cache, $db, $global_array_cat;
        $module = $block_config['module'];

        $db->sqlreset()
            ->select('id, title, alias, sdt, email, website, facebook, catalog, image, bodytext_seo')
            ->from(NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_rows')
            ->where('status=1')
            ->order('weight ASC')
            ->limit($block_config['numrow']);
        $list = $nv_Cache->db($db->sql(), '', $module);

        if (! empty($list)) {
            if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/store/block.store.tpl')) {
                $block_theme = $global_config['module_theme'];
            } else {
                $block_theme = 'default';
            }
            $xtpl = new XTemplate('block.store.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/store');
            $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
            $xtpl->assign('TEMPLATE', $block_theme);

            foreach ($list as $l) {
                if (!empty($l['image'])) {
                    if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['image'])) {
                        $l['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['image'];
                    } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['image'])) {
                        $l['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['image'];
                    } else {
                        $l['image'] = NV_BASE_SITEURL . 'themes/' . $block_theme . '/images/' . $module . '/no-image.jpg';
                    }
                }else{
                    if(empty($l['image'])){
                        $l['image'] = NV_BASE_SITEURL . 'themes/' . $block_theme . '/images/' . $module . '/no-image.jpg';
                    }else{
                        $l['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $l['image'];
                    }
                }

                $path_parts = pathinfo($l['image']);

                $l['imagealt'] = !empty($path_parts['filename']) ? $path_parts['filename'] : $l['title'];

                if(empty($l['bodytext_seo'])){
                    $l['description'] = $l['title'];
                }else{
                    $l['description'] = $l['bodytext_seo'];
                }

                $l['description'] = nv_clean60($l['description'], 70);

                $l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$l['catalog']]['alias'] . '/' . $l['alias'] . $global_config['rewrite_exturl'];

                $xtpl->assign('ROW', $l);
                if (! empty($l['image'])) {
                    $xtpl->parse('main.loop.img');
                }
                $xtpl->parse('main.loop');
            }

            $xtpl->parse('main');
            return $xtpl->text('main');
        }
    }
}
if (defined('NV_SYSTEM')) {
    global $site_mods, $module_name, $global_array_cat, $nv_Cache, $db;

    $module = $block_config['module'];
    if (isset($site_mods[$module])) {

        if ($module != $module_name) {

            $module_array_cat = array();
            $sql = 'SELECT id, title, alias FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_catalogy ORDER BY weight DESC';
            $list = $nv_Cache->db($sql, 'id', $module);

            if(!empty($list)) {
                foreach ($list as $l) {
                    $global_array_cat[$l['id']] = $l;
                    $global_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
                }
            }
        }
        $content = nv_block_store($block_config);
    }
}