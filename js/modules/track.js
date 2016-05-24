/**
 * @author bramb
 */
var track = (function(){
	
	// elements
	$track = $('#track');
	$buttons = $track.find('.fa');
	$progress = $track.find('.progress');
	
	
	// bind dom events
	$buttons.on('click',updateStatus);
		
	

	function updateStatus() {
		var $clicked_button = $(this);
		var index = $buttons.index($clicked_button);
	
		// reset classes
		$buttons.removeClass('last');
		$buttons.removeClass('active');

		var progress = 25;

		$.each($buttons, function(i) {
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

		$clicked_button.addClass('active last');

	}

	
	})();
