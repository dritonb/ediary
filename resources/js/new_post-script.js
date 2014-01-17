var new_post = {

	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
	},

	init: function() {
		this.events();
	},

	events: function() {
		$('#submit_post').on('click', this.submitNewPost);
	},

	submitNewPost: function() {
		var data = new_post.buildData(),
			valid = new_post.validate(data);


		console.log(data);

		if(valid) {
			$.when($.ajax({
				url: new_post.globals.baseUrl + 'new_post/addPost',
				data: data,
				type: 'post',
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					$('p.error_msgs').addClass('hidden');
					$('p#new_post_msg').removeClass('hidden')
						.html('New post was successfully added.');
				} else {
					$('p.error_msgs').addClass('hidden');
					$('p#new_post_msg').removeClass('hidden')
						.html(result);
				}
			})
			.fail(function() {
				$('p.error_msgs').addClass('hidden');
				$('p#new_post_msg').removeClass('hidden')
					.html('Problem occurred. Please try again.');
			});
		} else {
			$('p.error_msgs').addClass('hidden');
			$('p#validation_error').removeClass('hidden');
		}
	},

	buildData: function() {
		var data = {};

		data.posttitle = $('#posttitle').val();
		data.tinyeditor = tinymce.activeEditor.getContent();
		// data.tinyeditor = tinymce.get('tinyeditor').getContent();

		return data;
	},

	validate: function(data) {
		if(data.posttitle !== '' && data.tinyeditor !== '') {
			return true;
		} else {
			return false;
		}
	},

	resetNewPostForm: function() {
		$('#posttitle').val('');
		$('#tinyeditor').val('');
	},
};

$(function() {
	tinymce.init({selector:'textarea#tinyeditor'});
	new_post.init();
});