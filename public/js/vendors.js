var Vendors = {
	Init: function(){
		Vendors.registerEventListeners();
	},

	registerEventListeners: function(){
		$(document).on('submit', '#vendor-add-form', function(e){
			e.preventDefault();
			App.submitForm(this,Vendors.refreshVendors, $('#vendors-add-errors-container'));
			$(this)[0].reset();
		});
	},

	refreshVendors: function()
	{
		var $container = $('#vendors-container');
		$container.html("");

		$.ajax({
	        type: 'get',
	        url : '/item_vendors',
	        success: function(response){
		        $container.html(response);
		    }
	    });
	},
};

window.addEventListener('load', Vendors.Init);