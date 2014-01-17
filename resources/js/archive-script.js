var archive = {

	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
		year: '',
		month: '',
		number_of_posts_per_page: 6,
	},

	init: function() {
		this.events();
		this.getYears();
	},

	events: function() {
		$('#year_wrap').on('click', 'div.year', function() {
			var year = $(this).find('p.archive_title').text();

			archive.globals.year = year;
			archive.getMonths(year);
		});

		$('#month_wrap').on('click', 'div.month', function() {
			var month = $(this).find('p.archive_title').text();

			archive.globals.month = month;
			archive.getPosts(month, 1, 6);
			archive.getPostsCount();
		});

		$('#next').on('click', function() {
			var to = parseInt($('#to').text()),
				all = parseInt($('#all').text());

			if(all - to > 0) {
				archive.getPosts(archive.globals.month, to + 1, 6);
			}
		});

		$('#prev').on('click', function() {
			var from = parseInt($('#from').text());

			if(from - 6 > 0) {
				archive.getPosts(archive.globals.month, from - 6, 6);
			}
		});

		$('#back_to_years').on('click', this.backToYears);

		$('#back_to_months').on('click', this.backToMonths);
	},

	getYears: function() { 
		$.when($.ajax({
			url: archive.globals.baseUrl + 'archive/getYears',
			type: 'post',
			dataType: 'json'
		}))
		.then(function(result) {
			if(result) {
				archive.listYears(result);
				console.log('then ok');
			} else {
				console.log('then not ok');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	listYears: function(data) {
		var source = $('#yearsListTemplate').html(),
			template = Handlebars.compile(source),
			html = template(data);

		$('#year_wrap').html(html);
	},

	getMonths: function(year) {
		$.when($.ajax({
			url: archive.globals.baseUrl + 'archive/getMonths',
			data: {
				year: year,
			},
			type: 'post',
			dataType: 'json'
		}))
		.then(function(result) {
			if(result) {
				archive.listMonths(result);
				archive.hideYearsShowMonths();
				console.log('then ok');
			} else {
				console.log('then not ok');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	listMonths: function(data) {
		var source = $('#monthsListTemplate').html(),
			template = Handlebars.compile(source),
			html = template(data);

		$('#month_wrap').html(html);
	},

	hideYearsShowMonths: function() {
		$('#year_wrap').addClass('hidden');
		$('#month_wrap').removeClass('hidden');

		$('#back_to_years').removeClass('hidden');
	},

	backToYears: function() {
		$('#year_wrap').removeClass('hidden');
		$('#month_wrap').addClass('hidden');

		$('#back_to_years').addClass('hidden');
	},

	getPosts: function(month, from, to) {
		$.when($.ajax({
			url: archive.globals.baseUrl + 'archive/getPosts',
			data: {
				year: archive.globals.year,
				month: month,
				from: from - 1,
				to: to,
			},
			type: 'post',
			dataType: 'json',
		}))
		.then(function(result) {
			if(result) {
				archive.listPosts(result.posts);
				archive.hideMonthsShowPosts();

				if(result.posts.length === 0) {
					$('#from').text('0');
				} else {
					$('#from').text(from);
				}
				
				$('#to').text(from + result.posts_num - 1);
			} else {
				console.log('then - not ok');
			}
		})
		.fail(function() {
			console.log('fail');
		});
	},

	getPostsCount: function() {
		var self = this;

		$.when($.ajax({
			url: archive.globals.baseUrl + 'archive/getPostsCount',
			data: {
				year: archive.globals.year,
				month: archive.globals.month,
			},
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

	listPosts: function(data) {
		var source = $('#postListTemplate').html(),
			template = Handlebars.compile(source),
			html = template(data);

		$('#archive_post_wrap').html(html);
	},

	hideMonthsShowPosts: function() {
		$('#month_wrap').addClass('hidden');
		// $('#archive_post_wrap').removeClass('hidden');
		$('#posts_wrap').removeClass('hidden');
		$('#paging').removeClass('hidden');

		$('#back_to_years').addClass('hidden');
		$('#back_to_months').removeClass('hidden');
	},

	backToMonths: function() {
		$('#month_wrap').removeClass('hidden');
		// $('#archive_post_wrap').addClass('hidden');
		$('#posts_wrap').addClass('hidden');
		$('#paging').addClass('hidden');

		$('#back_to_months').addClass('hidden');
		$('#back_to_years').removeClass('hidden');
	}
};

$(function() {
	archive.init();
});