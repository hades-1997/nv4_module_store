<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if ( ! defined( 'NV_IS_MOD_STORE' ) ) die( 'Stop!!!' );

$channel = array();
$items = array();

$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['atomlink'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=rss';
$channel['description'] = ! empty( $module_info['description'] ) ? $module_info['description'] : $global_config['site_description'];

if ( $module_info['rss'] )
{
	$catid = 0;
	if ( isset( $array_op[1] ) )
	{
	    $alias_cat_url = $array_op[1];
	    $cattitle = '';
	    foreach ( $global_array_cat as $catid_i => $array_cat_i )
	    {
	        if ( $alias_cat_url == $array_cat_i['alias'] )
	        {
	            $catid = $catid_i;
	            break;
	        }
	    }
	}

	$db->sqlreset()
		->select( 'id, title, alias, image, catalog, bodytext, bodytext_seo, add_time' )
		->order( 'add_time DESC' )
		->limit( 30 );

	if ( ! empty( $catid ) ) {
		$channel['title'] = $module_info['custom_title'] . ' - ' . $global_array_cat[$catid]['title'];
	    $channel['link'] = NV_MY_DOMAIN . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=rss/' . $alias_cat_url;
	    $channel['description'] = $global_array_cat[$catid]['description'];

		$db->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
		  ->where( 'status=1 AND catalog = ' . $catid);
	} else {
		$db->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
			->where( 'status=1' );
	}

    $result = $db->query( $db->sql() );
    while ( list( $id, $title, $alias, $image, $catalog, $bodytext, $bodytext_seo, $add_time ) = $result->fetch( 3 ) ) {
        $description = strip_tags($bodytext);
        $description = nv_clean60($description, 70);
        $add_time = nv_date('d/m/Y H:i A', $add_time);

        if (!empty($image)) {
            if (file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload . '/' . $image)) {
                $image = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $image;
            } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $image)) {
                $image = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $image;
            } else {
                $image = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
            }
        }else{
            if(empty($image)){
                $image = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_name . '/no-image.jpg';
            }else{
                $image = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $image;
            }
        }

        $catalias = $global_array_cat[$catalog]['alias'];
        $rimages = ( ! empty( $image ) ) ? '<img src="' . NV_MY_DOMAIN . $image . '" width="100" align="left" border="0">' : '';
        $items[] = array(
            'title' => $title,
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $catalias . '/' . $alias . $global_config['rewrite_exturl'],
			'guid' => $module_name . '_' . $id,
            'description' => $rimages . $description,
            'pubdate' => $add_time
        );
    }
}

nv_rss_generate( $channel, $items );
die();