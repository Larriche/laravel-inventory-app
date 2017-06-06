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

	populateEditFields: function(id){
		$.ajax({
	        type: 'get',
	        url : '/items/' + id,
	        success: function(item){
	        	// Set the fields in the form with existing data from the database
	        	$form = $('#item-update-form');
	        	$form.find('[name=name]').val(item.name);
	        	$form.find('[name=serial_number]').val(item.serial_number);
	        	$form.find('[name=price]').val(item.price);
	        	$form.find('[name=weight]').val(item.weight);
	        	$form.find('[name=color]').val(item.color);
	        	$form.find('[name=tags]').val(item.tags);
	        	$form.find('[name=type_id]').val(item.type_id).change();
	        	$form.find('[name=vendor_id]').val(item.vendor_id).change();
	        	$form.find('#updated-item-image').attr('src', item.image_url);
	        	$form.find('[name=release_date]').datepicker("update", item.release_date);

	        	// Set action url for form 
	        	$form.attr('action', '/items/' + id);

    	        $('#edit-item').modal('show');
		    }
	    });
	},

	registerEventListeners: function() {
		// Event handler for submission of item add form
		$(document).on('submit', '#item-add-form', function(e){
			e.preventDefault();
			App.submitForm(this, Items.refreshItems, $('#items-add-errors-container'));
		});

		// Event handler for click of update button of an item
		$(document).on('click', '.update-item', function(e){
			e.preventDefault();
			var id = $(this).data('id');
			Items.populateEditFields(id);
		});

		// Event handler for submission of item update form
		$(document).on('submit', '#item-update-form', function(e){
			e.preventDefault();
			App.submitForm(this, Items.refreshItems, $('#items-update-errors-container'));
		});
	}
};

window.addEventListener('load', Items.Init);