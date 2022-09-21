<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if (empty($list_cata)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=catalogy');
    die();
}

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    $alias = strtolower($alias);

    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE alias = :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetchColumn()) {
        if($id>0){
            $main_alias = $db->query('SELECT alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id)->fetchColumn();
            $alias = $main_alias . '-' . $alias;
        }else{
            $weight = $db->query('SELECT MAX(id) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows')->fetchColumn();
            $weight = intval($weight) + 1;
            $alias = $alias . '-' . $weight;
        }
    }

    include NV_ROOTDIR . '/includes/header.php';
    echo $alias;
    include NV_ROOTDIR . '/includes/footer.php';
}

if( $nv_Request->isset_request( 'city_id_ajax', 'post, get' ) )
{
	$json = array();

	$city_id = $nv_Request->get_int( 'city_id_ajax', 'post', 0 );

	$token = $nv_Request->get_string( 'token', 'post', '' );

	if( $city_id && $token )
	{
		$sql = 'SELECT districtid, type, title FROM ' . STORE_ADD. '_district WHERE status = 1 AND provinceid= ' . intval( $city_id ) . ' ORDER BY weight ASC';
		$result = $db_slave->query( $sql );

		while( $row = $result->fetch() )
		{
			$json['data'][] = $row;
		}
		$result->closeCursor();
	}

	getOutputJson( $json );
}

if( $nv_Request->isset_request( 'district_id_ajax', 'post, get' ) )
{
	$json = array();

	$district_id = $nv_Request->get_int( 'district_id_ajax', 'post', 0 );

	$token = $nv_Request->get_string( 'token', 'post', '' );

	if( $district_id && $token )
	{
		$sql = 'SELECT wardid, type, title FROM ' . STORE_ADD . '_ward WHERE status = 1 AND districtid= ' . intval( $district_id );
		$result = $db_slave->query( $sql );
		while( $row = $result->fetch() )
		{
			$json['ward'][] = $row;
		}
		$result->closeCursor();

	}

	getOutputJson( $json );
}

if ( $nv_Request->isset_request( 'get_alias_title', 'post' ) )
{
	$alias = $nv_Request->get_title( 'get_alias_title', 'post', '' );
	$alias = change_alias( $alias );
	die( $alias );
}

if($nv_Request->isset_request('id_tinhthanh', 'get'))
{
	$id_tinhthanh = $nv_Request->get_int('id_tinhthanh','get', 0);
	if($id_tinhthanh > 0)
	{
		$list_quan = $db->query('SELECT * FROM '.STORE_ADD.'_district WHERE status = 1 and city_id = '. $id_tinhthanh .' ORDER BY weight ASC')->fetchAll();
		$html = '<option value=0>-- Chọn quận huyện --</option>';
					foreach($list_quan as $l)
					{
						$html .= '<option value='.$l['district_id'].'>'.$l['type'] . ' '. $l['title'].'</option>';
					}
		print $html;die;
	}

}

if($nv_Request->isset_request('id_quanhuyen', 'get'))
{
	$id_quanhuyen = $nv_Request->get_int('id_quanhuyen','get', 0);
	if($id_quanhuyen > 0)
	{
		$list_quan = $db->query('SELECT * FROM '.STORE_ADD.'_ward WHERE status = 1 and district_id = '. $id_quanhuyen .' ORDER BY title ASC')->fetchAll();
		$html = '<option value=0>-- Chọn xã phường --</option>';
					foreach($list_quan as $l)
					{
						$html .= '<option value='.$l['ward_id'].'>'.$l['type'] . ' '. $l['title'].'</option>';
					}
		print $html;die;
	}

}

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
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{

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

$row = array();
$row['googmaps'] = array('lat'=>'10.871692', 'lng'=> '106.535366', 'zoom'=> 15);
$error = array();
$row['id'] = $nv_Request->get_int( 'id', 'post,get', 0 );
if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$row['title'] = $nv_Request->get_title( 'title', 'post', '' );
	$row['sdt'] = $nv_Request->get_title( 'sdt', 'post', '' );
	$row['email'] = $nv_Request->get_title( 'email', 'post', '' );
	$row['website'] = $nv_Request->get_title( 'website', 'post', '' );
	$row['facebook'] = $nv_Request->get_title( 'facebook', 'post', '' );

	$row['alias'] = $nv_Request->get_title('alias', 'post', '');
	$row['alias'] = (empty($row['alias'])) ? change_alias($row['title']) : change_alias($row['alias']);
	$row['catalog'] = $nv_Request->get_int( 'catalog', 'post', 0 );
	$row['bodytext'] = $nv_Request->get_editor( 'bodytext', '', NV_ALLOWED_HTML_TAGS );
	$row['keywords'] = $nv_Request->get_string( 'keywords', 'post', '' );
	$row['title_seo'] = $nv_Request->get_title( 'title_seo', 'post', '' );
	$row['bodytext_seo'] = $nv_Request->get_string( 'bodytext_seo', 'post', '' );
	$row['tinhthanh'] = $nv_Request->get_int( 'city_id', 'post', 0 );
	$row['quanhuyen'] = $nv_Request->get_int( 'district_id', 'post', 0 );
	$row['xaphuong'] = $nv_Request->get_int( 'ward_id', 'post', 0 );
	$row['duong'] = $nv_Request->get_int( 'street_id', 'post', 0 );
	$row['dia_chi'] = $nv_Request->get_title( 'diachi', 'post', '' );
	$row['dia_chi_day_du'] = $nv_Request->get_title( 'dia_chi_day_du', 'post', '' );

	$row['googmaps'] = $nv_Request->get_typed_array( 'googmaps', 'post', array() );

	$row['image'] = $nv_Request->get_title( 'home_img', 'post', '' );

    if( is_file( NV_DOCUMENT_ROOT . $row['image'] ) ) {
		$row['image'] = substr( $row['image'], strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' ) );
	} else {
		$row['image'] = '';
	}

	// Xu ly anh minh hoa khac
	$otherimage = $nv_Request->get_typed_array( 'otherimage', 'post', 'string' );
	$array_otherimage = array( );
	foreach( $otherimage as $otherimage_i )
	{
		if( !nv_is_url( $otherimage_i ) and file_exists( NV_DOCUMENT_ROOT . $otherimage_i ) )
		{
			$lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' );
			$otherimage_i = substr( $otherimage_i, $lu );
		}
		elseif( !nv_is_url( $otherimage_i ) )
		{
			$otherimage_i = '';
		}
		if( !empty( $otherimage_i ) )
		{
			$array_otherimage[] = $otherimage_i;
		}
	}
	$row['images_orther'] = implode( '|', $array_otherimage );


	if( empty( $row['title'] ) )
	{
		$error[] = $lang_module['error_required_title'];
	}
	elseif( empty( $row['alias'] ) )
	{
		$error[] = $lang_module['error_required_alias'];
	}
	elseif( empty( $row['catalog'] ) )
	{
		$error[] = $lang_module['error_required_catalog'];
	}

	if( empty( $error ) )
	{
		try
		{
			$googmaps = serialize( $row['googmaps'] );

			if( empty( $row['id'] ) )
			{
			    $row['add_time'] = NV_CURRENTTIME;
				$stmt = $db->prepare( 'INSERT INTO ' . STORE . '_rows (title, alias, catalog, sdt, email, website, facebook,  image, images_orther, bodytext, keywords, title_seo, bodytext_seo, tinhthanh, quanhuyen, xaphuong, duong, dia_chi, dia_chi_day_du, googmaps, add_time, weight, status) VALUES (:title, :alias, :catalog, :sdt,:email,:website,:facebook, :image, :images_orther, :bodytext, :keywords,  :title_seo, :bodytext_seo, :tinhthanh, :quanhuyen, :xaphuong, :duong, :dia_chi, :dia_chi_day_du, :googmaps, :add_time, :weight, :status)' );
				$stmt->bindParam( ':add_time', $row['add_time'], PDO::PARAM_INT );
				$weight = $db->query( 'SELECT max(weight) FROM ' . STORE . '_rows' )->fetchColumn();
				$weight = intval( $weight ) + 1;
				$stmt->bindParam( ':weight', $weight, PDO::PARAM_INT );
				$stmt->bindValue( ':status', 1, PDO::PARAM_INT );
			} else {
				$stmt = $db->prepare( 'UPDATE ' . STORE . '_rows SET title = :title, alias = :alias, catalog = :catalog, sdt =:sdt, email =:email, website =:website, facebook =:facebook, image = :image, images_orther =:images_orther, bodytext = :bodytext, keywords = :keywords, title_seo =:title_seo, bodytext_seo =:bodytext_seo, tinhthanh = :tinhthanh, quanhuyen = :quanhuyen, xaphuong = :xaphuong, duong =:duong, dia_chi = :dia_chi, dia_chi_day_du =:dia_chi_day_du, googmaps=:googmaps WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':title', $row['title'], PDO::PARAM_STR );
			$stmt->bindParam( ':title_seo', $row['title_seo'], PDO::PARAM_STR );
			$stmt->bindParam( ':alias', $row['alias'], PDO::PARAM_STR );
			$stmt->bindParam( ':sdt', $row['sdt'], PDO::PARAM_STR );
			$stmt->bindParam( ':email', $row['email'], PDO::PARAM_STR );
			$stmt->bindParam( ':website', $row['website'], PDO::PARAM_STR );
			$stmt->bindParam( ':facebook', $row['facebook'], PDO::PARAM_STR );
			$stmt->bindParam( ':catalog', $row['catalog'], PDO::PARAM_INT );
			$stmt->bindParam( ':image', $row['image'], PDO::PARAM_STR );
			$stmt->bindParam( ':images_orther', $row['images_orther'], PDO::PARAM_STR );
			$stmt->bindParam( ':bodytext', $row['bodytext'], PDO::PARAM_STR, strlen($row['bodytext']) );
			$stmt->bindParam( ':keywords', $row['keywords'], PDO::PARAM_STR, strlen($row['keywords']) );
			$stmt->bindParam( ':bodytext_seo', $row['bodytext_seo'], PDO::PARAM_STR, strlen($row['keywords']) );
			$stmt->bindParam( ':tinhthanh', $row['tinhthanh'], PDO::PARAM_INT );
			$stmt->bindParam( ':quanhuyen', $row['quanhuyen'], PDO::PARAM_INT );
			$stmt->bindParam( ':xaphuong', $row['xaphuong'], PDO::PARAM_INT );
			$stmt->bindParam( ':duong', $row['duong'], PDO::PARAM_INT );
			$stmt->bindParam( ':dia_chi', $row['dia_chi'], PDO::PARAM_STR );
			$stmt->bindParam( ':dia_chi_day_du', $row['dia_chi_day_du'], PDO::PARAM_STR );
			$stmt->bindParam( ':googmaps', $googmaps, PDO::PARAM_STR, strlen( $googmaps ) );

			$exc = $stmt->execute();
			if( $exc )
			{
				$nv_Cache->delMod( $module_name );
				Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main' );
				die();
			}
		}
		catch( PDOException $e )
		{
			trigger_error( $e->getMessage() );
			die( $e->getMessage() ); //Remove this line after checks finished
		}
	}
}
elseif( $row['id'] > 0 )
{
	$row = $db->query( 'SELECT * FROM ' . STORE . '_rows WHERE id=' . $row['id'] )->fetch();
	$row['googmaps'] = @unserialize( $row['googmaps'] );
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['id'] = 0;
	$row['title'] = '';
	$row['alias'] = '';
	$row['sdt'] = '';
	$row['email'] = '';
	$row['website'] = '';
	$row['facebook'] = '';
	$row['catalog'] = 0;
	$row['image'] = '';
	$row['bodytext'] = '';
	$row['keywords'] = '';
	$row['title_seo'] = '';
	$row['bodytext_seo'] = '';
	$row['tinhthanh'] = 0;
	$row['quanhuyen'] = 0;
	$row['xaphuong'] = 0;
	$row['duong'] = 0;
	$row['dia_chi'] = '';
	$row['dia_chi_day_du'] = '';
	$row['googmaps'] = array('lat'=>'20.675312', 'lng'=> '106.4820168', 'zoom'=> 22);

}

if( defined( 'NV_EDITOR' ) ) require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
$row['bodytext'] = htmlspecialchars( nv_editor_br2nl( $row['bodytext'] ) );
if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
{
	$row['bodytext'] = nv_aleditor( 'bodytext', '100%', '300px', $row['bodytext'] );
}
else
{
	$row['bodytext'] = '<textarea style="width:100%;height:300px" name="bodytext">' . $row['bodytext'] . '</textarea>';
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


///// xuất ra ngoài site
	//others images
$stt = 1;
if(!empty($row['images_orther'])) {
$array_images = explode('|',$row['images_orther']);
	foreach( $array_images as $img)
	{
		$anh_orther = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' .$img;
		$xtpl->assign( 'anh_orther', $anh_orther );
		// THƯ MỤC HIỆN TẠI
		$current = explode('/',$img);
		if(count($current) > 1)
		{
			$thu_muc = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'.$current[0];
		}
		else
		{
			$thu_muc = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload ;
		}
		$xtpl->assign( 'stt', $stt );
		$xtpl->assign( 'current',$thu_muc );
		$stt++;
		$xtpl->parse( 'main.anh_orther' );
	}
}
$xtpl->assign('FILE_ITEMS', $stt);

$currentpath = NV_UPLOADS_DIR . '/' . $module_upload ;
if( !file_exists( $currentpath ) )
{
	nv_mkdir( NV_UPLOADS_REAL_DIR . '/' . $module_upload, date( 'Y_m' ), true );
}
$xtpl->assign( 'UPLOAD_CURRENT', $currentpath );

$xtpl->assign( 'TOKEN', md5( session_id() . $global_config['sitekey'] ) );

$xtpl->assign( 'GOOGLEMAPLAT', isset( $row['googmaps']['lat'] ) ? $row['googmaps']['lat'] : '' );
$xtpl->assign( 'GOOGLEMAPLNG', isset( $row['googmaps']['lng'] ) ? $row['googmaps']['lng'] : '' );
$xtpl->assign( 'GOOGLEMAPZOOM', isset( $row['googmaps']['zoom'] ) ? $row['googmaps']['zoom'] : '' );

if( $row['googmaps'] ) {
	$xtpl->parse( 'main.addMarker' );
	$xtpl->assign( 'GOOGLEMAPLAT1', isset( $row['googmaps']['lat'] ) ? $row['googmaps']['lat'] : '' );
	$xtpl->assign( 'GOOGLEMAPLNG1', isset( $row['googmaps']['lng'] ) ? $row['googmaps']['lng'] : '' );
	$xtpl->assign( 'GOOGLEMAPZOOM1', isset( $row['googmaps']['zoom'] ) ? $row['googmaps']['zoom'] : '' );
}

$sql = 'SELECT * FROM ' . $db_config['prefix'] . '_location_province ORDER BY weight ASC';
$global_raovat_city = $nv_Cache->db( $sql, 'provinceid', 'location' );
foreach( $global_raovat_city as $key => $item )
{
	$xtpl->assign( 'CITY', array(
		'key' => $key,
		'name' => $item['title'],
		'selected' => ( $row['tinhthanh'] == $key ) ? 'selected="selected"' : '' ) );
	$xtpl->parse( 'main.city' );
}

if( $row['tinhthanh'] )
{
	$sql = 'SELECT districtid, type, title FROM ' . $db_config['prefix'] . '_location_district WHERE status = 1 AND provinceid= ' . intval( $row['tinhthanh'] ) . ' ORDER BY weight ASC';
	$result = $db_slave->query( $sql );

	while( $data = $result->fetch() )
	{
		$xtpl->assign( 'DISTRICT', array(
			'key' => $data['districtid'],
			'name' => $data['title'],
			'type' => $data['type'],
			'selected' => ( $data['districtid'] == $row['quanhuyen'] ) ? 'selected="selected"' : '' ) );
		$xtpl->parse( 'main.district' );
	}
	$result->closeCursor();
}

if( $row['quanhuyen'] )
{
	$sql = 'SELECT wardid, type, title FROM ' . $db_config['prefix'] . '_location_ward WHERE status = 1 AND districtid= ' . intval( $row['quanhuyen'] );
	$result = $db_slave->query( $sql );

	while( $data = $result->fetch() )
	{
		$xtpl->assign( 'WARD', array(
			'key' => $data['wardid'],
			'name' => $data['title'],
			'type' => $data['type'],
			'selected' => ( $data['wardid'] == $row['xaphuong'] ) ? 'selected="selected"' : '' ) );
		$xtpl->parse( 'main.ward' );
	}
	$result->closeCursor();
}

if(!empty($row['image'])){
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'] ;
}

$xtpl->assign( 'ROW', $row );

if (!empty($list_cata)) {
    foreach ($list_cata as $key => $item) {
        $item['select'] = ($row['catalog'] == $item['id']) ? "selected=\"selected\"" : "";
        $xtpl->assign('CAT', $item);
        $xtpl->parse('main.catalog');
    }
}

if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}
if( empty( $row['id'] ) )
{
	$xtpl->parse( 'main.auto_get_alias' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['main'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
