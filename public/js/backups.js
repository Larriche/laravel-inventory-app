Backups = {
	init: function(){
		Backups.registerEventListeners();
	},

	registerEventListeners: function(){
		/*
		$(document).on('submit', '#backups-form', function(e){
			e.preventDefault();
			$('backup-form-button').attr('value', 'Backing up data...');
			App.submitForm(this,Backups.refreshButtonLabel,null);
		});
		*/

		$(document).on('submit', '#db-restore-form', function(e){
			e.preventDefault();
			App.submitForm(this, null, null);
		});
	},

	refreshButtonLabel: function(){
		$(document).find('backup-form-button').attr('value', 'BACK UP DATABASE');
	}
};

window.addEventListener('load', Backups.init);