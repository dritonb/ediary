var settings = {
	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
	},

	init: function() {
		this.events();
	},

	events: function() {
		$('#submit_name').on('click', this.changeNameCall);
		
		$('#submit_password').on('click', this.changePasswordCall);

		$('#submit_avatar').on('click', this.changeAvatarCall);
	},

	/* Change name */

	changeNameCall: function() {
		var data = settings.changeNameData(),
			valid = settings.changeNameValidate(data);

		settings.resetChangePasswordForm();
		settings.resetChangeNameForm();
		settings.resetChangeAvatarForm();

		if(valid) {
			$.when($.ajax({
				url: settings.globals.baseUrl + 'settings/changeName',
				type: 'post',
				data: data,
				dataType: 'json'
			}))
			.then(function(result) {
				if(result === 1) {
					$('p.error_msgs').addClass('hidden');
					$('p#change_name_msg').removeClass('hidden')
						.html('Your name was successfully changed.');

				} else {
					$('p.error_msgs').addClass('hidden');
					$('p#change_name_msg').removeClass('hidden')
						.html(result);
				}
			})
			.fail(function() {
				$('p.error_msgs').addClass('hidden');
				$('p#change_name_msg').removeClass('hidden')
					.html('Problem occurred. Please try again.');
			});
		} else {
			$('p.error_msgs').addClass('hidden');
			$('p#validation_name_error').removeClass('hidden');
		}

	},

	changeNameData: function() {
		var data = {};

		data.firstname = $('#firstname').val();
		data.lastname = $('#lastname').val();

		return data;
	},

	changeNameValidate: function(data) {
		if(data.firstname !== '' && data.lastname !== '') {
			return true;
		} else {
			return false;
		}
	},

	resetChangeNameForm: function() {
		$('#changeNameForm :text').each(function() {
			$(this).val('');
		});
	},

	/* Change password */

	changePasswordCall: function() {
		var data = settings.changePasswordData(),
			valid = settings.changePasswordValidate(data);

		settings.resetChangePasswordForm();
		settings.resetChangeNameForm();
		settings.resetChangeAvatarForm();

		if(valid) {
			$.when($.ajax({
				url: settings.globals.baseUrl + 'settings/changePassword',
				type: 'post',
				data: data,
				dataType: 'json'
			}))
			.then(function(result) {	
				if(result === 1) {
					$('p.error_msgs').addClass('hidden');
					$('p#change_password_msg').removeClass('hidden')
						.html('Your password was successfully changed.');

						
				} else {
					$('p.error_msgs').addClass('hidden');
					$('p#change_password_msg').removeClass('hidden')
						.html(result);

						
				}
			})
			.fail(function() {
				$('p.error_msgs').addClass('hidden');
				$('p#change_password_msg').removeClass('hidden')
					.html('Problem occurred. Please try again.');

					
			});
		} else {
			$('p.error_msgs').addClass('hidden');
			$('p#validation_password_error').removeClass('hidden');
		}

	},

	changePasswordData: function() {
		var data = {};

		data.current_password = $('#current_password').val();
		data.new_password = $('#new_password').val();
		data.new_password_repeat = $('#new_password_repeat').val();

		return data;
	},

	changePasswordValidate: function(data) {
		if(data.current_password !== '' && data.new_password !== '' && data.new_password_repeat !== '') {
			return true;
		} else {
			return false;
		}
	},

	resetChangePasswordForm: function() {
		$('#changePasswordForm :password').each(function() {
			$(this).val('');
		});
	},

	/* Change avatar */

	changeAvatarCall: function() {
		var image;

		image = new FormData();
		image.append('avatar', $('#avatar')[0].files[0]);

		settings.resetChangePasswordForm();
		settings.resetChangeNameForm();
		settings.resetChangeAvatarForm();

		
		$.when($.ajax({
			url: settings.globals.baseUrl + 'settings/uploadAvatar',
			type: 'post',
			data: image,
			dataType: 'json',
			processData: false,
			contentType: false,
		}))
		.then(function(result) {	
			if(result === 1) {
				$('p.error_msgs').addClass('hidden');
				$('p#change_avatar_msg').removeClass('hidden')
					.html('Your avatar was successfully changed.');	
			} else {
				$('p.error_msgs').addClass('hidden');
				$('p#change_avatar_msg').removeClass('hidden')
					.html(result);	
			}
		})
		.fail(function() {
			$('p.error_msgs').addClass('hidden');
			$('p#change_avatar_msg').removeClass('hidden')
				.html('Problem occurred. Please try again.');
		});
	},

	resetChangeAvatarForm: function() {
		$('#avatarForm :file').each(function() {
			$(this).val('');
		});
	},
};

$(function() {
	settings.init();
});