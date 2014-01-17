var resetpass = {

	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
	},

	init: function() {
		this.events();
	},

	events: function() {
		$('#submitreset').on('click', this.passwordSubmit);
	},

	passwordSubmit: function() {
		var data = resetpass.buildData();
		var validate = resetpass.validation(data);

		if(validate === 1) {
			$.when($.ajax({
				url: resetpass.globals.baseUrl + 'resetpass/resetPassword',
				type: 'post',
				data: data,
				dataType: 'json',
			}))
			.then(function(result) {
				if (result === 1) {
					window.location.replace(resetpass.globals.baseUrl + 'login');
				}
				else {
					$('p.error_msgs').addClass('hidden');
					$('p#validation_error').html(result);
					$('p#validation_error').removeClass('hidden');

					console.log('then - not ok');
				}

			})
			.fail(function() {
				$('p.error_msgs').addClass('hidden');
				$('p#ajax_fail').removeClass('hidden');
				console.log('not ok');
			});
		}
		else {
			// console.log('validation error');

			$('p.error_msgs').addClass('hidden');

			if(validate === 0) {
				$('p#empty_fields').removeClass('hidden');
			} else if(validate === -1) {
				$('p#fields_mismatch').removeClass('hidden');
			}
		}
	},

	buildData: function() {
		var data = {};

		data.new_password = $.trim($('#password_res').val());
		data.confirm_password = $.trim($('#password_res_conf').val());
		data.token = window.location.pathname.split('/')[5];

		return data;
	},

	validation: function(data) {
		if(data.new_password && data.confirm_password) {
			if(data.new_password === data.confirm_password) {
				return 1;
			} else {
				return -1;
			}
		} else {
			return 0;
		}		

	},
};

$(function() {
	resetpass.init();
});