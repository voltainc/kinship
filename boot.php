<?php 
	
defined( 'ABSPATH' ) or die( 'ABSPATH not defined' );
// init DB
		  global $wpdb;
		  $charset_collate = $wpdb->get_charset_collate();
		  $table_name = $wpdb->prefix . 'person';
		  $sql = "CREATE TABLE `$table_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(100) DEFAULT NULL,
		  `age` int(11) DEFAULT NULL,
		  `status` bool DEFAULT NULL,
		  PRIMARY KEY(id)
		  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		  ";
		  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		  }
		
?>