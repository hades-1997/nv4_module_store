<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Thinhweb Blog <thinhwebhp@gmail.com>
 * @Copyright (C) 2019 Thinhweb Blog. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wednesday, 10 July 2019 01:05:00 GMT
 */

if (! defined('NV_IS_FILE_MODULES')) {
    die('Stop!!!');
}

$sql_drop_module = array();

$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_catalogy;";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config;";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_rows (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 alias varchar(250) NOT NULL,
 sdt varchar(250) DEFAULT '',
 email text DEFAULT '',
 website text DEFAULT '',
 facebook text DEFAULT '',
 catalog mediumint(9) NOT NULL DEFAULT '0',
 image varchar(255) DEFAULT '',
 images_orther text DEFAULT '',
 bodytext mediumtext NOT NULL,
 keywords text,
 title_seo varchar(250) NOT NULL,
 bodytext_seo text,
 tinhthanh smallint(4) NOT NULL DEFAULT '0',
 quanhuyen smallint(4) NOT NULL DEFAULT '0',
 xaphuong smallint(4) NOT NULL DEFAULT '0',
 duong smallint(4) NOT NULL DEFAULT '0',
 dia_chi varchar(250) DEFAULT '',
 dia_chi_day_du varchar(250) DEFAULT '',
 googmaps mediumblob NOT NULL,
 add_time int(11) NOT NULL DEFAULT '0',
 hitstotal mediumint(8) unsigned NOT NULL DEFAULT '0',
 weight tinyint(1) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_catalogy (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 alias varchar(250) NOT NULL,
 image varchar(255) DEFAULT '',
 bodytext mediumtext NOT NULL,
 keywords text,
 title_seo varchar(250) NOT NULL,
 bodytext_seo text,
 weight tinyint(1) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias)
)ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (
 config_name varchar(30) NOT NULL,
 config_value varchar(250) NOT NULL,
 UNIQUE KEY config_name (config_name)
)ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config VALUES
('viewtype', '3'),
('per_row', '4'),
('per_page', '12'),
('per_home', '4'),
('related_articles', '8'),
('alias_lower', '0'),
('facebookapi', '253805488841173'),
('thaoluan', '1'),
('key_map', 'AIzaSyACEFu9PecQfHUAR5IVZk7eGRxy9DAvqHM')";
