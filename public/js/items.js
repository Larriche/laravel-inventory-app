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

	filterItems: function(form){
		// Filter items in items table based on some passed params
		var $container = $('#items-container');
		var price = $(form).find('[name=price]').val();
		var color = $(form).find('[name=color]').val();
		$container.html("");

		url = '/items?price=' + price + '&color=' + color;

		$.ajax({
	        type: 'get',
	        url : url,
	        success: function(response){
		        $container.html(response);
		    }
	    });
	},

	searchItems: function(form){
		// Search for items and referesh items table view
		var $container = $('#items-container');
		var name = $(form).find('[name=name]').val();
		$container.html("");

		url = '/items?name=' + name;
		console.log(url);

		$.ajax({
	        type: 'get',
	        url : url,
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

		// Event handler for click of item delete button
		$(document).on('click', '.delete-item', function(){
			var id = $(this).data('id');
            App.setDeleteForm('/items/' + id, 'item-delete-form', 'Delete Item From Inventory');
            App.showConfirmDialog("Do you want to delete this item?");
		});

		// Event handler for when form for deleting item is submitted
		$(document).on('submit', '#item-delete-form', function(e){
			e.preventDefault();
			App.submitForm(this, Items.refreshItems, null);
			App.hideConfirmDialog();
		});

		// Event handler for when form for filtering items is submitted
		$(document).on('submit', '#items-filter-form', function(e){
			e.preventDefault();
			Items.filterItems(this);
		});

		// Event handler for when form for searching for items is submitted
		$(document).on('submit', '#items-search-form', function(e){
			e.preventDefault();
			Items.searchItems(this);
		});
	}
};

window.addEventListener('load', Items.Init);