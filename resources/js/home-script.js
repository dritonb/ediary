var home = {
	
	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
	},

	init: function() {
		this.events();
	},

	events: function() {
		$('#reset_button').on('click', this.resetForm);
		$('#submit_button').on('click', this.submitForm);
	},

	resetForm: function() {
		$('#post_title').val('');
		$('#post_content').val('');
		$('p.error_msgs').addClass('hidden');
	},

	submitForm: function() {
		var data = home.buildData(),
			valid = home.validate(data);

		if(valid) {
			$.when($.ajax({
				url: home.globals.baseUrl + 'home/addQuickPost',
				type: 'post',
				data: data,
				dataType: 'json'
			}))
			.then(function(result) {
				if(result !== 0 && result !== -1) {
					home.listAlbums(result);

					home.resetForm();

					console.log('then ok');
				} else {
					if(result === 0) {
						$('p.error_msgs').addClass('hidden');
						$('p#validation_error').html('A problem occurred. Please try again.').removeClass('hidden');
						console.log('then not ok');
					} else if(result === -1) {
						$('p.error_msgs').addClass('hidden');
						$('p#validation_error').html('All fields are required.').removeClass('hidden');
						console.log('then not ok');
					}
				}
			})
			.fail(function() {
				$('p.error_msgs').addClass('hidden');
				$('p#ajax_fail').removeClass('hidden');
				console.log('fail');
			});
		} else {
			// validation error
			$('p.error_msgs').addClass('hidden');
			$('p#empty_fields').removeClass('hidden');
		}
	},

	buildData: function() {
		var data = {};

		data.post_title = $.trim($('#post_title').val());
		data.post_content = $.trim($('#post_content').val());

		return data;
	},

	validate: function(data) {
		if(data.post_title !== '' && data.post_content !== '') {
			return true;
		} else {
			return false;
		}
	},


	listAlbums: function(data) {
		var source = $('#latestPostsTemplate').html(),
			template = Handlebars.compile(source),
			html = template(data);

		$('#latestposts').html(html);
	},
};

$(function() {
	home.init();
});