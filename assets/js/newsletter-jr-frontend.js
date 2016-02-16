(function($){

	var funcoes = {
		init: function(){
			//this.ajaxValidateForm();
			this.validateField();
		},

		ajaxValidateForm: function(){

			var campos = $('#newsjr-form').serialize();

			console.log(campos);

			$('#newsjr-form').after('<div class="spinner"></div>');

			$.ajax({
				type: 'POST',
				url: ajax.ajax_url,
				data: 'action=validateForm&' + campos,
				success: function( response ){
					$('.spinner').remove();

					$('#newsjr-form').after( response );

					console.log(response);
				}
			});

			return false;
		},

		validateField: function(){
			$("#newsjr-form").validate({
				rules: {
					newsjr_nome: "required",
					newsjr_email: {
						required: true,
						email: true
					}
				},
				messages: {
					newsjr_nome: {
						required: ajax.txt_required
					},
					newsjr_email: {
						required: ajax.txt_required,
						email: ajax.txt_email_invalido
					}
				},

				submitHandler: function(){
					$('#newsjr-form').on('submit', funcoes.ajaxValidateForm());
				}
			});
		}
	}

	funcoes.init();

})(jQuery);