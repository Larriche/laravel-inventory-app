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

		// Event handler for click of vendor delete button
		$(document).on('click', '.delete-vendor', function(){
			var id = $(this).attr('data-id');
            App.setDeleteForm('/item_vendors/' + id, 'vendor-delete-form', 'Delete Vendor');
            App.showConfirmDialog("Do you want to delete this vendor?");
		});

		// Event handler for when form for deleting item vendor is submitted
		$(document).on('submit', '#vendor-delete-form', function(e){
			e.preventDefault();
			App.submitForm(this, Vendors.refreshVendors, null);
			App.hideConfirmDialog();
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