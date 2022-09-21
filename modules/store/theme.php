<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_MOD_STORE' ) ) die( 'Stop!!!' );

/**
 * nv_theme_store_main_gird()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_store_main_gird ($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config,$global_array_cat, $module_info, $op;

    $xtpl = new XTemplate('maingird.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    foreach($array_data as $cata)
	{
		$xtpl->assign( 'CAT', $cata );
		if(!empty($cata['data']))
		{
			foreach($cata['data'] as $row)
			{
				$xtpl->assign( 'ROW', $row );
				if(!empty($row['image'])){
				    $xtpl->parse( 'main.cata.loop.image' );
				}
				if(!empty($row['sdt'])){
				    $xtpl->parse( 'main.cata.loop.telephone' );
				}
				if(!empty($row['email'])){
				    $xtpl->parse( 'main.cata.loop.email' );
				}
				$xtpl->parse( 'main.cata.loop' );
			}
			$xtpl->parse( 'main.cata' );
		}
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_store_main_list()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_store_main_list ($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config,$global_array_cat, $module_info, $op;

    $xtpl = new XTemplate('mainlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    foreach($array_data as $cata) {
		$xtpl->assign( 'CAT', $cata );
		if(!empty($cata['data'])) {
			foreach($cata['data'] as $row) {
				$xtpl->assign( 'ROW', $row );
				if(!empty($row['image'])){
				    $xtpl->parse( 'main.cata.loop.image' );
				}
				if(!empty($row['sdt'])){
				    $xtpl->parse( 'main.cata.loop.telephone' );
				}
				if(!empty($row['email'])){
				    $xtpl->parse( 'main.cata.loop.email' );
				}
				$xtpl->parse( 'main.cata.loop' );
			}
			$xtpl->parse( 'main.cata');
		}
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_store_list()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_store_list ($array_data, $generate_page)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config,$global_array_cat, $module_info, $op;
    $xtpl = new XTemplate('list.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

    foreach($array_data as $cata)
	{
		if(!empty($cata['data']))
		{
			foreach($cata['data'] as $row)
			{
				$xtpl->assign( 'ROW', $row );
				if(!empty($row['image'])){
				    $xtpl->parse( 'main.loop.image' );
				}
				if(!empty($row['sdt'])){
				    $xtpl->parse( 'main.loop.telephone' );
				}
				if(!empty($row['email'])){
				    $xtpl->parse( 'main.loop.email' );
				}
				$xtpl->parse( 'main.loop' );
			}
		}
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}



/**
 * nv_theme_store_gird()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_store_gird ($array_data, $generate_page)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config,$global_array_cat, $module_info, $op;
    $xtpl = new XTemplate('gird.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

    foreach($array_data as $cata)
	{
		if(!empty($cata['data']))
		{
			foreach($cata['data'] as $row)
			{
				$xtpl->assign( 'ROW', $row );
				if(!empty($row['image'])){
				    $xtpl->parse( 'main.loop.image' );
				}
				if(!empty($row['sdt'])){
				    $xtpl->parse( 'main.loop.telephone' );
				}
				if(!empty($row['email'])){
				    $xtpl->parse( 'main.loop.email' );
				}
				$xtpl->parse( 'main.loop' );
			}
		}
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}


/**
 * nv_theme_store_detail()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_store_detail ( $array_data, $array_lienquan ) {
    global $global_config, $module_name, $module_file, $client_info, $lang_module, $page_config, $module_config, $module_info, $op, $global_array_cat, $module_upload;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'TEMPLATE', $module_info['template'] );

    $xtpl->assign( 'CATA', $global_array_cat[$array_data['catalog']] );
	$xtpl->assign( 'LINKFB',$client_info['selfurl'] );

    $xtpl->assign( 'CONTENT', $array_data );

    if(!empty($array_data['image'])){
        $xtpl->parse( 'main.image' );
    }
    if(!empty($array_data['sdt'])){
        $xtpl->parse( 'main.telephone' );
    }
    if(!empty($array_data['email'])){
        $xtpl->parse( 'main.email' );
    }
    if(!empty($array_data['website'])){
        $xtpl->parse('main.website');
    }
    if(!empty($array_data['facebook'])){
        $xtpl->parse('main.facebook');
    }

    if(!empty($array_data['dia_chi'])){
        $xtpl->parse('main.address');
    }

    if(!empty($global_array_cat[$array_data['catalog']])){
        $xtpl->assign( 'CATEGORY', $global_array_cat[$array_data['catalog']]);
        $xtpl->parse( 'main.category' );
    }

	// lấy hình ảnh khác

	if(!empty($array_data['bodytext'])){$xtpl->parse( 'main.bodytext' );}
	if($page_config['thaoluan']==1){$xtpl->parse( 'main.thaoluan' );}

	if(!empty($array_data['images_orther'])) {

    	$array_images = explode('|',$array_data['images_orther']);
    	foreach( $array_images as $img)
    	{
    		$anh_orther['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' .$img;
    		$path_parts = pathinfo($anh_orther['image']);
    		$anh_orther['imagealt'] = !empty($path_parts['filename']) ? $path_parts['filename'] : $array_data['title'];
    		$xtpl->assign( 'IMAGE', $anh_orther );
    		$xtpl->parse( 'main.image_loop' );
    	}
    }

	$row['googmaps'] = @unserialize( $array_data['googmaps'] );

	$xtpl->assign( 'DATA', $row['googmaps']);
	$xtpl->assign( 'CONFIG', $page_config);

	if(!empty($array_lienquan))
	{
		foreach($array_lienquan as $row)
		{
			$xtpl->assign( 'OTHER', $row );
			if(!empty($row['image'])){
			    $xtpl->parse( 'main.other.loop.image' );
			}
			if(!empty($row['sdt'])){
			    $xtpl->parse( 'main.other.loop.telephone' );
			}
			if(!empty($row['email'])){
			    $xtpl->parse( 'main.other.loop.email' );
			}
			$xtpl->parse( 'main.other.loop' );
		}
		$xtpl->parse( 'main.other' );
	}

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_store_search()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_store_search ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_store_catalogy()
 *
 * @param mixed $array_data
 * @return
 */
function nv_theme_store_catalogy ( $array_data, $generate_page)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $catid, $global_array_cat;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    $xtpl->assign( 'cata', $global_array_cat[$catid] );

	foreach($array_data as $row)
	{
		$xtpl->assign( 'ROW', $row );
		if(!empty($row['image'])){
		    $xtpl->parse( 'main.loop.image' );
		}
		if(!empty($row['sdt'])){
		    $xtpl->parse( 'main.loop.telephone' );
		}
		if(!empty($row['email'])){
		    $xtpl->parse( 'main.loop.email' );
		}
		$xtpl->parse( 'main.loop' );
	}

	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}


    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}