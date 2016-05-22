/**
 * @author Bram
 */

var Bottles = (function() {
		
	// bind events
	events.on('bottleSaved',getBottles);
	events.on('bottleDeleted',getBottles);
	events.on('PageReady',getBottles);
	// getbottles is called directly when bottle is added
	
	// load ajax bottles 
	function getBottles(){
		
		if( !$('body').hasClass('bottles-page') ) return false;

		
		$.get('bottles/getAttendees', function(attendees){
			$.get('bottles/getTrophies', function(trophies){
				$.get('bottles/getBottles', function(bottles){
					loader.update('building list bottles...');
					//alert(JSON.stringify(trophies));
					//	alert('id 0:'+trophies[8].id+' trophies[8].trophies :'+trophies[8].trophies );		
					
					for( var i = 0; i < bottles.length; i++){
						$id = bottles[i].id;
						
						// trophies[i].trophies && 0 > i < 7
						if(i < trophies.length){
							if( trophies[i].trophies ){
								$trophies = trophies[i].trophies;
							} else{
								$trophies = 0;
							}			
						}
										
						// trophies
						bottles[i]['trophies'] = $trophies;
											
						if(typeof attendees[$id] != 'undefined'){
							$attendees = attendees[$id][0]['attendees'].split(',');
							$attendees_ids = attendees[$id][0]['ids'].split(',');
							// add attendees to object
							bottles[i]['attendees'] = $attendees;
							bottles[i]['attendees_ids'] = $attendees_ids;
						}
						
						// size
						bottles[i]['size'] = bottles[i]['size']/100;
						
						// date 
						var date = bottles[i]['date'];
						var date = date.split(" ");
						var formattedDate = new Date(date[0]);
						var d = formattedDate.getDate();
						var m =  formattedDate.getMonth();
						var month = ['jan','feb','mrt','apr','mei','jun','jul','aug','sept','okt','nov','dec'];
						
						var m = month[m];
						var y = formattedDate.getFullYear();
						
						bottles[i]['date'] = d + " " + m + " " + y;
						
						// class
						bottles[i]['class'] = '';
						
						// set owner id 
						bottles[i]['owner_id'] = bottles[i]['owner'];
											
						// get owner id 
						if( user.id === bottles[i]['owner'] ){
							bottles[i]['class'] = 'owner';
							bottles[i]['owner'] = true;
						} else{
							// get attendees id
							bottles[i]['owner'] = false;
							if( typeof $attendees_ids != 'undefined'){
								for( var b = 0; b < $attendees_ids.length; b++ ){
									if( user.id === $attendees_ids[b] ){
										bottles[i]['class'] = 'present';
									}
								}
							}
						}
	
					}
					
					//console.log(bottles);
					
					render(bottles);
		
				},'json');
			},'json');
		},'json');

		
	}
	
	function render(bottles){
		loader.update('rendering list...');	
		
		$.when(
			$.get('views/bottles/bottle.mst',function(template){	
				var view = { bottles : bottles};
				
				var output = Mustache.render(template,view);
					
				$('#bottles').html(output);	
			})
		).done(
			function(){
				loader.hide();	
				if(typeof bottle.size != 'undefined' && $.isNumeric(bottle.size) ) events.emit('bottleAdded',bottles);
				events.emit('bottlesChanged',bottles);	
		});			
		
		
	}
	
	// API
	return {
		get : getBottles
	};

})();

$(document).ready(function() {

	// filter bottles
	$('#bottlesHeader li a').on('click', function() {
			var filter = $(this).data('filter');
			$('#bottlesHeader li a').removeClass('selected');
			$(this).addClass('selected');
			if (filter === 'all') {
				$('.bottle').show();
			} else if (filter === 'owner') {
				$('.bottle').hide();
				$('.bottle.owner').show();
			} else if (filter === 'present') {
				$('.bottle').hide();
				$('.bottle.owner').show();
				$('.bottle.present').show();
			}
		});


}); // END JQUERY	