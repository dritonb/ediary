var gallery = {

	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
		album_id: '',
		number_of_posts_per_page: 6,
	},

	init: function() {
		this.events();
		this.getAlbumList(1, 6);
		this.getAlbumsCount();
	},

	events: function() {
		$('#create_new_album').on('click', function() {
			$('#block_page_albums').fadeIn();
			$('#modal_box_albums').fadeIn();
		});

		$('#modal_close_albums').on('click', function() {
			$('#block_page_albums').fadeOut();
			$('#modal_box_albums').fadeOut();
			$('#album_name').val('');
			$('p.error_msgs').addClass('hidden');
		});

		$('#submit_album_name').on('click', this.createAlbum);

		$('#next').on('click', function() {
			var to = parseInt($('#to').text()),
				all = parseInt($('#all').text());

			if(all - to > 0) {
				gallery.getAlbumList(to + 1, 6);
			}
		});

		$('#prev').on('click', function() {
			var from = parseInt($('#from').text());

			if(from - 6 > 0) {
				gallery.getAlbumList(from - 6, 6);
			}
		});

		$('#albums_list').on('click', 'span.album', function() {
			gallery.globals.album_id = $(this).parent().data('id');
			gallery.getAlbumImages();
		});

		$('#add_images').on('click', function() {
			$('#block_page_images').fadeIn();
			$('#modal_box_images').fadeIn();
		});

		$('#modal_close_images').on('click', function() {
			$('#block_page_images').fadeOut();
			$('#modal_box_images').fadeOut();
			$('#images').val('');
			$('p.error_msgs').addClass('hidden');
		});

		$('#images').on('change', this.getImages);

		$('#back_to_albums').on('click', this.backToAlbums);

		$('#albums_list').on('click', 'p.delete_button', this.deleteButton);
	},

	getAlbumList: function(from, to) {
		var self = this;
		
		$.when($.ajax({
			url: gallery.globals.baseUrl + 'gallery/getAlbumList',
			data: {
				from: from - 1,
				to: to,
			},
			type: 'post',
			dataType: 'json'
		}))
		.then(function(result) {
			if(result) {
				self.listAlbums(result.albums);

				if(result.albums.length === 0) {
					$('#from').text('0');
				} else {
					$('#from').text(from);
				}
				
				$('#to').text(from + result.albums_num - 1);
			} else {
				console.log('then-not ok');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	listAlbums: function(data) {
		var source = $('#albumsListTemplate').html(),
			template = Handlebars.compile(source),
			html = template(data);

		$('#albums_list').html(html);
	},

	getAlbumsCount: function() {
		var self = this;

		$.when($.ajax({
			url: gallery.globals.baseUrl + 'gallery/getAlbumsCount',
			type: 'post',
			dataType: 'json'
		}))
		.then(function(result) {
			if(result) {
				$('#all').text(result);
			} else {
				$('#all').text('0');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	createAlbum: function() {
		var album_name = $.trim($('#album_name').val());

		$.when($.ajax({
			url: gallery.globals.baseUrl + 'gallery/addnewalbum',
			type: 'post',
			data: {
				album_name: album_name, 
			},
			dataType: 'json'
		}))
		.then(function(result) {
			if(result === 1) {
				gallery.getAlbumList(1, 6);
				gallery.getAlbumsCount();
				$('#modal_close_albums').click();
				console.log('then-ok');
			} else {
				$('p.error_msgs').addClass('hidden');
				$('#create_album_modal').after($('#errors'));
				$('#validation_error').html(result).removeClass('hidden');
				console.log('then-not ok');
			}
		})
		.fail(function() {
			$('p.error_msgs').addClass('hidden');
			$('#create_album_modal').after($('#errors'));
			$('#ajax_fail').removeClass('hidden');
			console.log('fail');
		});
	},

	getAlbumImages: function() {

		$.when($.ajax({
			url: gallery.globals.baseUrl + 'gallery/getAlbumImages',
			type: 'post',
			data: {
				album_id: gallery.globals.album_id,
			},
			dataType: 'json',
		}))
		.then(function(result) {
			if(result) {
				gallery.listImages(result);
				gallery.showAlbumImages();
				gallery.initializeGalleria();
			} else {
				gallery.showAlbumImages();
				console.log('then - not ok');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	listImages: function(data) {
		var source = $('#imageListTemplate').html(),
			template = Handlebars.compile(source),
			html = template(data);

		$('#gallery').html(html);
	},

	showAlbumImages: function() {
		$('#gallery_albums').addClass('hidden');
		$('#create_new_album').addClass('hidden');

		$('#gallery').removeClass('hidden');
		$('#back_to_albums').removeClass('hidden');
		$('#add_images').removeClass('hidden');
	},

	initializeGalleria: function() {
		Galleria.loadTheme('../resources/css/galleria_classic/galleria.classic.min.js');
    	Galleria.run('#gallery');
	},

	backToAlbums: function() {
		if($('#gallery').html()) {
			galleria = Galleria.get(0);
			galleria.destroy();
			$('#gallery').html('');
		}

		$('#gallery').addClass('hidden');
		$('#back_to_albums').addClass('hidden');
		$('#add_images').addClass('hidden');

		$('#gallery_albums').removeClass('hidden');
		$('#create_new_album').removeClass('hidden');
	},

	getImages: function() {
		var formdata = new FormData(),
			len = this.files.length, 
			reader = new FileReader(), 
			file,
			i;

		for (i=0 ; i < len; i++ ) {
			file = this.files[i];
	
			if (!!file.type.match(/image.*/)) {
				if ( window.FileReader ) {
					reader = new FileReader();
					reader.readAsDataURL(file);
				}
				if (formdata) {
					formdata.append("images[]", file);
				}
			}

			formdata.append('album_id', gallery.globals.album_id);	
		}

		gallery.submitImages(formdata);
	},

	submitImages: function(images) {
		var galleria = '';

		$.when($.ajax({
			url: gallery.globals.baseUrl + 'gallery/addImages',
			type: 'post',
			data: images,
			dataType: 'json',
			processData: false,
			contentType: false,
		}))
		.then(function(result) {
			if(result) {
				if($('#gallery').html()) {
					galleria = Galleria.get(0);
					galleria.destroy();
					$('#gallery').html('');
				}
				
				gallery.listImages(result);
				gallery.initializeGalleria();
				$('#modal_close_images').click();
				console.log('then - ok');
			} else {
				console.log('then - not ok');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	deleteButton: function() {
		var album_id = $(this).parent().data('id');
			conf = confirm('Are you sure you want to delete this album ?');

		if(conf === true) {
			$.when($.ajax({
				url: gallery.globals.baseUrl + 'gallery/deleteAlbum',
				data: {
					album_id: album_id,
				},
				type: 'post',
				dataType: 'json',
			}))
			.then(function(result) {
				if(result === 1) {
					gallery.getAlbumList(1, 6);
					gallery.getAlbumsCount();

					console.log('then-ok');
				} else {
					console.log('then-not ok');
				}
			})
			.fail(function() {
				console.log('fail');
			});
		}
	},
};

$(function() {
	gallery.init();
});