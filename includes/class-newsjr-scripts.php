<?php

if(!defined('ABSPATH')) die('Sai daqui porra!');

if ( ! class_exists( 'NEWSJR_Scripts' ) ) :

class NEWSJR_Scripts {


	public function __construct(){

		//registra scripts para admin
		add_action('admin_enqueue_scripts', array($this, 'register_css'));
		add_action('admin_enqueue_scripts', array($this, 'register_js'));

		//registra scripts para frontend
		add_action('wp_enqueue_scripts', array($this, 'register_css_frontend'));
		add_action('wp_enqueue_scripts', array($this, 'register_js_frontend'));
	}

	public function register_css(){
		wp_enqueue_style('newsletter-jr',  NJR()->plugin_url() . '/assets/css/newsletter-jr.css', array(), '1.0.0');
		//wp_enqueue_style('jquery-tabs',  NJR()->plugin_url() . '/assets/css/jquery-tabs.css', array(), '1.11.4');
	}

	public function register_js(){
		wp_enqueue_script('jquery-tabs', NJR()->plugin_url() . '/assets/js/jquery-tabs.js', array('jquery'), '1.11.4', true);
		wp_enqueue_script('newsletter-jr', NJR()->plugin_url() . '/assets/js/newsletter-jr.js', array('jquery'), '1.0.0', true);
		wp_localize_script( 'newsletter-jr', 'ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		));
	}

	public function register_css_frontend(){
		wp_enqueue_style('newsletter-jr',  NJR()->plugin_url() . '/assets/css/newsletter-jr-frontend.css', array(), '1.0.0');
	}

	public function register_js_frontend(){
		wp_enqueue_script('validate', NJR()->plugin_url() . '/assets/js/jquery.validate.min.js', array('jquery'), '1.13.1', true);
		wp_enqueue_script('newsletter-jr-frontend', NJR()->plugin_url() . '/assets/js/newsletter-jr-frontend.js', array('jquery'), '1.0.0', true);
		wp_localize_script( 'newsletter-jr-frontend', 'ajax', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'txt_required' => __( 'Por favor preencha este campo obrigatório.', 'newsletter-jr' ),
			'txt_email_invalido' => __( 'O endereço de e-mail parece inválido.', 'newsletter-jr' )
		));
	}
}

new NEWSJR_Scripts;

endif;