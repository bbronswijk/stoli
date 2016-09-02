/**
 * @author bramb
 */

var track = (function(){
	
	var $trackPopup = $('#trackPopupModule');
	
	// bind events
	events.on('PageReady',getTrackers);
	
	function save () {
	  loader.update('saving bottle..');
		var action = link.base + '/track/insertBottle/';
		
		var data = {
			user_id : this.user_id,
			date : this.bottle_date
		};
		
		$.post(action, data, function(response) {
			if( Math.floor(response) == response && $.isNumeric(response) ){
				getTrackers(); 		
			    showAlert('succes','De nieuwe fles stoli is succesvol toegevoegd!');
			    
			    var subject = user.last_name + ' heeft een fles toegevoegd aan de track & track op wiebetaaltdeStoli';
				var title = 'Er is een fles toegevoegd aan de track & trace!';
				var text = '<p>'+user.last_name  + ' heeft zojuist een fles Stoli toegevoegd aan de track&trace op wiebetaaltdestoli.com.</p><p>Bekijk de status van de fles op de website. Die fles moet op!</p>';
																
				notifications.send(subject, title, text);
			    
			   	notifications.create(track.user_id,'heeft een fles gekocht, die is toegevoegd aan de track & trace');	
			   	loader.hide();
			} else{
				showAlert('error','Er is iets misgegaan tijdens het toevoegen van de fles. mysql geeft de volgende error:'+response);
			}
						
		});
	}
	
	function getTrackers(){
		
		$.get('track/getTrackers', function(trackers){
			//console.log(trackers);
			var months = ['januari','februari','maart','april','mei','juni','juli','augustus','september','oktober','november','december'];
			var days = ['Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag','Zaterdag','Zondag'];
			
			$.each(trackers,function(i){
				// set formatted date
				var date = new Date(trackers[i]['bought']);
				var month = months[ date.getMonth() ];
				var nameDay = days[ date.getDay() ];
				var day = date.getDate();
				trackers[i]['datum'] = nameDay+' '+day+' '+month;
				
				// set owner 
				if( user.id == trackers[i]['owner'] ){
					trackers[i]['owner-class'] = 'owner';
				} else{
					trackers[i]['owner-class'] = '';
				}
				
				var status = parseInt(trackers[i]['status']);
				
				// set progress
				switch ( status  ){
					case 0:
						trackers[i]['progress'] = 'shop';
						trackers[i]['last0'] = 'last';							
						break;
					case 1:
						trackers[i]['progress'] = 'bought';
						trackers[i]['last1'] = 'last';	
						break;
					case 2:
						trackers[i]['progress'] = 'cold';
						trackers[i]['last2'] = 'last';							
						break;
					case 3:
						trackers[i]['progress'] = 'borrel';
						trackers[i]['last3'] = 'last';	
						break;
					case 4:
						trackers[i]['progress'] = 'empty';
						trackers[i]['last4'] = 'last';	
						break;
				}
				
				if( status >= 0 )
					trackers[i]['status0'] = 'active';
				
				if( status >= 1 )
					trackers[i]['status1'] = 'active';
				
				if( status >= 2 )
					trackers[i]['status2'] = 'active';
				
				if( status >= 3 )
					trackers[i]['status3'] = 'active';
									
				if( status >= 4 )
					trackers[i]['status4'] = 'active';
				
			});
			
			$.get('views/track/trackers.mst',function(template){	
				var view = { trackers : trackers};
				
				var output = Mustache.render(template,view);
					
				$('#trackers').html(output);	
			});
			
		},'json');
	}
	
	return {
		save : save,
		get : getTrackers
	};
	
})();

var trackPopUp = (function(){
	
	// elements
	var $module = $('#track-module');
	var $track = $module.find('.track');
	var $modal = $('#trackPopupModule');
	var $overlay = $modal.find('.overlay');
	
	// tracker
	var $buttons = $track.find('.fa');		
	var $addBtn = $module.find('button.add');
	
	// popup
	var $attendees = $modal.find('#choose-attendees');
	var $attendeeOptions = $attendees.find('li');
	var $nextBtn = $modal.find('button.next');
	var $prevBtn = $modal.find('a.back-btn');
	var $saveBtn = $modal.find('button.add');
	$nextBtn.on('click', nextQuestion);
	$prevBtn.on('click', previousQuestion);
	$saveBtn.on('click', save);

		
	// bind dom events
	$module.on('click',$buttons,updateStatus);
	$addBtn.on('click',openModal);	
	$attendees.on('click', 'li', togglePresence);
	
	function openModal(){
		$modal.show();
		$overlay.show();
		$modal.find('.modal').show();
	}
	
	// a lot of the code underneath is copied from bottlePopup.js
	// TODO move to modal.js
	function closeModal() {
		$('.part').show();
		$attendees.find('li').removeClass('active');
		modal.close();
	}

	function togglePresence() {
		$attendeeOptions.removeClass('active');
		$(this).toggleClass('active');
	}

	function nextQuestion() {
		$id = $(this).attr('id').replace(/[^\d]/g, '');
		if( !$attendeeOptions.hasClass('active') ){
			alert('Selecteer een eigenaar van de nieuwe fles!');
			return false;
		}
			
		$('#part' + $id).hide();
		
	}

	function previousQuestion() {
		$id = $(this).attr('id').replace(/[^\d]/g, '');
		$('#part' + $id).show();
	}	

	function updateStatus(e) {		
		var $clicked_button = $(e.target);
		var $container = $clicked_button.closest('.track');
			
		if( !$container.hasClass('owner') )
			return false;
					
		
		var bottle_id = parseInt( $container.attr('id').replace('bottle_','') );
		var $status = $container.find('.fa');
		var index = $status.index($clicked_button);
		var $progress = $container.find('.progress');
		
		if(index == 4)
			if(!confirm('Weet je zeker dat de fles leeg is? De fles wordt uit de tracker verwijderd en je kunt de fles toevoegen in het overzicht.'))
				return false;
		
		loader.update('updating..');
	
		var action = link.base + '/track/updateBottle/';
		
		if( index == 4 ){
			var date = new Date();
			//var datum ='0000-00-00';
		} else{
			var date ='0000-00-00';
		}	
		
		var data = {
			bottle_id : bottle_id,
			status : index,
			date : date
		};
		
		
		$.post(action, data, function(response) {
			if( Math.floor(response) == response && $.isNumeric(response) ){
				// reset classes
				$status.removeClass('last');
				$status.removeClass('active');
		
				var progress = 25;
		
				$.each($status, function(i) {
					$cur_btn = $(this);
					// make all buttons before the clicked button active
					if (i < index) {
						if (!$cur_btn.hasClass('active')) {
							$cur_btn.addClass('active');
						}
					} else {
						// clicked button
						progress = 25 * i;
						$progress.animate({
							'width' : progress + '%'
						}, 300).css('width','-=30px');
						// exit loop
						return false;
					}
				});
				
				// krijgt erg veel notifications als je deze aanzet. 
				//notifications.create(user.id,'Track & trace is geupdate);	
					
				$clicked_button.addClass('active last');
				loader.hide();
			} else{
				showAlert('error','Er is iets misgegaan tijdens het updaten van de fles. mysql geeft de volgende error:'+response);
			}
		},'json');
	}

	function save(){
		var $selected = $attendees.find('li.active');
		track.user_id = parseInt( $selected.attr('id').replace('user_','') );
		track.bottle_date = $modal.find('.bottle-date').val();
		
		track.save();
		
		closeModal();
	}
	
	})();
