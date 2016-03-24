// NOTIFICATIONS OBJECT

var notifications = (function() {
	
	$notification = $('.notifications');
	
	function update(){
		var last_notification  = $notification.find('li:first').attr('id').replace('notification_','');

		var user_id = user.id;
		
		var data = {
			user_id : user_id,
			notification : last_notification
		};
		
		var url = window.location.origin;			
		var action = url + '/stoli/notifications/clearNotifications/';
		
		$.post(action, data, function(response) {
			
			if(response.length === 1){
				$notification.find('.counter').remove();
				$notification.find('.notifications-container').remove();
				$notification.find('.notification-icon').toggleClass('empty');	
			}							
		});
	}
	
	function create(user_id, message){
		//loader.update('creating notification..');
		var data = {
			user_id : user_id,
			notification : message
		};
		
		var url = window.location.origin;			
		var action = url + '/stoli/notifications/createNotification/';
		
		$.post(action, data, function(response) {
			
			var user = response;
	
			var name = user[0].last_name;
			var picture = user[0].picture; 
			var note_id = user.last_id;
			//alert(JSON.stringify(user));	
			if(JSON.stringify(user)){	
				// check if notification is empty 
				if($notification.find('.notification-icon').hasClass('empty')){
					// create element count
					$notification.find('.notification-icon').removeClass('empty');
					$notification.find('.notification-icon').append('<div class="counter">1</div>');
					$notification.append('<div class="notifications-container"><h1>Notifications</h1><ul></ul></div>');
				} else{
					// increase count
					$count = parseInt($notification.find('.counter').text());
					$count += 1;
					$notification.find('.counter').text($count);
				}
				$notification.find('ul').prepend('<li id="notification_'+note_id+'"><div class="profile-img"><img src="'+picture+'" alt="profile"/></div><strong>'+name+'</strong> '+message+'</li>');

			}
			loader.hide();							
		},'json');
	}
	
	return {
		update : update,
		create : create
	};
})();

$(document).ready(function() {

	$('.notification-icon').on('click', function() {
		// check if there are unread notifications
		if( $('.notification-icon .counter').length ){
			// TODO disable button while ajax is running $(this).prop('disabled', true);
			notifications.update();
		}
	});

}); // END JQUERY	