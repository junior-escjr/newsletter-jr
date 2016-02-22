<?php 
/*

Plugin Name: Newsletter - Cadastrados
Plugin URI: https://github.com/juniorbdb
Version: 1.0
Author: Junior
Author URI: https://github.com/juniorbdb
Description: Lista todas as pessoas cadastradas para receber as newsletters
License: GPL2
Text Domain: newsletter-jr
Domain Path: languages/
*/

if(!defined('ABSPATH')) { die('Sai daqui porra!');}

if ( ! class_exists( 'NewsletterJr' ) ) :

final class NewsletterJr {

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){

		// inclui todos os arquivos do plugin
		$this->includes();
	}

	private function includes(){

		//criar e atualizar tabela do bd
		include_once( 'includes/class-newsjr-install.php' );

		//carrega js e css do plugin
		include_once( 'includes/class-newsjr-scripts.php' );

		//pega as informações da tabela e as exibe no admin
		include_once( 'includes/class-newsjr-lista-inscritos.php' );

		//carrega toda estrutura html
		include_once( 'includes/class-newsjr-init.php' );

		//Arquivo para inclusão de funções para ajax
		include_once( 'includes/function-ajax.php' );

	}

	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}
}

endif;

function NJR() {
	return NewsletterJr::instance();
}

$GLOBALS['newsletterjr'] = NJR();