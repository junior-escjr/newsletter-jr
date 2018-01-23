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

		$form = '<form class="newsjr-form'. rand(500, 50000) .'" novalidate>
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

			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header('Content-Type: text/html; charset=utf-8');
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=inscritos.xls");
			header("Content-Transfer-Encoding: binary ");
			
			echo $html;

			die();
		endif;
	}

	private function tmpl_newsletter(){
		require_once( 'tmpl-newsletterjr.php' );
		require_once( 'tmpl-list-subscribers.php');
	}

	public function lista_cadastros_newsletter(){
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'Você não tem permissão suficiente para acessar esta página.' ) );
		}

		$this->tmpl_newsletter();
		
	}
}

new NEWSJR_Init;

endif;