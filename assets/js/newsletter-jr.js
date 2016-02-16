(function($){

	var funcoes = {
		init: function(){
			this.ajaxListaMes();
		},

		ajaxListaMes: function(){
			$('.newsjr-select-ano').on('change', function(){
				var ano = $(this).val();

				if(ano != '') {
					$('.newsjr-mes').html('<div class="spinner is-active"></div>');

					console.log(ano);

					$.ajax({
						type: 'GET',
						url: ajax.ajax_url,
						data: 'action=retornaMes&ano='+ano,
						success: function( response ){
							$('.newsjr-mes').html( response );
						}
					});

				} else {
					
					$('.newsjr-select-mes').remove();
				}
				
			})
			
		}
	}

	funcoes.init();

})(jQuery);