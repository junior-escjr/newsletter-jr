<?php

if(!defined('ABSPATH')) { die('Sai daqui porra!');}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json');

function retornaMes(){
	global $wpdb;

	$ano = $_GET['ano'];

	$table_name = $wpdb->prefix . 'rg_newsletter';

	$resultado = 'SELECT mes_rg_usuario FROM '. $table_name .' WHERE ano_rg_usuario ='. $ano .' GROUP BY mes_rg_usuario ORDER BY mes_rg_usuario DESC';

	$mes = $wpdb->get_results($resultado);

	echo '<select class="newsjr-select-mes" name="mes">';
			if(isset($_GET['mes']) && !empty($_GET['mes'])) :
				echo '<option value="">'. __( 'Listar todos do ano', 'newsletter-jr' ) .'</option>';
			else :
				echo '<option value="" selected="selected" >'. __( 'Listar todos do ano', 'newsletter-jr' ) .'</option>';
			endif;

			foreach($mes as $m) :
				if(isset($_GET['mes'])) :
					$selected = ($ano->ano_rg_usuario == $_GET['ano']) ? 'selected="selected"' : '';
				else :
					$selected = '';
				endif;

				echo '<option '. $selected .' value='. $m->mes_rg_usuario .'>'. $m->mes_rg_usuario .'</option>';
				
			endforeach;
	echo '</select>';

	die();
}

add_action('wp_ajax_retornaMes', 'retornaMes');
add_action('wp_ajax_nopriv_retornaMes', 'retornaMes');



function validateForm(){
	global $wpdb;

	$nome = $_POST['newsjr_nome'];
	$email = $_POST['newsjr_email'];

	$table_name = $wpdb->prefix . 'rg_newsletter';

	$resultado = $wpdb->insert( 
    	$table_name, 
    		array( 
    			'nome_rg_usuario' => $nome, 
    			'email_rg_usuario' => $email,
    			'mes_rg_usuario' => date('m'),
    			'ano_rg_usuario' => date('Y'),
    			'data_rg_usuario' => date('Y-m-d')
    		) 
    );

    if(0 < $resultado) :
      echo '<div class="alerta success"><b>Perfeito!</b> Foi registrado com sucesso!</div>';
    else :
      echo '<div class="alerta danger"><b>Atenção!</b> Erro ao registrar, tente mais tarde</div>';
    endif;

	die();
}

add_action('wp_ajax_validateForm', 'validateForm');
add_action('wp_ajax_nopriv_validateForm', 'validateForm');