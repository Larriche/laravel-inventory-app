var Users = {
	Init: function () {
		Users.registerEventListeners();
	},

	registerEventListeners: function() {
		// Event handler for when user add form is submitted
		$(document).on('submit', '#user-add-form', function(e){
			e.preventDefault();
			App.submitForm(this, Users.refreshUsers, $('#users-add-errors-container'));
		});

		// Event handler for when user update button is clicked
		$(document).on('click', '.update-user', function(){
			var id = $(this).data('id');
			Users.populateEditFields(id);
		});

		// Event handler for when user update form is submitted
		$(document).on('submit', '#user-update-form', function(e){
			e.preventDefault();
			App.submitForm(this, Users.refreshUsers, $('#users-update-errors-container'));
		});

		// Event handler for click of user delete button
		$(document).on('click', '.delete-user', function(){
			var id = $(this).data('id');
            App.setDeleteForm('/users/' + id, 'user-delete-form', 'Delete User Account');
            App.showConfirmDialog("Do you want to delete this user account?");
		});

		// Event handler for when form for deleting user is submitted
		$(document).on('submit', '#user-delete-form', function(e){
			e.preventDefault();
			App.submitForm(this, Users.refreshUsers, null);
			App.hideConfirmDialog();
		});

		// Event handler for when form for updating account is submitted
		$(document).on('submit', '#user-account-form', function(e){
			e.preventDefault();
			App.submitForm(this, null, $('#account-errors-container'));
			App.hideConfirmDialog();
		});
	},

	filterTable: function() {
		var role_id = $('[name=role_id_filter]').val();
		var status_id = $('[name=status_id_filter]').val();
		var url = '/users';
		url = (role_id || status_id) ? (url + '?') : url;
		url += (role_id) ? ('role_id=' + role_id) : '';
		url += (status_id) ? ('&status_id=' + status_id) : '';

		$container = $('#users-container');

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
	        url : '/users/' + id,
	        success: function(response){
	        	console.log(response);
	        	$form = $(document).find('#user-update-form');
	        	$form.find('[name=username]').val(response.user.username);
	        	$form.find('[name=name]').val(response.user.name);
	        	$form.find('[name=email]').val(response.user.email);
	        	$form.find('[name=role_id]').val(response.user.role_id).change();
	        	$form.find('[name=status_id]').val(response.user.status_id).change();
	        	$form.attr('action', 'users/' + id);

	        	$('#user-edit').modal('show');
		    }
	    });
	},

	refreshUsers: function()
	{
		$container = $('#users-container');

		$.ajax({
	        type: 'get',
	        url : '/users',
	        success: function(response){
		        $container.html(response);
		    }
	    });
	},

	/**
	 * This is used toggle the edit function on my accounts page. This changes 
	 * the value of the handler [default: EDIT ACCOUNT] to suit the current 
	 * operation. It also hides or shows the edit form.
	 */
	enableUserEdit: function (element) {
		// Toggling the hidden class on the editables
		$('.editable').toggleClass('hidden');

		if ($('input#name').attr('disabled')) {
			$('input#name').removeAttr('disabled');
		} else {
			$('input#name').attr('disabled', true);
		}

		if ($('input#email').attr('disabled')) {
			$('input#email').removeAttr('disabled');
		} else {
			$('input#email').attr('disabled', true);
		}

		// Changing the value of the handler
		if ($(element).val() == 'EDIT ACCOUNT') {
			$(element).val('CANCEL EDIT');	
		} else {
			$(element).val('EDIT ACCOUNT');	
		}

		if ($('.password_editable').hasClass('hidden') === false) {
			$('.password_editable, .validate_user').addClass('hidden');
			$('input#change_password').val('CHANGE PASSWORD');	
		}
	},

	/**
	 * This function takes care of the change password functionlaity on the 
	 * my accounts page. It toggles the hidden class on the password_editable 
	 * classes and also changes the value and classes of the handler
	 */
	enableChangePassword: function (element) {
		$('.password_editable').toggleClass('hidden');

		if ($(element).val() == 'CHANGE PASSWORD') {
			$(element).val('CANCEL PASSWORD CHANGE');	
		} else {
			$(element).val('CHANGE PASSWORD');	
		}
		
		if($('.password_editable').is(":visible")) {
			$('.validate_user').removeClass("hidden");
		}else{
			$('.validate_user').addClass("hidden");
		}
	},
};

// Initializing the init function
Users.Init();