var navigation = {

	globals: {
		baseUrl: 'http://localhost/ediary/index.php/',
	},

	init: function() {
		this.events();
	},

	events: function() {
		$('#menu').on('click', 'li.menu_item', this.determineModule);
			
	},

	determineModule: function(e) {
		var li_tag = $(this),
			target = li_tag.find('a').text();

		if(target === 'new post') {
			target = 'new_post';
		}
		
		// console.log(target);
		navigation.redirect(target);
	},

	redirect: function(target) {
		window.location.replace(navigation.globals.baseUrl + target);
	},

};

$(function() {
	navigation.init();
});