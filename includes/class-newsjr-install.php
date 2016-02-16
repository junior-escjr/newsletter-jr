<?php

if(!defined('ABSPATH')) { die('Sai daqui porra!');}

if ( ! class_exists( 'NEWSJR_Install' ) ) :

class NEWSJR_Install {

	public function __construct() {
		register_activation_hook( __FILE__, array($this, 'install') );
		add_action( 'plugins_loaded', array($this, 'install') );
	}

	public function install(){
		$this->create_tables();
		$this->version_plugin_db();
	}

	private function version_plugin_db(){
		global $jal_db_version;
		if ( get_site_option( 'jal_db_version' ) != $jal_db_version ) {
	       $this->update_plugin_db();
	    }
	}
	
	private function create_tables(){

		global $wpdb;
		global $jal_db_version;
		$jal_db_version = '1.0';
		
		$table_name = $wpdb->prefix . 'rg_newsletter';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id_rg_usuario int(20) NOT NULL auto_increment,
			nome_rg_usuario varchar(200) NOT NULL,
			email_rg_usuario varchar(200) NOT NULL,
			ano_rg_usuario int(20) NOT NULL,
			data_rg_usuario date NOT NULL,
			PRIMARY KEY  (id_rg_usuario),
			KEY id_rg_usuario (id_rg_usuario)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( "jal_db_version", $jal_db_version );
	}

	private function update_plugin_db(){
		global $wpdb;
		global $jal_db_version;
		$installed_ver = get_option( "jal_db_version" );
		
		if ( $installed_ver != $jal_db_version ) :
			$table_name = $wpdb->prefix . 'rg_newsletter';
			
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
				id_rg_usuario int(20) NOT NULL auto_increment,
				nome_rg_usuario varchar(200) NOT NULL,
				email_rg_usuario varchar(200) NOT NULL,
				ano_rg_usuario datetime NULL default null,
				PRIMARY KEY  (id_rg_usuario),
				KEY id_rg_usuario (id_rg_usuario)
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

			update_option( "jal_db_version", $jal_db_version );
		endif;
	}
}

new NEWSJR_Install;

endif;