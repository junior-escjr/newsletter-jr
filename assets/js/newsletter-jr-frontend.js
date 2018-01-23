(function($){

	var funcoes = {
		init: function(){
			//this.ajaxValidateForm();
			this.actionValidate();
		},

		ajaxValidateForm: function(classForm){

			var campos = $('.' + classForm).serialize();

			console.log(campos);

			$('.' + classForm).after('<div class="spinner"></div>');

			$.ajax({
				type: 'POST',
				url: ajax.ajax_url,
				data: 'action=validateForm&' + campos,
				success: function( response ){
					$('.spinner').remove();

					$('.' + classForm).after( response );

					console.log(response);
				}
			});

			return false;
		},

		validateField: function(classForm){
			$('.' + classForm).validate({
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
					$(this).on('submit', funcoes.ajaxValidateForm(classForm));
				}
			});
		},

		actionValidate: function(){
			$('.btn').on('click', function(){
				var valClass = $(this).parent().attr('class');
				console.log(valClass);

				funcoes.validateField(valClass);
			});
		}
	}

	funcoes.init();

})(jQuery);