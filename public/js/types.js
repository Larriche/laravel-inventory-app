var Types = {
	Init: function(){
		Types.registerEventListeners();
	},

	registerEventListeners: function(){
		// Event handler for submission of type add form
		$(document).on('submit', '#type-add-form', function(e){
			e.preventDefault();
			App.submitForm(this, Types.refreshTypes, $('#types-add-errors-container'));
			$(this)[0].reset();
		});

        // Event handler for click of edit button of an item type
		$(document).on('click', '.update-type', function(e){
			var id = $(this).data('id');
			Types.populateEditFields(id);
		});

		// Event handler for submission of type update form
		$(document).on('submit', '#type-update-form', function(e){
			e.preventDefault();
			App.submitForm(this, Types.refreshTypes, $('#types-update-errors-container'));
		});

		// Event handler for click of type delete button
		$(document).on('click', '.delete-type', function(){
			var id = $(this).attr('data-id');
            App.setDeleteForm('/item_types/' + id, 'type-delete-form', 'Delete Item Type');
            App.showConfirmDialog("Do you want to delete this type?");
		});

		// Event handler for when form for deleting item type is submitted
		$(document).on('submit', '#type-delete-form', function(e){
			e.preventDefault();
			App.submitForm(this, Types.refreshTypes, null);
			App.hideConfirmDialog();
		});
	},

	refreshTypes: function(){
		var $container = $('#types-container');
		$container.html("");

		$.ajax({
	        type: 'get',
	        url : '/item_types',
	        success: function(response){
		        $container.html(response);
		    }
	    });
	},

	populateEditFields: function(id){
		$.ajax({
	        type: 'get',
	        url : '/item_types/' + id,
	        success: function(vendor){
                $('#type-update-form').find('#name-edit-field').val(vendor.name);
                $('#type-update-form').attr('action', '/item_types/' + id);

		        $('#edit-type').modal('show');
		    }
	    });
	}
};

window.addEventListener('load', Types.Init);