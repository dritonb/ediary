var login = {

	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
		action: '',
		url: '',
		form: '',
	},

	init: function() {
		this.events();
	},

	events: function() {
		$('#submit').on('click', this.submitSetup);
		$('#submitregistration').on('click', this.submitSetup);
		$('#submitreset').on('click', this.submitSetup);

		$('#loginformwrap').on('click', 'a.registerlink', function() {
			$('#loginformwrap').hide().removeClass('visible');
			$('#registerformwrap').show().addClass('visible');
			$('p.error_msgs').addClass('hidden');

			$('form#registerForm').each(function() {
				this.reset();
			});
		});

		$('#loginformwrap').on('click', 'a.resetlink', function() {
			$('#loginformwrap').hide().removeClass('visible');
			$('#resetformwrap').show().addClass('visible');
			$('p.error_msgs').addClass('hidden');

			$('form#resetForm').each(function() {
				this.reset();
			});
		});

		$('.backtologin').on('click', function() {
			$('#container').find('.visible').hide().removeClass('visible');
			$('#loginformwrap').show().addClass('visible');
			$('p.error_msgs').addClass('hidden');

			$('form#loginForm').each(function() {
				this.reset();
			});
		});
	},

	submitSetup: function(e) {
		var form = $(this);

		login.globals.form = form.parent();

		if (login.globals.form.is('#loginForm')) {
			login.globals.action = 'login';
			login.globals.url = 'login/verifyUser';
		}
		else if(login.globals.form.is('#resetForm')) {
			login.globals.action = 'reset';
			login.globals.url = 'resetpass/sendemail';
		}
		else if(login.globals.form.is('#registerForm')) {
			login.globals.action = 'register';
			login.globals.url = 'register/newaccount';
		}

		login.submitCall();
	},

	submitCall: function() {
		var self = this,
			data = self.buildData(),
			valid = self.validate(data);

		if(valid) {
			$.when($.ajax({
				url: login.globals.baseUrl + login.globals.url,
				type: 'post',
				data: data,
				dataType: 'json'  
			}))
			.then(function(result) {

				if (result === 1) {
					// verify ok
					console.log('then - ok');
					window.location.replace(login.globals.baseUrl + 'home');
				} else {
					self.showValidationErrors(result);
					console.log('then - not ok');
				}

			})
			.fail(function() {
				// ajax failed
				self.showAjaxFailError();
				console.log('not ok');
			});
		}
		else {
			// display an error - empty fieds
			self.showEmptyFieldsError();
		}
	},

	showEmptyFieldsError: function() {
		$('p.error_msgs').addClass('hidden');


		switch(login.globals.action) {
			case 'login':
				$('#loginForm').after($('#errors'));
				$('#empty_fields').removeClass('hidden');
				break;
			case 'reset':
				$('#resetForm').after($('#errors'));
				$('#empty_fields').removeClass('hidden');
				break;
			case 'register':
				$('#registerForm').after($('#errors'));
				$('#empty_fields').removeClass('hidden');
				break;
		}
	},

	showAjaxFailError: function() {
		$('p.error_msgs').addClass('hidden');


		switch(login.globals.action) {
			case 'login':
				$('#loginForm').after($('#errors'));
				$('#ajax_fail').removeClass('hidden');
				break;
			case 'reset':
				$('#resetForm').after($('#errors'));
				$('#ajax_fail').removeClass('hidden');
				break;
			case 'register':
				$('#registerForm').after($('#errors'));
				$('#ajax_fail').removeClass('hidden');
				break;
		}
	},

	showValidationErrors: function(data) {
		$('p.error_msgs').addClass('hidden');


		switch(login.globals.action) {
			case 'login':
				$('#loginForm').after($('#errors'));
				$('#validation_error').html(data);
				$('#validation_error').removeClass('hidden');
				break;
			case 'reset':
				$('#resetForm').after($('#errors'));
				$('#validation_error').html(data);
				$('#validation_error').removeClass('hidden');
				break;
			case 'register':
				$('#registerForm').after($('#errors'));
				$('#validation_error').html(data);
				$('#validation_error').removeClass('hidden');
				break;
		}
	},

	buildData: function() {
		var data = {};

		switch(login.globals.action) {
			case 'login':
				data.username = $.trim($('#username').val());
				data.password = $.trim($('#password').val());
				break;
			case 'reset':
				data.username = $.trim($('#username_res').val());
				data.email_address = $.trim($('#email_res').val());
				break;
			case 'register':
			   	data.firstname = $.trim($('#firstname').val());
			   	data.lastname = $.trim($('#lastname').val());
			   	data.username = $.trim($('#username_reg').val());
			   	data.email_address = $.trim($('#email_reg').val());
			   	data.password = $.trim($('#password_reg').val());
			   	data.conf_password = $.trim($('#conf_password_reg').val());
			   	break;
		}

		return data;
	},

	validate: function(data) {
		if(login.globals.action === 'login') {
			return this.validateLogin(data);
		}
		else if(login.globals.action === 'reset') {
			return this.validateReset(data);
		}
		else if(login.globals.action === 'register') {
			return this.validateRegistration(data);
		}
	},

	validateLogin: function(data) {
		if (login.globals.action === 'login' && data.username !== '' && data.password !== '') {
			return true;
		}
		else {
			return false;
		}
	},

	validateReset: function(data) {
		if (login.globals.action === 'reset' && data.username !== '' && data.email_address !== '') {
			return true;
		}
		else {
			return false;
		}
	},

	validateRegistration: function(data) {
		if(login.globals.action === 'register' && 
			data.firstname !== '' && 
			data.lastname !== '' &&
			data.username !== '' &&
			data.email_address !== '' &&
			data.password !== '') {

			return true;
		}
		else {
			return false;
		}	
	},

};

$(function() {
	login.init();
});