<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

//change status
if( $nv_Request->isset_request( 'change_status', 'post, get' ) )
{
	$id = $nv_Request->get_int( 'id', 'post, get', 0 );
	$content = 'NO_' . $id;

	$query = 'SELECT status FROM ' . STORE . '_rows WHERE id=' . $id;
	$row = $db->query( $query )->fetch();
	if( isset( $row['status'] ) )
	{
		$status = ( $row['status'] ) ? 0 : 1;
		$query = 'UPDATE ' . STORE . '_rows SET status=' . intval( $status ) . ' WHERE id=' . $id;
		$db->query( $query );
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod( $module_name );
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}

if( $nv_Request->isset_request( 'ajax_action', 'post' ) )
{
	$id = $nv_Request->get_int( 'id', 'post', 0 );
	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
	$content = 'NO_' . $id;
	if( $new_vid > 0 )
	{
		$sql = 'SELECT id FROM ' . STORE . '_rows WHERE id!=' . $id . ' ORDER BY weight ASC';
		$result = $db->query( $sql );
		$weight = 0;
		while( $row = $result->fetch() )
		{
			++$weight;
			if( $weight == $new_vid ) ++$weight;
			$sql = 'UPDATE ' . STORE . '_rows SET weight=' . $weight . ' WHERE id=' . $row['id'];
			$db->query( $sql );
		}
		$sql = 'UPDATE ' . STORE . '_rows SET weight=' . $new_vid . ' WHERE id=' . $id;
		$db->query( $sql );
		$content = 'OK_' . $id;
	}
	$nv_Cache->delMod( $module_name );
	include NV_ROOTDIR . '/includes/header.php';
	echo $content;
	include NV_ROOTDIR . '/includes/footer.php';
	exit();
}
if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) ) {
		$weight=0;
		$sql = 'SELECT weight FROM ' . STORE . '_rows WHERE id =' . $db->quote( $id );
		$result = $db->query( $sql );
		list( $weight) = $result->fetch( 3 );

		$db->query('DELETE FROM ' . STORE . '_rows  WHERE id = ' . $db->quote( $id ) );
		if( $weight > 0)
		{
			$sql = 'SELECT id, weight FROM ' . STORE . '_rows WHERE weight >' . $weight;
			$result = $db->query( $sql );
			while(list( $id, $weight) = $result->fetch( 3 ))
			{
				$weight--;
				$db->query( 'UPDATE ' . STORE . '_rows SET weight=' . $weight . ' WHERE id=' . intval( $id ));
			}
		}
		$nv_Cache->delMod( $module_name );

		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}

$error = array();

$q = $nv_Request->get_title( 'q', 'post,get' );

// Fetch Limit
$show_view = false;
if ( ! $nv_Request->isset_request( 'id', 'post,get' ) )
{
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . STORE . '_rows' );

	if( ! empty( $q ) )
	{
		$db->where( 'title LIKE :q_title OR catalog LIKE :q_catalog OR image LIKE :q_image OR dia_chi LIKE :q_dia_chi' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_title', '%' . $q . '%' );
		$sth->bindValue( ':q_catalog', '%' . $q . '%' );
		$sth->bindValue( ':q_image', '%' . $q . '%' );
		$sth->bindValue( ':q_dia_chi', '%' . $q . '%' );
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'weight DESC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_title', '%' . $q . '%' );
		$sth->bindValue( ':q_catalog', '%' . $q . '%' );
		$sth->bindValue( ':q_image', '%' . $q . '%' );
		$sth->bindValue( ':q_dia_chi', '%' . $q . '%' );
	}
	$sth->execute();
}

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'OP', $op );

// LẤY DANH SÁCH NHÓM CỬA HÀNG RA
foreach($list_cata as $catalog)
{
    if($catalog['id'] == $row['catalog']){
	   $xtpl->assign( 'selected', 'selected=selected');
    }else{
	   $xtpl->assign( 'selected', '');
	   $xtpl->assign( 'catalog', $catalog );
	   $xtpl->parse( 'main.catalog' );
    }
}


// LẤY TỈNH THÀNH RA
$list_tinhthanh = $db->query('SELECT provinceid, title, type FROM '.STORE_ADD.'_province WHERE status = 1 ORDER BY weight DESC')->fetchAll();

foreach($list_tinhthanh as $tinhthanh)
{
	if($tinhthanh['provinceid'] == $row['tinhthanh'])
	{
	$tinhthanh['selected'] = 'selected=selected';
	}
	else $tinhthanh['selected'] = '';
	$xtpl->assign('l', $tinhthanh);
    $xtpl->parse('main.tinh');
}

if($row['quanhuyen'] > 0)
{
	// LẤY QUẬN HUYỆN RA
	$list_quan = $db->query('SELECT districtid, title, type FROM '.STORE_ADD.'_district WHERE provinceid = '. $row['tinhthanh'] .' and status = 1 ORDER BY weight DESC')->fetchAll();

	foreach($list_quan as $tinhthanh)
	{
		if($tinhthanh['districtid'] == $row['quanhuyen'])
		{
		$tinhthanh['selected'] = 'selected=selected';
		}
		else $tinhthanh['selected'] = '';
		$xtpl->assign('l', $tinhthanh);
		$xtpl->parse('main.quan');
	}
}

if($row['xaphuong'] > 0)
{
	// LẤY XÃ PHƯỜNG RA

	$list_xaphuong = $db->query('SELECT wardid, title ,type FROM '.STORE_ADD.'_ward WHERE districtid = '. $row['quanhuyen'] .' and status = 1')->fetchAll();

	foreach($list_xaphuong as $tinhthanh)
	{
		if($tinhthanh['wardid'] == $row['xaphuong'])
		{
		$tinhthanh['selected'] = 'selected=selected';
		}
		else $tinhthanh['selected'] = '';
		$xtpl->assign('l', $tinhthanh);
		$xtpl->parse('main.xa');
	}
}

$xtpl->assign( 'Q', $q );

if( $show_view )
{
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	if( ! empty( $q ) )
	{
		$base_url .= '&q=' . $q;
	}
	$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.view.generate_page' );
	}
	$number = $page > 1 ? ($per_page * ( $page - 1 ) ) + 1 : 1;
	while( $view = $sth->fetch() )
	{
		for( $i = 1; $i <= $num_items; ++$i )
		{
			$xtpl->assign( 'WEIGHT', array(
				'key' => $i,
				'title' => $i,
				'selected' => ( $i == $view['weight'] ) ? ' selected="selected"' : '') );
			$xtpl->parse( 'main.view.loop.weight_loop' );
		}
		$xtpl->assign( 'CHECK', $view['status'] == 1 ? 'checked' : '' );
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=add&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );

		if (!empty($view['image'])) {
		    if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload . '/' . $view['image'])) {
		        $view['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $view['image'];
		    } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $view['image'])) {
		        $view['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $view['image'];
		    } else {
		        $view['image'] = NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/images/' . $module_name . '/no-image.jpg';
		    }
		}else{
		    if(empty($view['image'])){
		        $view['image'] = NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/images/' . $module_name . '/no-image.jpg';
		    }else{
		        $view['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $view['image'];
		    }
		}

		$view['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$view['catalog']]['alias'] . '/' . $view['alias'] . $global_config['rewrite_exturl'];

		$view['catalog'] = $db->query('SELECT title,alias FROM '. NV_PREFIXLANG . '_'. $module_data . '_catalogy WHERE id ='.$view['catalog'])->fetchColumn();


		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}
	$xtpl->parse( 'main.view' );
}

if( ! empty( $error ) ) {
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['main'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
