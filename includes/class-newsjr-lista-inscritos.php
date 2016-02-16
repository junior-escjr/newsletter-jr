<?php

if(!defined('ABSPATH')) { die('Sai daqui porra!');}

if ( ! class_exists( 'NEWSJR_Query' ) ) :

class NEWSJR_Query {

	public function retornaCadastradosNewsletter(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'rg_newsletter';
		$resultado = $this->filtroAno().$this->filtroMes();

		$sql = 'SELECT * FROM '. $table_name .' where 1 = 1 '. $resultado .' ORDER BY id_rg_usuario DESC';

		return $wpdb->get_results($sql);
	}

	private function filtroAno(){
		$resultado = '';
		if(isset($_GET['ano']) && !empty($_GET['ano'])) :
			$resultado .= ' AND ano_rg_usuario ='. $_GET['ano'] . ' ';
		endif;
		return $resultado;
	}

	private function filtroMes(){
		$resultado = '';
		if(isset($_GET['mes']) && !empty($_GET['mes'])) :
			$resultado .= ' AND mes_rg_usuario ='. $_GET['mes'] . ' ';
		endif;
		return $resultado;
	}

	public function retornaQuantidadeInscritos(){
		global $wpdb;

		$table_name = $wpdb->prefix . 'rg_newsletter';
		$resultado = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name);
		return $resultado;
	}

	public function retornaAnoInscritos(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'rg_newsletter';

		$resultado = 'SELECT ano_rg_usuario FROM '. $table_name .' GROUP BY ano_rg_usuario ORDER BY ano_rg_usuario DESC';
		return $wpdb->get_results($resultado);
	}

	public function retornaMesInscritos(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'rg_newsletter';

		$resultado = 'SELECT mes_rg_usuario FROM '. $table_name .' WHERE 1 = 1 '. $this->filtroAno() .' GROUP BY mes_rg_usuario ORDER BY mes_rg_usuario DESC';
		return $wpdb->get_results($resultado);
	}

}

endif;