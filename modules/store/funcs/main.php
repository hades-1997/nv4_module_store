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
$key_words = $module_info['keywords'];
$per_home = $page_config['per_home'];
$per_page = $page_config['per_page'];

if ($page_config['viewtype'] == 0) {
$array_data = array();

foreach($global_array_cat as $catalog)
{
	if($catalog['id'] > 0)
	{
		$list_row = $db->query('SELECT * FROM '. STORE . '_rows WHERE status > 0 AND catalog ='.$catalog['id'].' limit '.$per_home)->fetchAll();
		foreach($list_row as $item)
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

		    if(empty($item['bodytext_seo']) and empty($item['bodytext'])){
		        $item['description'] = $item['title'];
		    }elseif (empty($item['bodytext_seo']) and !empty($item['bodytext'])){
		        $item['description'] = strip_tags($item['bodytext']);
		    }elseif (!empty($item['bodytext_seo'])){
		        $item['description'] = $item['bodytext_seo'];
		    }

		    $item['description'] = nv_clean60($item['description'], 70);
		    $item['add_time'] = nv_date('d/m/Y H:i A', $item['add_time']);

		    $item['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$item['catalog']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];

			$item['tinhthanh'] = tinhthanh($item['tinhthanh']);
			$item['quanhuyen'] = quanhuyen($item['quanhuyen']);
			$item['bodytext'] = '';
            $catalog['data'][] = $item;
		}
	}
	$array_data[] = $catalog;
}
$contents = nv_theme_store_main_gird( $array_data );
}

if ($page_config['viewtype'] == 1) {
$array_data = array();

foreach($global_array_cat as $catalog)
{
	if($catalog['id'] > 0)
	{
		$list_row = $db->query('SELECT * FROM '. STORE . '_rows WHERE status > 0 AND catalog ='.$catalog['id'].' limit '.$per_home)->fetchAll();
		foreach($list_row as $item)
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

		    if(empty($item['bodytext_seo']) and empty($item['bodytext'])){
		        $item['description'] = $item['title'];
		    }elseif (empty($item['bodytext_seo']) and !empty($item['bodytext'])){
		        $item['description'] = strip_tags($item['bodytext']);
		    }elseif (!empty($item['bodytext_seo'])){
		        $item['description'] = $item['bodytext_seo'];
		    }

		    $item['description'] = nv_clean60($item['description'], 70);
		    $item['add_time'] = nv_date('d/m/Y H:i A', $item['add_time']);

		    $item['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$item['catalog']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];

			$item['tinhthanh'] = tinhthanh($item['tinhthanh']);
			$item['quanhuyen'] = quanhuyen($item['quanhuyen']);
			$item['bodytext'] = '';
            $catalog['data'][] = $item;
		}
	}
	$array_data[] = $catalog;
}
$contents = nv_theme_store_main_list( $array_data );
}

if ($page_config['viewtype'] == 2) {
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . STORE . '_rows' )
		->where('status=1');
	$sth = $db->prepare( $db->sql() );

	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'weight ASC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	$sth->execute();

	//$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

	$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );


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

	    if(empty($item['bodytext_seo']) and empty($item['bodytext'])){
	        $item['description'] = $item['title'];
	    }elseif (empty($item['bodytext_seo']) and !empty($item['bodytext'])){
	        $item['description'] = strip_tags($item['bodytext']);
	    }elseif (!empty($item['bodytext_seo'])){
	        $item['description'] = $item['bodytext_seo'];
	    }

	    $item['description'] = nv_clean60($item['description'], 70);
	    $item['add_time'] = nv_date('d/m/Y H:i A', $item['add_time']);

	    $item['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$item['catalog']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];

		$item['tinhthanh'] = tinhthanh($item['tinhthanh']);
		$item['quanhuyen'] = quanhuyen($item['quanhuyen']);
        $catalog['data'][] = $item;
	}
	$array_data[] = $catalog;
    $contents = nv_theme_store_list( $array_data, $generate_page );
}

if ($page_config['viewtype'] == 3) {
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . STORE . '_rows' )
		->where('status=1');
	$sth = $db->prepare( $db->sql() );

	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'weight ASC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	$sth->execute();

	//$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

	$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );


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

		if(empty($item['bodytext_seo']) and empty($item['bodytext'])){
		    $item['description'] = $item['title'];
		}elseif (empty($item['bodytext_seo']) and !empty($item['bodytext'])){
		    $item['description'] = strip_tags($item['bodytext']);
		}elseif (!empty($item['bodytext_seo'])){
		    $item['description'] = $item['bodytext_seo'];
		}

		$item['description'] = nv_clean60($item['description'], 70);
		$item['add_time'] = nv_date('d/m/Y H:i A', $item['add_time']);

		$item['link'] = $base_url . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$item['catalog']]['alias'] . '/' . $item['alias'] . $global_config['rewrite_exturl'];

		$item['tinhthanh'] = tinhthanh($item['tinhthanh']);
		$item['quanhuyen'] = quanhuyen($item['quanhuyen']);
        $catalog['data'][] = $item;
	}
	$array_data[] = $catalog;
    $contents = nv_theme_store_gird( $array_data, $generate_page );
}


include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
