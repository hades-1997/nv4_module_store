<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if (! defined('NV_SYSTEM')) {
    die('Stop!!!');
}
if (! nv_function_exists('nv_address')) {
    /**
     * nv_message_page()
     *
     * @return
     */
    function nv_address($block_config)
    {
        global $nv_Cache, $global_config, $site_mods, $db_slave, $module_name,$db_config, $db,  $array_op, $catid, $nv_Request;
        $module = $block_config['module'];
            if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/'.$module.'/block.address.tpl')) {
                $block_theme = $global_config['module_theme'];
            } elseif (file_exists(NV_ROOTDIR . '/themes/' . $global_config['site_theme'] . '/modules/'.$module.'/block.address.tpl')) {
                $block_theme = $global_config['site_theme'];
            } else {
                $block_theme = 'default';
            }
            $xtpl = new XTemplate('block.address.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/'.$module);
			$xtpl->assign( 'module_name', $module );

			$global_array_store = array();
			$sql = 'SELECT * FROM '.$db_config['dbsystem']. '.' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_catalogy WHERE status > 0';
			$list = $nv_Cache->db($sql, 'id', $module_name);
			if (!empty($list)) {
				foreach ($list as $l) {
					$global_array_store[$l['id']] = $l;
					$global_array_store[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
				}
			}
		   $id_tinhthanh  = $id_quanhuyen = $id_xaphuong = 0;

		   $catid_search = 0;

			if(!empty($array_op[1]))
			$catid_search = $db->query('SELECT id FROM '.$db_config['dbsystem']. "."  . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_catalogy WHERE alias like "%'. $array_op[1] .'%"')->fetchColumn();


			$where ='';
			if(count($array_op) > 0)
			{
				if($array_op[0] == 'map' and !empty($array_op[1]))
				{

				}
				if($catid_search > 0)
				{
					if($catid_search > 0)
					{
						// ti???p t???c ph??n t??ch t???nh th??nh qu???n huy???n x?? ph?????ng
						if($array_op[0] == 'map' and !empty($array_op[2]))
						{
							// T??M ID T???NH TH??NH D???A V??O ALIAS
							$id_tinhthanh = $db->query("SELECT provinceid FROM ".$db_config['dbsystem']. "." .$db_config['prefix']. "_location_province WHERE alias like '". $array_op[2] ."'  ORDER BY weight ASC")->fetchColumn();
						}
						if($array_op[0] == 'map' and !empty($array_op[2]) and !empty($array_op[3]) and $id_tinhthanh > 0 )
						{
							$id_quanhuyen = $db->query("SELECT districtid FROM ".$db_config['dbsystem']. "." .$db_config['prefix']. "_location_district WHERE provinceid =". $id_tinhthanh ." AND alias like '". $array_op[3] ."'")->fetchColumn();
						}
						if($array_op[0] == 'map' and !empty($array_op[1]) and !empty($array_op[3]) and !empty($array_op[4])  and $id_tinhthanh > 0 and $id_quanhuyen > 0)
						{
							$id_xaphuong = $db->query("SELECT wardid FROM ".$db_config['dbsystem']. "." .$db_config['prefix']. "_location_ward WHERE  districtid =". $id_quanhuyen ." AND alias like '". $array_op[4] ."'")->fetchColumn();
						}
					}
				}
				else
				{
					if($array_op[0] == 'map' and !empty($array_op[1]))
					{
						// T??M ID T???NH TH??NH D???A V??O ALIAS
						$id_tinhthanh = $db->query("SELECT provinceid FROM ".$db_config['dbsystem']. "." .$db_config['prefix']. "_location_province WHERE alias like '". $array_op[1] ."'  ORDER BY weight ASC")->fetchColumn();
					}
					if($array_op[0] == 'map' and !empty($array_op[1]) and !empty($array_op[2]) and $id_tinhthanh > 0 )
					{
						$id_quanhuyen = $db->query("SELECT districtid FROM ".$db_config['dbsystem']. "." .$db_config['prefix']. "_location_district WHERE provinceid =". $id_tinhthanh ." AND alias like '". $array_op[2] ."'")->fetchColumn();
					}
					if($array_op[0] == 'map' and !empty($array_op[1]) and !empty($array_op[2]) and !empty($array_op[3])  and $id_tinhthanh > 0 and $id_quanhuyen > 0)
					{
						$id_xaphuong = $db->query("SELECT wardid FROM ".$db_config['dbsystem']. "." .$db_config['prefix']. "_location_ward WHERE  districtid =". $id_quanhuyen ." AND alias like '". $array_op[3] ."'")->fetchColumn();
					}
				}
				if($id_tinhthanh > 0)
				$where .=' AND tinhthanh='.$id_tinhthanh;
				if($id_quanhuyen > 0)
				$where .=' AND quanhuyen='.$id_quanhuyen;
				if($id_xaphuong > 0)
				$where .=' AND xaphuong='.$id_xaphuong;
			}

			if($catid_search > 0)
			{$where .=' AND catalog='.$catid_search;}

			elseif($catid > 0)
			{
			$where .=' AND catalog='.$catid;
			$catid_search = $catid;
			}


			 $sql = 'SELECT * FROM '.$db_config['dbsystem']. "."  . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_rows WHERE status=1 '. $where .' ORDER BY weight DESC';

			 $list_store = $db->query($sql)->fetchAll();
			// print_r($list_store);die;
			foreach($list_store as $row)
			{
				$row['link'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $row['alias'],true);
				$row['googmaps'] = @unserialize( $row['googmaps'] );
				if( $row['googmaps'] )
				{
					$xtpl->assign( 'lat', isset( $row['googmaps']['lat'] ) ? $row['googmaps']['lat'] : '' );
					$xtpl->assign( 'lng', isset( $row['googmaps']['lng'] ) ? $row['googmaps']['lng'] : '' );
					$xtpl->assign( 'zoom', isset( $row['googmaps']['zoom'] ) ? $row['googmaps']['zoom'] : '' );
				}else{
					$xtpl->assign( 'lat', 21.01324600018122 );
					$xtpl->assign( 'lng', 105.83596636250002 );
					$xtpl->assign( 'GOOGLEMAPZOOM1', 15 );
				}
				// H??NH ???NH LO???I
				$xtpl->assign( 'anh_chinhanh', NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' .$module. '/' .$global_array_store[$row['catalog']]['image']);
				$row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $row['image'];
				$xtpl->assign( 'row', $row );
				$xtpl->parse( 'main.loop' );
				$xtpl->parse( 'main.loop_left' );
			}
			$sql = 'SELECT * FROM '  .$db_config['dbsystem']. '.' .$db_config['prefix']. '_location_province ORDER BY weight ASC';
			$global_raovat_city = $nv_Cache->db( $sql, 'provinceid', 'location' );
			foreach( $global_raovat_city as $key => $item )
			{
				$xtpl->assign( 'CITY', array(
					'key' => $key,
					'alias' =>  $item['alias'],
					'name' => $item['title'],
					'selected' => ( $id_tinhthanh == $key ) ? 'selected="selected"' : '' ) );
				$xtpl->parse( 'main.city' );
			}
			if( $id_tinhthanh )
			{
				$sql = 'SELECT districtid, title, alias, type FROM ' .$db_config['dbsystem']. '.' .$db_config['prefix']. '_location_district WHERE status = 1 AND provinceid= ' . intval( $id_tinhthanh ) . ' ORDER BY weight ASC';
				$result = $db->query( $sql );
				while( $data = $result->fetch() )
				{
					$xtpl->assign( 'DISTRICT', array(
						'key' => $data['districtid'],
						'alias' =>  $data['alias'],
						'type' =>  $data['type'],
						'name' => $data['title'],
						'selected' => ( $data['districtid'] == $id_quanhuyen) ? 'selected="selected"' : '' ) );
					$xtpl->parse( 'main.district' );
				}
			}
			if( $id_quanhuyen )
			{
				$sql = 'SELECT wardid, title, alias, type FROM ' .$db_config['dbsystem']. '.' .$db_config['prefix']. '_location_ward WHERE status = 1 AND districtid= ' . intval( $id_quanhuyen );
				$result = $db->query( $sql );
				while( $data = $result->fetch() )
				{
					$xtpl->assign( 'WARD', array(
						'key' => $data['wardid'],
						'alias' =>  $data['alias'],
						'type' =>  $data['type'],
						'name' => $data['title'],
						'selected' => ( $data['wardid'] == $id_xaphuong ) ? 'selected="selected"' : '' ) );
					$xtpl->parse( 'main.ward' );
				}
			}
			// xu???t danh s??ch lo???i s???n ph???m ra
			$sql = 'SELECT id, title, alias FROM '.$db_config['dbsystem']. "."  . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_catalogy ORDER BY weight ASC';
			$result = $db->query( $sql );
				while( $data = $result->fetch() )
				{
					$xtpl->assign( 'CATALOGY', array(
						'id' => $data['id'],
						'title' =>  $data['title'],
						'alias' =>  $data['alias'],
						'selected' => ( $data['id'] == $catid_search ) ? 'selected="selected"' : '' ) );
					$xtpl->parse( 'main.CATALOGY' );
				}
			//print_r($global_array_store);die;
            $xtpl->parse('main');
            return $xtpl->text('main');
	}
$content = nv_address($block_config);
}