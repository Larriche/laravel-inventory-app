var Items = {
	Init: function(){
		Items.registerEventListeners();
	},

	refreshItems: function(){
		var $container = $('#items-container');
		$container.html("");

		$.ajax({
	        type: 'get',
	        url : '/items',
	        success: function(response){
		        $container.html(response);
		    }
	    });
	},

	registerEventListeners: function() {
		// Event handler for submission of item add form
		$(document).on('submit', '#item-add-form', function(e){
			e.preventDefault();
			App.submitForm(this, Items.refreshItems, $('#items-add-errors-container'));
		});
	}
};

window.addEventListener('load', Items.Init);