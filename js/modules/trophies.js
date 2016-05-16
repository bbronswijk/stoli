/* INDEX TROPHIES
 * 1 		1 fles toegevoegd
 * 2		3 flessen toegevoegd
 * 3		5 flessen toegevoegd
 * 4		10 flessen toegevoegd
 * 5		15 flessen toegevoegd
 * 6		20 flessen toegevoegd
 * 7		30 flessen toegevoegd
 * 8		aanwezig bij meer dan 50% van de borrels
 * 9		fles in je eentje leeggedronken
 * 10		fles in je eentje binnen één dag leeggedronken
 * 11		meeste flessen
 * 12		Strippenkaart: met alle spelers in ieder geval 1 keer geborreld
 * 13		XP : fles gekocht
 * 14		XP : aanwezig bij borrel
 * 15		fles voor 12 u leeggedronken
 * 16		Toten aanwezig bij een borrel
 * 17		trophy: aanwezig bij de meeste borrels
 *
 */

var trophies = (function() {

	// list of trophies 
	// TODO fetch trophies from database
			var trophies = [{
					id : 1,
					type : 'badge',
					img : '1-fles',
					description : 'Je eerste fles Stoli toegevoegd!',
					xp : 100
				},{
					id : 2,
					type : 'badge',
					img : '3-flessen',
					description : 'Je derde fles Stoli toegevoegd!',
					xp : 100
				},{
					id : 3,
					type : 'badge',
					img : '5-flessen',
					description : 'Je vijfde fles Stoli toegevoegd!',
					xp : 100
				},{
					id : 4,
					type : 'badge',
					img : '10-flessen',
					description : 'Je tiende fles Stoli toegevoegd!',
					xp : 100
				},{
					id : 5,
					type : 'badge',
					img : '15-flessen',
					description : 'Je vijftiende fles Stoli toegevoegd!',
					xp : 100
				},{
					id : 6,
					type : 'badge',
					img : '20-flessen',
					description : 'Je twintigste fles Stoli toegevoegd!',
					xp : 100
				},{
					id : 7,
					type : 'badge',
					img : '30-flessen',
					description : 'Je dertigste fles Stoli toegevoegd!',
					xp : 100
				},{
					id : 8,
					type : 'badge',
					img : 'strippenkaart',
					description : 'Aanwezig bij meer dan 50% van de borrels!',
					xp : 100
				},{
					id : 9,
					type : 'badge',
					img : 'no-img',
					description : 'Fles in je eentje leeggedronken',
					xp : 100
				},{
					id : 10,
					type : 'badge',
					img : 'no-img',
					description : 'Fles in je eentje  binnen een dag leeggedronken',
					xp : 100
				},{
					id : 11,
					type : 'trophy',
					img : 'most',
					description : 'Je hebt de meeste flessen Stoli gekocht',
					xp : 100
				},{
					id : 12,
					type : 'badge',
					img : 'strippenkaart',
					description : 'Met alle spelers minimaal 1 keer geborreld',
					xp : 100
				},{
					id : 13,
					type : 'xp',
					img : '',
					description : 'fles gekocht',
					xp : 30 
				},{
					id : 14,
					type : 'xp',
					img : '',
					description : 'aanwezig bij een borrel',
					xp : 30 
				},{
					id : 15,
					type : 'badge',
					img : 'goodmorning',
					description : "Fles voor 12 u 's ochtends leeggedronken",
					xp : 100
				},{
					id : 16,
					type : 'badge',
					img : 'toten',
					description : "Toten is aanwezig bij de borrel",
					xp : -500
				}];
	
	
	// set elements
	var $badge = $('#badge-modal');
	var $overlay = $badge.find('.overlay');
	var $modal = $badge.find('.modal');
	badges = []; // earned trophies that will be shown

	// bind events
	$(document).on('click', '.exit_popup', _closeModal);
	$(document).on('click', 'button.close-modal', _closeModal);
	events.on('bottleAdded', getTrophies);
	events.on('badgesAdded',setTrophiesBottle);
	
	// HANDLING MODAL
	function _openModal() {
		$badge.show();
		$overlay.show();
		$modal.show();
	}

	function _closeModal() {
		badges = [];
		modal.close();
	}
	
	// SET TROPHIES OF AJAX CREATED BOTTLE
	function setTrophiesBottle(badges){
		number = badges.length;
		var bottle_ids = []; 
		$('.bottle').each(function(i){
			$cur_id = parseInt( $(this).attr('id').replace('bottle_','') );
			
			bottle_ids.push( $cur_id);
		});  
		
		var max_id = bottle_ids.sort( function(a, b){return b-a;} );
	
		$('#bottle_'+ max_id[0] +' .bottle-trophies').text(number);
		
	}

	
	// 1. gets called after bottle is added
	//    CALCULATION TROPHIES
	function getTrophies(items) {
		this.items = items;
		// second check if bottle is added
		if ( typeof bottle.size == 'undefined' && $.isNumeric(bottle.size))
			return false;

		// show loader
		loader.update('calculating trophies..');

		$.when(
			_getCompleted()
		).then(
			_checkNewTrophies
		).then(
			_saveBadges
		).then(
			showBadges
		).done(function(){
			if(badges.length > 0)_render();
			loader.hide();
		});
	}

	// 2. check in database which badges the user already has completed
	function _getCompleted() {
		// fetch array met completed badges from database\
		var action = link.base + '/trophies/checkCompleted/';

		var data = {
			user_id : user.id
		};

		return completed = $.post(action, data, function(response) {
			// if the database returns an error return an empty array
			if (!$.isArray(response)) {
				completed = [];
			} else {
				var result = [];
				// array

				for (var i = 0; i < response.length; i++) {
					result.push(response[i]['trophy_id']);
				}
				
				completed = result;
			}
		}, 'json');
	}
	
	// 3. Check if the user has completed the requirements for new badges
	// 		ADD here the conditions for the new badges
	// 		check if the user has earned new trophies and save the ID to the array stagedTrophies
	function _checkNewTrophies(){	
		// elements necessary for statistics
		var $bottles = $('#bottles');
		var $total = $bottles.find('.bottle');
		var $own = $bottles.find('.bottle.owner');
		var $attendee = $bottles.find('.bottle.present');
		var $present_amount = $attendee.length + $own.length;
		var $own_amount = $own.length;
		var $total_amount = $total.length;
				
		var stagedTrophies = [];
				
		// count own bottles
		if ($own_amount <= 30) {
			switch($own_amount) {
			case 1:
				if ($.inArray('1', completed) == -1)
					stagedTrophies.push(1);
				break;
			case 3:
				if ($.inArray('2', completed) == -1)
					stagedTrophies.push(2);
				break;
			case 5:
				if ($.inArray('3', completed) == -1)
					stagedTrophies.push(3);
				break;
			case 10:
				if ($.inArray('4', completed) == -1)
					stagedTrophies.push(4);
				break;
			case 15:
				if ($.inArray('5', completed) == -1)
					stagedTrophies.push(5);
				break;
			case 20:
				if ($.inArray('6', completed) == -1)
					stagedTrophies.push(6);
				break;
			case 30:
				if ($.inArray('7', completed) == -1)
					stagedTrophies.push(7);
				break;
			}
		}

		// count bottles all and present
		if ($.inArray('8', completed) == -1) {
			var percentage = $present_amount / $total_amount;
			if (percentage > 0.5 && $present_amount >= 10) {
				stagedTrophies.push(8);
			}
		}

		// fles in je eentje opgedronken
		if ($.inArray('9', completed) == -1 && bottle.duration == 480) {
			if (bottle.users.length == 0) {
				stagedTrophies.push(9);
			}
		}

		// fles in je eentje binnen een dag opgedronken
		if ($.inArray('10', completed) == -1) {
			if (bottle.users.length == 0 && bottle.duration < 480) {
				stagedTrophies.push(10);
			}
		}

		// meeste flessen
		if ($.inArray('11', completed) == -1) {
			var count_names = {};
			// count every
			for ( i = 0; i < items.length; i++) {
				var last_name = items[i]['last_name'];
				if (!( last_name in count_names)) {
					count_names[last_name] = 1;
				} else {
					count_names[last_name] = count_names[last_name] + 1;
				}
			}
			var arr = Object.keys(count_names).map(function(key) {
				return count_names[key];
			});

			var max = Math.max.apply(null, arr);

			var position = arr.indexOf(max);

			// check if there are not two winners;
			var sorted = arr.sort().reverse();
			if (sorted[0] != sorted[1]) {

				var winner = Object.keys(count_names)[position];
				if (user.last_name === winner) {
					stagedTrophies.push(11);
				}
			}
		}
		
		// voeg extra xp toe voor het toevoegen van een fles
		stagedTrophies.push(13);
		
		// voeg xp toe aan aanwezigen
		stagedTrophies.push(14);
		newTrophies = stagedTrophies;
		
		// fles voor 12 u opgedronken
		if ($.inArray('15', completed) == -1) {
			var time = bottle.date.split(' ')[1];
			var hour = parseInt( time.split(':')[0] );
			console.log('hour:'+hour);
			if ( hour > 6 && hour < 12) {
				// stage trophy
				stagedTrophies.push(15);
			}
		}
		
		// check of toten aanwezig is bij een borrel
		// Pim test id = 1335850137
		var toten = '969133486496698';
		
		if( $.inArray( toten, bottle.users ) != -1 ){
			console.log('Help! Toten aanwezig!');
			stagedTrophies.push(16);
		}
		
		return;
	}

	// 4. save the badges to the datbase and create a notification
	function _saveBadges() {	
		loader.update('prepraring trophies..');
		
		var deferreds = [];
				
	  	$.each(newTrophies, function(i) {
	    	
	    	var cur_trophy  = newTrophies[i]-1;
	    	
	    	var badge_type = trophies[cur_trophy]['type'];
	    	var badge_id = trophies[cur_trophy]['id'];
	    	var badge_img = trophies[cur_trophy]['img'];
	    	var badge_description = trophies[cur_trophy]['description'];
	    	var badge_xp = trophies[cur_trophy]['xp'];
	    	
			// select right model
			if (badge_type === 'trophy') {
				// delete old row with trophy and insert new one
				var action = link.base + '/trophies/updateTrophy/';
			} else {
				// insert new row in the user_trophies table
				var action = link.base + '/trophies/insertTrophy/';
			}
			
			if(badge_id != 14){
				var data = {
					bottle_id : bottle.id,
					user_id : user.id,
					badge_id : badge_id
				};
				
				deferreds.push(
					$.post(action, data, function(response) {
						// push badge to the badges array to be shown
						if (response == 1) {
							if(badge_type != 'xp'){
								var badge = {
									id : badge_id,
									number : badges.length + 1,
									img : badge_img,
									description : badge_description,
									xp : badge_xp
								};
							
								badges.push(badge);
								notifications.create(user.id, 'heeft de badge <b>' + badge_img + '</b> verdiend - ' + badge_xp + ' XP');
							}
						} else {
							showAlert('error', 'Het toevoegen van de badges geeft een error: ' + response);
						}
					})
				);
			} else{
				
				
				var users = bottle['users'];
				$.each(users,function(i){
					
					var attendee_id = users[i];
				
					var data = {
						bottle_id : bottle.id,
						user_id : attendee_id,
						badge_id : badge_id
					};
					
					deferreds.push(
						$.post(action, data, function(response) {
							// push badge to the badges array to be shown
							if (response != 1) {
								showAlert('error', 'Het toevoegen van de xp aan de aanwezigen geeft een error: ' + response);
							}
						})
					);
					
				});
				
				
			} // /else
		
		}); // each
		
		listActions = deferreds;
		return;
	}
	
	// 5. check if there are new badges completed
	// calls next function _render(6)
	function showBadges() {			
		$.when.apply($, listActions).done(function(){
			if(badges.length > 0)_render();
			loader.hide();
			events.emit('badgesUpdated');
		});		
	}

	// 6. create a carousel with new badges
	function _render() {
		
		var amount = (badges.length > 1 && badges.length != 0) ? 'badges' : 'badge';

		var data = {
			amount : amount,
			badges : badges
		};

		_openModal();

		$.get('views/bottles/badges.mst', function(template) {
			var view = data;
			var output = Mustache.render(template, view);
			$modal.html(output).promise().done(function() {
				$("#badge-modal .owl-carousel").owlCarousel({
					navigation : false,
					pagination : false,
					loop : true,
					slideSpeed : 300,
					paginationSpeed : 400,
					singleItem : true,
					autoPlay : 1500,
					addClassActive : true
				});
			});
		});

		events.emit('badgesAdded',badges);
		// reset the array of badges that will be rendered
		badges = [];

	}

})();

$(document).ready(function() {

	$('.overlay').click(function() {
		// to stop the autoplay after closing
		$("#badge-modal .owl-carousel").remove();
	});

});
// END JQUERY	