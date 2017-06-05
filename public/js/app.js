var App = {
	Init: function() {
		$('.alert.fade-in').delay(10000).slideUp('fade-in');

		var closeButtons = $('.modal div.alert-danger a[data-dismiss=alert]');

		closeButtons.removeAttr('data-dismiss');

		closeButtons.on('click', function (event) {
			event.preventDefault();
			$(this).parent().addClass('hidden');
		});
        
        // Select 2
		$(".select2").select2();

		// Date Picker
		$(".datepicker").datepicker({
	        autoclose: true
	    });

		App.registerEventListeners();
	},

	buildErrorHtml: function(errors)
	{
		var errorHtml = "";

        $.each(errors , function(key , value){
            errorHtml += "<li>" + value[0] + "</li>";
        });

        return errorHtml;
	},

	showConfirmDialog: function(message)
	{
		$('#confirm-dialog .modal-body p#delete-message').text(message);
        $('#confirm-dialog').modal('show');
	},

	hideConfirmDialog: function()
	{
		$('#confirm-dialog').modal('hide');
	},

	setDeleteForm: function(actionURL, referenceId, header, attributes)
	{
		var form = $('#confirm-dialog .delete-form');

		if (header) {
			form.find('#delete-dialog-header').text(header);
		}

		if (attributes) {
			$.each(attributes, function (attribute, value) {
				form.attr(attribute, value);
			});
		}

		form.attr('action', actionURL);
        form.attr('id', referenceId);
	},

	submitForm: function(form, callback, $errorContainer, hideModal = true)
	{
	    var actionURL = $(form).attr('action');
		var formData = new FormData(form);

		NProgress.start();

		// Submit form via ajax
		$.ajax({
			url: actionURL, 
			type: 'POST',
			data: formData, 
			processData: false,
			contentType: false,
			cache: false,
			success: function (responseMsg) {
				new PNotify({
					title: 'Success',
					text: responseMsg.message,
					styling: 'bootstrap3',
					type: 'success'
				});
                
                if(hideModal){
				    $('.modal').modal('hide');
                }

				if (callback) {
					callback();
				}
			},

			error: function(response){
				if ($errorContainer) {
					var errors = response.responseJSON.errors;
					console.log(errors);
	                var errorHtml = App.buildErrorHtml(errors);

	                $errorContainer.find('ul').html(errorHtml);
	                $('.modal-error-div').removeClass('hidden')
	                	.delay(15000).queue(function () {
						$(this).addClass('hidden').dequeue();
					});
	            }
	            
 
                new PNotify({
					title: 'Error',
					text: "The form submission failed. Check form for specific details.",
					styling: 'bootstrap3',
					type: 'error',
					delay: 9500
				});
			}
	    }).always(function () {
			NProgress.done();
		});	
	},

	/**
	 * Display the current chosen image to be uploaded in the img tags
	 * set on the img element
	 */
	PreviewImage: function () {
		var imageElement = $(this).data('image-element');
		var defaultImage = $(this).data('default-image');

		if (this.files.length === 0) {
			$(imageElement).attr('src', defaultImage);
			return;
		}

		var image        = this.files[0];
		var allowedTypes = ['image/jpeg', 'image/png'];

		if (allowedTypes.indexOf(image.type) === -1 || image.size > $(this).data('parsley-max-file-size') * 1024) {
			$(imageElement).attr('src', defaultImage);
			return;
		}

		var reader = new FileReader();

		// Read the uploaded image file
		reader.readAsDataURL(image);

		// On load then assign it to the image element
		reader.onload = function (event) {
			$(imageElement).attr('src', event.target.result);
		}; 
	},

	registerEventListeners: function(){
		$(document).on('change', ':file', function() {
		    var input = $(this);
		    var numFiles = input.get(0).files ? input.get(0).files.length : 1;
		    var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		    input.trigger('fileselect', [numFiles, label]);
	    });

	    $(document).on('fileselect', ':file',function(event, numFiles, label) {

	       var input = $(this).parents('.input-group').find(':text'),
	           log = numFiles > 1 ? numFiles + ' files selected' : label;

	       if( input.length ) {
	           input.val(log);
	       } else {
	           if( log ) console.log(log);
	       }
	    });

	    $('[name=logo]').change(App.PreviewImage); 
	    $('[name=image]').change(App.PreviewImage); 
	}
};

window.addEventListener('load', App.Init);