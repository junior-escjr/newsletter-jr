<div class="wrap newsletter">

	<h1> <?php _e( 'Newsletters', 'newsletter-jr' ); ?>
		
		<a class="button-primary" href="<?php echo $_SERVER["REQUEST_URI"]; ?>&exportar=1"><?php _e( 'Baixar planilha', 'newsletter-jr' ); ?></a>
	</h1>

	<ul class="subsubsub">
		<li class="all">
			<a class="current" href="javascript:;"><?php _e( 'Inscritos', 'newsletter-jr' ); ?> <span class="count">(<?php echo $this->count_inscritos; ?>)</span></a>
		</li>
	</ul>
	
	<!-- tabs -->
	<div id="tabs">
		<ul>
	    	<li><a href="#subscribers"><?php _e( 'Lista de inscritos', 'newsletter-jr' ) ?></a></li>
	    	<li><a href="#shortcode"><?php _e( 'Shortcode', 'newsletter-jr' ) ?></a></li>
	  	</ul>
	  	<div id="subscribers">
	    	<?php 
			require_once('tmpl-list-subscribers.php');

			do_action( 'subscribers', $this->ano_inscritos, $this->mes_inscritos, $this->info_newsletter ); ?>
	  	</div>

	  	<!-- shortcode -->
	  	<div id="shortcode">
	  		<p><?php _e('Copie o shortcode abaixo e cole dentro de seu post, página ou no editor do widget:', 'newsletter-jr') ?></p>
	    	<div class="shortcode">[newsletter_jr]</div>
			
			<h3><?php _e('Atributos', 'newsletter-jr') ?></h3>

			<!-- table -->
	    	<table class="widefat striped">
				<thead>
					<tr>
						<th class="row-title"><?php _e( 'Tipos', 'newsletter-jr' ); ?></th>
						<th><?php _e( 'Comentários', 'newsletter-jr' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="row-title">placeholder_text</td>
						<td>
							<p><?php _e('Esse atributo serve para customizar o placeholder do primeiro campo.', 'newsletter-jr') ?> <br />
							Ex: <i>[newsletter_jr placeholder_text="Nome"]</i> </p>
						</td>
					</tr>
					<tr>
						<td class="row-title">placeholder_email</td>
						<td>
							<p><?php _e('Esse atributo serve para customizar o placeholder do segundo campo que seria o de email.', 'newsletter-jr') ?> <br />
							Ex: <i>[newsletter_jr placeholder_email="Email"]</i> </p>
						</td>
					</tr>
					<tr>
						<td class="row-title">label_button</td>
						<td>
							<p><?php _e('Esse atributo serve para customizar o texto do botão.', 'newsletter-jr') ?> <br />
							Ex: <i>[newsletter_jr label_button="Enviar"]</i> </p>
						</td>
					</tr>
					<tr>
						<td class="row-title">class</td>
						<td>
							<p><?php _e('Esse atributo serve para adicionar classes de sua preferência para uma melhor customização. É possível adicionar mais de um classe.', 'newsletter-jr') ?> <br />
							Ex: <i>[newsletter_jr class="btn"]</i><br />
							Ex2: <i>[newsletter_jr class="btn btn-color"]</i></p>
						</td>
					</tr>	
				</tbody>
				<tfoot>
					<tr>
						<th class="row-title"><?php _e( 'Tipos', 'newsletter-jr' ); ?></th>
						<th><?php _e( 'Comentários', 'newsletter-jr' ); ?></th>
					</tr>
				</tfoot>
			</table>
			<!-- /table -->

	  	</div>
	  	<!-- /shortcode -->

	</div>
	<!-- /tabs -->

</div>

