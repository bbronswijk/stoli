// NOTIFICATIONS OBJECT

var notificaties = (function() {
	
	$notifications = $('.notificaties');
	$list = $notifications.find('.list-notificaties');
	$loadBtn = $notifications.find('#load-btn');
	
	// bind events
	$loadBtn.on('click',loadExtra);
	
	function loadExtra(){
		
		loader.update('load extra notifications..');
		
		var offset = $list.find('li').length;
		
		var data = {
			offset : offset
		};
				
		var action = link.base + '/notificaties/loadMore/';
		
		$.post(action, data, function(notifications) { 
			if( notifications.length > 0 ){			
				for( var i = 0; i < notifications.length; i++){
					
					var item = '<li id="notification_' + notifications[i].id + '">' +
							   		'<div class="profile-img">' +
										'<img src="' + notifications[i].picture + '" alt="profile"/>' +
									'</div>' +
									'<strong>' + notifications[i].last_name + ' </strong>' +
									notifications[i].message +
							'</li>';
							
					$list.append(item);
				}
			} else{
				$loadBtn.hide();
			}
			loader.hide();	
		},'json');
		
		
		
	}
	/*	
	function create(user_id, message){
		//loader.update('creating notification..');
		var data = {
			user_id : user_id,
			notification : message
		};
				
		var action = link.base + '/notifications/createNotification/';
		
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
	*/
})();
