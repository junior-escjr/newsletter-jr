<?php

if(!defined('ABSPATH')) { die( __('Sai daqui porra!', 'newsletter-jr') );}

if ( ! class_exists( 'NEWSJR_Init' ) ) :


class NEWSJR_Init {
	
	private $cadastrados, $info_newsletter, $count_inscritos, $ano_inscritos, $mes_inscritos;

	public function __construct(){
		$this->cadastrados = new NEWSJR_Query;
		$this->info_newsletter = $this->cadastrados->retornaCadastradosNewsletter();
		$this->count_inscritos = $this->cadastrados->retornaQuantidadeInscritos();
		$this->ano_inscritos   = $this->cadastrados->retornaAnoInscritos();
		$this->mes_inscritos   = $this->cadastrados->retornaMesInscritos();

		add_action('plugins_loaded', array($this, 'load_textdomain'));
		add_action( 'admin_menu', array($this, 'init_show_menu_admin') );
		add_shortcode('newsletter_jr', array($this, 'newsjr_shortcode'));

		$this->exportar_excel();
	}

	//Carrega arquivos de tradução
	public function load_textdomain(){
		load_plugin_textdomain('newsletter-jr', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');
	}

	//Função para uso do shortcode
	public function newsjr_shortcode( $attrs ){

		extract(
			shortcode_atts(
				array(
				'placeholder_text' => '',
				'placeholder_email' => '',
				'class' => '',
				'label_button' => '',
				'class_button' => ''
				), $attrs));

		$form = '<form id="newsjr-form" novalidate>
					<div class="newsjr-form-group">
						<input type="text" name="newsjr_nome" class="newsjr-form-control '. $class .'" placeholder="'. $placeholder_text .'" />
					</div>
					<div class="newsjr-form-group">
						<input type="email" name="newsjr_email" class="newsjr-form-control '. $class .'" placeholder="'. $placeholder_email .'" />
					</div>
					<input type="submit" class="btn '. $class_button .'" value="'. $label_button .'">
				</form>';

		return $form;
		//return '<a class="news-jr-button" target="'. $target .'" href="'. $link .'">teste</a>';
	}

	public function init_show_menu_admin(){
		add_menu_page( 'Registros de newsletters', 'Newsletters', 'manage_options', 'cadastrados-newsletters', array($this, 'lista_cadastros_newsletter'), 'dashicons-email-alt');
	}

	public function exportar_excel(){
		if(isset($_GET['exportar'])) :
			
			$html = '
				<div class="wrap">
					<table class="widefat">
						<thead>
							<tr>
								<th class="row-title">ID</th>
								<th>'. __( 'Nome', 'newsletter-jr' ) .'</th>
								<th>'. __( 'Email', 'newsletter-jr' ) .'</th>
								<th>'. __( 'Data', 'newsletter-jr' ) .'</th>
							</tr>
						</thead>
						<tbody>';
							foreach($this->info_newsletter as $news) :
								if($_GET['exportar'] == 1 || $_GET['ano'] == $news->ano_rg_usuario) :
									$data = explode('-',$news->data_rg_usuario);

									$html .= '<tr>
									<td>'. $news->id_rg_usuario .'</td>
									<td class="row-title">'. $news->nome_rg_usuario .'</td>
									<td>'. $news->email_rg_usuario .'</td>
									<td>'. $data[2].'/'.$data[1].'/'.$data[0] .'</td>
								</tr>';
								endif;
							endforeach;
						'</tbody>
						<tfoot>
							<tr>
								<th class="row-title">ID</th>
								<th>'. __( 'Nome', 'newsletter-jr' ) .'</th>
								<th>'. __( 'Email', 'newsletter-jr' ) .'</th>
								<th>'. __( 'Data', 'newsletter-jr' ) .'</th>
							</tr>
						</tfoot>
					</table>
				</div>';


			echo $html;

			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header('Content-Type: text/html; charset=UTF-8');
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=compras.xls");
			header("Content-Transfer-Encoding: binary ");
			die();
		endif;
	}

	public function lista_cadastros_newsletter(){
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'Você não tem permissão suficiente para acessar esta página.' ) );
		}

		
		
		$html = '<div class="wrap newsletter">';
		$html .=	'<h1>'. __( 'Newsletters', 'newsletter-jr' );
						if(isset($_GET['ano'])) :
		$html .=		'<a class="button-primary" href="'. $_SERVER["REQUEST_URI"] .'&exportar=1">'. __( 'Baixar planilha', 'newsletter-jr' ) .'</a>';
						else :
		$html .=		'<a class="button-primary" href="admin.php?page=cadastrados-newsletters&exportar=1">'. __( 'Baixar planilha', 'newsletter-jr' ) .'</a>';
						endif;
		$html .=	'</h1>';
		$html .=	'<ul class="subsubsub">';
		$html .=		'<li class="all">';	
		$html .= 			'<a class="current" href="javascript:;">Inscritos <span class="count">('. $this->count_inscritos .')</span></a>';
		$html .=		'</li>';				
		$html .=	'</ul>';			
		$html .=	'<form id="cadastrados-filter" method="GET">';		
		$html .=		'<div class="tablenav top">';		
		$html .=			'<div class="alignleft actions bulkactions">';
		$html .=				'<input type="hidden" name="page" value="cadastrados-newsletters">';
		$html .=				'<select class="newsjr-select-ano" name="ano">';
									if(isset($_GET['ano']) && !empty($_GET['ano'])) :
		$html .=						'<option value="">'. __( 'Listar todos os cadastrados', 'newsletter-jr' ) .'</option>';
									else :
		$html .=						'<option value="" selected="selected" >'. __( 'Listar todos os cadastrados', 'newsletter-jr' ) .'</option>';
									endif;
		
									foreach($this->ano_inscritos as $ano) :
										if(isset($_GET['ano'])) :
											$selected = ($ano->ano_rg_usuario == $_GET['ano']) ? 'selected="selected"' : '';
										else :
											$selected = '';
										endif;

		$html .= 						'<option value='.$ano->ano_rg_usuario.' '.$selected.'>'. $ano->ano_rg_usuario .'</option>';
									endforeach;

		$html .=				'</select>';
		$html .=			'</div>';
		$html .=			'<div class="alignleft actions newsjr-mes">';
								if(isset($_GET['mes'])) :
		$html .=					'<select class="newsjr-select-mes" name="mes">';
										if(!empty($_GET['mes'])) :
		$html .=						 	'<option value="">'. __( 'Listar todos do ano', 'newsletter-jr' ) .'</option>';
										else :
		$html .=						 	'<option value="" selected="selected" >'. __( 'Listar todos do ano', 'newsletter-jr' ) .'</option>';
										endif;

										foreach($this->mes_inscritos as $mes) :
											if($_GET['mes'] == $mes->mes_rg_usuario) :
												$selected = ($mes->mes_rg_usuario == $_GET['mes']) ? 'selected="selected"' : '';
											else :
												$selected = '';
											endif;

		$html .= 							'<option value='. $mes->mes_rg_usuario .' '. $selected .'>'. $mes->mes_rg_usuario .'</option>';
										endforeach;
		$html .=					'</select>';
								endif;
		$html .=			'</div>';
		$html .=			'<input class="button-secondary" type="submit" value="'. __( 'Filtrar', 'newsletter-jr' ) .'" />';
		$html .=		'</div>';
		$html .=	'</form>';
		
		$html .= 	'<table class="widefat striped">';
		$html .=		'<thead>';
		$html .=			'<tr>';
		$html .=				'<th class="row-title">ID</th>';
		$html .=				'<th>'. __( 'Nome', 'newsletter-jr' ) .'</th>';
		$html .=				'<th>'. __( 'Email', 'newsletter-jr' ) .'</th>';
		$html .=				'<th>'. __( 'Data', 'newsletter-jr' ) .'</th>';
		$html .=			'</tr>';
		$html .=		'</thead>';
		$html .=		'<tbody>';

							foreach($this->info_newsletter as $news) :
								$data = explode('-',$news->data_rg_usuario);
		
		$html .=				'<tr>';
		$html .=					'<td>'. $news->id_rg_usuario .'</td>';
		$html .=					'<td class="row-title">'. $news->nome_rg_usuario .'</td>';
		$html .=					'<td>'. $news->email_rg_usuario .'</td>';
		$html .=					'<td>'. $data[2].'/'.$data[1].'/'.$data[0] .'</td>';
		$html .=				'</tr>';
							endforeach;

		$html .=		'</tbody>';
		$html .=		'<tfoot>';
		$html .=			'<tr>';
		$html .=				'<th class="row-title">ID</th>';
		$html .=				'<th>'. __( 'Nome', 'newsletter-jr' ) .'</th>';
		$html .=				'<th>'. __( 'Email', 'newsletter-jr' ) .'</th>';
		$html .=				'<th>'. __( 'Data', 'newsletter-jr' ) .'</th>';
		$html .=			'</tr>';
		$html .=		'</tfoot>';
		$html .=	'</table>';
		$html .='</div>';


		echo $html;

	}
}

new NEWSJR_Init;

endif;