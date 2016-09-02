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
	var complete = null;
	var presence = null;
	
	levels = [{
					level: 'sober',
					xp: 0				
				},{
					level: 'tipsy',
					xp: 100		
				},{
					level: 'horny',
					xp: 300		
				},{
					level: 'reckless',
					xp: 600		
				},{
					level: 'drunk',
					xp: 1000		
				},{
					level: 'hammered',
					xp: 1500		
				},{
					level: 'trainwreck',
					xp: 2100		
				},{
					level: 'wasted',
					xp: 2800		
				},{
					level: 'black out',
					xp: 3600		
				},{
					level: 'coma',
					xp: 4500		
				},{
					level: 'probably dead',
					xp: 5500		
				}];
		
	// bind events
	events.on('bottlesChanged',updateBottles);
	events.on('bottlesChanged',getStats);
	events.on('badgesUpdated',getStats);
	events.on('PageReady',getStats);
	$logOut.on('click',logOut);
	
	function returnLevel(xp){
		var user_level = 'sobert';
		// loop trough all user levels
		$.each(user.levels,function(i){
			if(user.levels[i]['xp'] < xp  ){
				user_level = user.levels[i]['level'];
			} else{
				return user_level;
			}
		});
		
		
	}
	
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

	// get the stats of the online user for the topbar
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
					if(levels[i]['xp'] <= xp ){
						user_level = levels[i]['level'];
					} else{
						return false;
					}
				});
				
				if( response.tax > 0 ){
					xp /= 2;
				}
								
				$('.online-user .user-level #level').text(user_level);
				$('.online-user .bottle-trophies').text(trophies);
				$('.online-user .user-level #xp').text(xp+' XP');
			}
		}, 'json');
		
		// get users from database
		function _getUsers(){
			$.get('dashboard/getUsers', function(users) {
				user.users = users;
				$.each(user.users, function(i){
					user.users[i].saldo = 0;
					user.users[i].bought = 0;
					user.users[i].present = 0;
					user.users[i].people_met = 0;
					user.users[i].social = 0;
					if( user.users[i].tax == 1)
						user.users[i].xp /= 2;
				});				
			},'json');			
		}
		
		// get amount of borrels user was present from database
		function _getPresence(){
			$.get('dashboard/getPresence', function(presence) {
				user.presence = presence;
			},'json');
		}
		
		// set borrels present to users array
		function _setPresence(){
			$.each(user.presence,function(i){
				var cur_user = user.presence[i]['id'];
				$.each(user.users,function(c){
					if( cur_user == user.users[c]['id'] ){						
						user.users[c].present = user.presence[i]['present']; 
					}
				});				
			});	
		}
		
		// calculate the bottle related statistics
		function setBottleStatistics(){
			$.each(Bottles.bottles,function(i){
				//define size
				var cur_bottle = Bottles.bottles[i];
				var size = cur_bottle['size'];
				
				if( typeof cur_bottle['attendees_ids'] != 'undefined' ){
					var attendees = cur_bottle.attendees_ids;
					var num_attendees = cur_bottle['attendees_ids'].length + 1;			
				}else{
					var attendees = [];
					var num_attendees = 1;
				}
				
				var saldo = size/num_attendees;
				
				// assign statistics to users
				$.each(user.users,function(c){
					var cur_user = user.users[c];
					// if bottle owner 
					if( cur_user.id == cur_bottle.owner_id){
						// add size to owner bought
						cur_user.bought += size;						
					}
					
					// if user is present at bottle
					if( $.inArray( cur_user.id , attendees) > -1 || cur_user.id == cur_bottle.owner_id ){
						// add saldo drunk to owner and attendees
						cur_user.saldo += saldo;
						// add attendee count  
						cur_user.people_met += ( num_attendees - 1 ); // jezelf ontmoeten telt niet
					}
				
				});
			});
			
			$.each(user.users,function(i){
				var cur_user = user.users[i];
				var profit = cur_user.saldo - cur_user.bought;
				
				cur_user.profit = profit;	
				
				// gemiddeld aantal personen op borrel
				if( cur_user.people_met > 0 && cur_user.present > 0 ){
					cur_user.social = cur_user.people_met / cur_user.present;
				} else{
					cur_user.social = 0;
				}
			});
			
		}
				
		$.when(
			// load everything from the db
			_getUsers(),
			_getPresence()
			// the getBottles() function runs in the bottles module Bottles.bottles
		).then( function(){
			// combine everything in the user.users array 
			
			// for some reasone the callback gets called twice. Only proceed when really done!
			if(!user.presence) return false;
						
			// combine presence and main users object
			_setPresence();	
			
			// calculate bottleStatistics
			setBottleStatistics();
			
		}).done(function(){
			if(!user.presence) return false;
			
			//console.log(user.users);
			// store the complete user object in seperate array
			user.complete = user.users;
			
			events.emit('UsersReady');
			
		});
	}
	
	return {
		id : id,
		last_name : last_name,
		levels : levels,
		users: users,
		complete: complete,
		returnLevel : returnLevel
	};

})();


