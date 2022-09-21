<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_MOD_STORE' ) ) die( 'Stop!!!' );

$key_words = $global_config['site_description'];
$per_home = $page_config['per_home'];
$per_page = $page_config['per_page'];


$array_data = array();

if($catid > 0) {
	$page_title = empty($global_array_cat[$catid]['title_seo']) ? $global_array_cat[$catid]['title'] : $global_array_cat[$catid]['title_seo'];
	$description = empty($global_array_cat[$catid]['bodytext_seo']) ? nv_clean60(strip_tags($global_array_cat[$catid]['bodytext']), 160) : $global_array_cat[$catid]['bodytext_seo'];
	$key_words = empty($global_array_cat[$catid]['keywords']) ? $global_config['site_description'] : $global_array_cat[$catid]['keywords'];

	// LẤY DANH SÁCH CỬA HÀNG

	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$catid]['alias'];

	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . STORE . '_rows' )
		->where('status = 1 AND catalog ='.$catid);

	$sth = $db->prepare( $db->sql() );

	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'weight ASC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	$sth->execute();

	while( $item = $sth->fetch() )
	{
	    if (!empty($item['image'])) {
	        if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload . '/' . $item['image'])) {
	            $item['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $item['image'];
	        } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['image'])) {
	            $item['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $item['image'];
	        } else {
	            $item['image'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
	        }
	    }else{
	        if(empty($item['image'])){
	            $item['image'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
	        }else{
	            $item['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $item['image'];
	        }
	    }

	    $path_parts = pathinfo($item['image']);

	    $item['imagealt'] = !empty($path_parts['filename']) ? $path_parts['filename'] : $item['title'];
	    $item['add_time'] = nv_date('d/m/Y H:i A', $item['add_time']);
	    $item['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$item['catalog']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];
		$item['tinhthanh'] = tinhthanh($item['tinhthanh']);
		$item['quanhuyen'] = quanhuyen($item['quanhuyen']);
        $array_data[] = $item;
	}
}

$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );

$contents = nv_theme_store_catalogy( $array_data , $generate_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
