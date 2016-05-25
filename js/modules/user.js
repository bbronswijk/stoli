/**
 * @author bramb
 */
	
var user = (function(){		
		
	var id = $('.online-user #user-id').text();
	var $logOut = $('.logout');
	var last_name = $('.online-user .last-name').text(); 
	var $bottles = $('#bottles');
	var $total = $bottles.find('.bottle');
	var $own = $bottles.find('.bottle.owner');
	var $own_amount = $own.length;
	var users = null;
	var presence = null;
	
	levels = [{
					level: 1,
					xp: 100				
				},{
					level: 2,
					xp: 200		
				},{
					level: 3,
					xp: 300		
				},{
					level: 4,
					xp: 400		
				},{
					level: 5,
					xp: 500		
				},{
					level: 6,
					xp: 600		
				},{
					level: 7,
					xp: 700		
				},{
					level: 8,
					xp: 800		
				},{
					level: 9,
					xp: 900		
				},{
					level: 10,
					xp: 1000		
				}];
		
	// bind events
	events.on('bottlesChanged',updateBottles);
	events.on('bottlesChanged',getStats);
	events.on('badgesUpdated',getStats);
	events.on('PageReady',getStats);
	$logOut.on('click',logOut);
	
	function logOut(){
		var action = link.base + '/login/logout/';
				
		$.get(action, function(response) {			
			if(response === 'destroyed'){
			 	window.location.replace(link.base+'/login/');
			}
		},'json');
	}
		
	// update number of bottles -> this one doens't  use a db call
	function updateBottles(bottles){		
		var amount = 0;
		
		$.each(bottles, function(i) {	
	    	if( bottles[i]['owner'] == true ) amount += 1 ;
		});
		
		$('.online-user .number-bottles').text(amount);	
	}

	// only for the xp and trophies	
	function getStats(){
		var action = link.base + '/user/getStats/';

		$.get(action, function(response) {
			if ($.isArray(response)) {
				
				var xp = 0;
				var trophies = 0;
				var user_level = 0;
				 
				$.each(response, function(i) {	
			    	xp += parseInt(response[i]['xp']);
			    	if(response[i]['type'] != 'xp'){
			    		trophies += 1;
			    	}
				});
				
				$.each(levels, function(i){
					if(levels[i]['xp'] < xp ){
						user_level = levels[i]['level'];
					} else{
						return false;
					}
				});
								
				$('.online-user .user-level #level').text('Level '+user_level);
				$('.online-user .bottle-trophies').text(trophies);
				$('.online-user .user-level #xp').text(xp+' XP');
			}
		}, 'json');
		
		$.get('dashboard/getUsers', function(users) {
			user.users = users;
		},'json');
		
		$.get('dashboard/getPresence', function(presence) {
			user.presence = presence;
		},'json');
	}
	
	return {
		id : id,
		last_name : last_name,
		levels : levels,
		users: users,
		presence : presence
	};

})();


