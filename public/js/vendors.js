var Vendors = {
	Init: function(){
		Vendors.registerEventListeners();
	},

	registerEventListeners: function(){
		$(document).on('submit', '#vendor-add-form', function(e){
			e.preventDefault();
			App.submitForm(this);
			$(this)[0].reset();
		});
	}
};

window.addEventListener('load', Vendors.Init);