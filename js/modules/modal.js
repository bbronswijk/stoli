// THE MODAL 
var modal = (function() {

	var $modal = $('.modal');
	var $overlay = $('.overlay');
	var $exit = $modal.find('.exit_popup');
	var $closeBtn = $modal.find('button.close-modal');

	// bind events
	$overlay.on('click', close);
	$exit.on('click', close);
	$closeBtn.on('click', close);


	function close() {
		$modal.hide();
		$overlay.hide();
	}

	return{
		close : close
	};
})();


