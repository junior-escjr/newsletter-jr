
<?php function list_subscribers( $ano_inscritos, $mes_inscritos, $info_newsletter ) { ?>
	
	<form id="cadastrados-filter" method="GET">

		<!-- tablenav top -->
		<div class="tablenav top">

			<!-- alignleft actions bulkactions -->
			<div class="alignleft actions bulkactions">
				<input type="hidden" name="page" value="cadastrados-newsletters">

				<select class="newsjr-select-ano" name="ano">
					<?php if(isset($_GET['ano']) && !empty($_GET['ano'])) : ?>
						<option value=""><?php _e( 'Listar todos os cadastrados', 'newsletter-jr' ); ?></option>
					<?php else : ?>
						<option value="" selected="selected" ><?php _e( 'Listar todos os cadastrados', 'newsletter-jr' ) ?></option>
					<?php endif; ?>

					<?php foreach($ano_inscritos as $ano) : 
							if(isset($_GET['ano'])) : 
								$selected = ($ano->ano_rg_usuario == $_GET['ano']) ? 'selected="selected"' : '';
							else :
								$selected = '';
							endif;?>

						<option value="<?php echo $ano->ano_rg_usuario;?>" <?php echo $selected ;?> ><?php echo $ano->ano_rg_usuario ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<!-- /alignleft actions bulkactions -->

			<!-- alignleft actions newsjr-mes -->
			<div class="alignleft actions newsjr-mes">
				<?php if(isset($_GET['mes'])) : ?>

					<select class="newsjr-select-mes" name="mes">
						<?php if(!empty($_GET['mes'])) : ?>
							<option value=""><?php _e( 'Listar todos do ano', 'newsletter-jr' ); ?></option>
						<?php else : ?>
							<option value="" selected="selected" ><?php _e( 'Listar todos do ano', 'newsletter-jr' );?></option>
						<?php endif; ?>

						<?php foreach($mes_inscritos as $mes) :
								if($_GET['mes'] == $mes->mes_rg_usuario) :
									$selected = ($mes->mes_rg_usuario == $_GET['mes']) ? 'selected="selected"' : '';
								else :
									$selected = '';
								endif;?>

								<option value="<?php echo $mes->mes_rg_usuario;?>" <?php echo $selected; ?> ><?php echo $mes->mes_rg_usuario; ?></option>
						<?php endforeach; ?>
					</select>

				<?php endif; ?>
			</div>
			<!-- /alignleft actions newsjr-mes -->
		
			<input class="button-secondary" type="submit" value="<?php _e( 'Filtrar', 'newsletter-jr' );?>" />

		</div>
		<!-- /tablenav top -->

	</form>
	<!-- /form -->

	<table class="widefat striped">
		<thead>
			<tr>
				<th class="row-title">ID</th>
				<th><?php _e( 'Nome', 'newsletter-jr' ); ?></th>
				<th><?php _e( 'Email', 'newsletter-jr' ); ?></th>
				<th><?php _e( 'Data', 'newsletter-jr' ); ?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($info_newsletter as $news) : 
					$data = explode('-',$news->data_rg_usuario);?>
		
					<tr>
						<td><?php echo $news->id_rg_usuario; ?></td>
						<td class="row-title"><?php echo $news->nome_rg_usuario; ?></td>
						<td><?php echo $news->email_rg_usuario; ?></td>
						<td><?php echo $data[2].'/'.$data[1].'/'.$data[0] ?></td>
					</tr>
				<?php endforeach; ?>

		</tbody>
		<tfoot>
			<tr>
				<th class="row-title">ID</th>
				<th><?php _e( 'Nome', 'newsletter-jr' ); ?></th>
				<th><?php _e( 'Email', 'newsletter-jr' ); ?></th>
				<th><?php _e( 'Data', 'newsletter-jr' ); ?></th>
			</tr>
		</tfoot>
	</table>

<?php 

} 

add_action( 'subscribers', 'list_subscribers', 10, 3 )?>