// BOTTLE OBJECT
var bottle = (function() {
		
	function saveBottle() {
		loader.update('saving bottle..');
		var action = link.base + '/bottles/insertBottle/';
		
		var data = {
			user_id : this.user_id,
			size : this.size,
			users : this.users,
			date : this.date,
			duration : this.duration,
			price : this.price
		};
		
		$.post(action, data, function(response) {
			if( Math.floor(response) == response && $.isNumeric(response) ){
				bottle.id = response;	
				//Bottles.get(); 		
			    events.emit('bottleSaved');
			    showAlert('succes','De nieuwe fles stoli is succesvol toegevoegd!');
			    notifications.create(user.id,'heeft een fles leeg gedronken met '+bottle.users.length+' anderen');	
			} else{
				showAlert('error','Er is iets misgegaan tijdens het toevoegen van de fles. mysql geeft de volgende error:'+response);
			}
						
		});
	}

	function deleteBottle(id) {
		
		if (confirm("Weet je zeker dat je deze fles wilt verwijderen?")) {
			loader.update('removing bottle from database..');
			bottle.size = '';
			var data = {
				bottle_id : id,
			};
			
			$date = $('#bottle_'+id+' .bottle-date').text();

			var action = link.base + '/bottles/deleteBottle/';

			$.post(action, data, function(response) {
				if( Math.floor(response) == response && $.isNumeric(response) ){
					events.emit('bottleDeleted');
				    showAlert('error','De fles stoli en behaalde badges zijn succesvol verwijderd!');
				    notifications.create(user.id,'heeft de fles stoli van '+$date+' verwijderd');
				} else{
					showAlert('error','Er is iets misgegaan tijdens het verwijderen van de fles..');
				}	
									
			});
		}
	}

	return {
		delete : deleteBottle,
		save : saveBottle
	};

})();



$(document).ready(function() {

	

	$(document).on('click','.bottle .delete', function() {
		var id = $(this).parent().attr('id').replace('bottle_', '');
		bottle.delete(id);
	});

	
}); // END JQUERY	