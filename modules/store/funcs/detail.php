<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_MOD_STORE' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $global_config['site_description'];
$related_articles = $page_config['related_articles'];
$array_data = array();
$array_images = array();
if($id > 0)
{
	 $time_set = $nv_Request->get_int($module_data . '_' . $op . '_' . $id, 'session');
    if (empty($time_set)) {
        $nv_Request->set_Session($module_data . '_' . $op . '_' . $id, NV_CURRENTTIME);
        $sql = 'UPDATE ' .STORE . '_rows SET hitstotal=hitstotal+1 WHERE id=' . $id;
        $db->query($sql);
    }



	$array_data = $db->query("SELECT * FROM ". STORE . "_rows WHERE status > 0 AND id =" .$id)->fetch();
	$array_data['add_time'] = nv_date('d/m/Y H:i A', $array_data['add_time']);
	if(!empty($array_data['image'])){
	    $array_data['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_data['image'];
	}else{
	    $array_data['image'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
	}
	$path_parts = pathinfo($array_data['image']);

	$array_data['imagealt'] = !empty($path_parts['filename']) ? $path_parts['filename'] : $array_data['title'];

	if(!empty($array_data['dia_chi_day_du'])){
	    $array_data['dia_chi'] = $array_data['dia_chi_day_du'] . ', ' . $array_data['dia_chi'];
	}

	$page_title = empty($array_data['title_seo']) ? $array_data['title'] : $array_data['title_seo'];
	$description = empty($array_data['bodytext_seo']) ? nv_clean60(strip_tags($array_data['bodytext']), 160) : $array_data['bodytext_seo'];
	$key_words = empty($array_data['keywords']) ? $global_config['site_description'] : $array_data['keywords'];

	// DANH SÁCH CỬA HÀNG CÙNG QUẬN
	// LẤY DANH SÁCH CỬA HÀNG
	$array_lienquan = array();
	$list_row = $db->query('SELECT * FROM '. STORE . '_rows WHERE status = 1 AND id !='. $array_data['id'] .' AND (tinhthanh ='.$array_data['tinhthanh'] .' OR quanhuyen ='.$array_data['quanhuyen'].') limit '.$related_articles)->fetchAll();

	foreach($list_row as $itemlq) {
	    if (!empty($itemlq['image'])) {
	        if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload . '/' . $itemlq['image'])) {
	            $itemlq['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $itemlq['image'];
	        } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $itemlq['image'])) {
	            $itemlq['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $itemlq['image'];
	        } else {
	            $itemlq['image'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
	        }
	    }else{
	        if(empty($itemlq['image'])){
	            $itemlq['image'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
	        }else{
	            $itemlq['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $itemlq['image'];
	        }
	    }

	    $path_parts = pathinfo($itemlq['image']);

	    $itemlq['imagealt'] = !empty($path_parts['filename']) ? $path_parts['filename'] : $itemlq['title'];
	    $itemlq['add_time'] = nv_date('d/m/Y H:i A', $itemlq['add_time']);
	    $itemlq['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$itemlq['catalog']]['alias'] . '/' . $itemlq['alias'] . $global_config['rewrite_exturl'];

		$itemlq['tinhthanh'] = tinhthanh($itemlq['tinhthanh']);
		$itemlq['quanhuyen'] = quanhuyen($itemlq['quanhuyen']);
        $array_lienquan[] = $itemlq;
	}
}

$contents = nv_theme_store_detail( $array_data, $array_lienquan);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
