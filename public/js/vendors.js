var Vendors = {
	Init: function(){
		Vendors.registerEventListeners();
	},

	registerEventListeners: function(){
		// Event handler for submission of vendor add form
		$(document).on('submit', '#vendor-add-form', function(e){
			e.preventDefault();
			App.submitForm(this, Vendors.refreshVendors, $('#vendors-add-errors-container'));
			$(this)[0].reset();
		});

        // Event handler for click of edit button of a vendor
		$(document).on('click', '.update-vendor', function(e){
			var id = $(this).data('id');
			Vendors.populateEditFields(id);
		});

		// Event handler for submission of vendor update form
		$(document).on('submit', '#vendor-update-form', function(e){
			e.preventDefault();
			App.submitForm(this, Vendors.refreshVendors, $('#vendors-update-errors-container'));
		});
	},

	refreshVendors: function(){
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

	populateEditFields: function(id){
		$.ajax({
	        type: 'get',
	        url : '/item_vendors/' + id,
	        success: function(vendor){
                $('#vendor-update-form').find('#name-edit-field').val(vendor.name);
                $('#vendor-update-form').find('#update-uploaded-logo').attr('src',vendor.logo_url);
                $('#vendor-update-form').attr('action', '/item_vendors/' + id);

		        $('#edit-vendor').modal('show');
		    }
	    });
	}
};

window.addEventListener('load', Vendors.Init);