// THE MODAL 
var bottlePopup = (function() {

	var $addBtn = $('#add-bottle');
	var $modal = $('#bottlesPopupModule');
	var $overlay = $modal.find('.overlay');
	var $exit = $modal.find('.exit_popup');
	var $attendees = $modal.find('#choose-attendees');
	var $nextBtn = $modal.find('button.next');
	var $prevBtn = $modal.find('a.back-btn');
	var $saveBtn = $modal.find('button.add');

	// bind events
	$addBtn.on('click', openModal);
	$overlay.on('click', closeModal);
	$exit.on('click', closeModal);
	$attendees.on('click', 'li', togglePresence);
	$nextBtn.on('click', nextQuestion);
	$prevBtn.on('click', previousQuestion);
	$saveBtn.on('click', save);

	function openModal() {
		$modal.show();
		$overlay.show();
		$modal.find('.modal').show();
	}

	function closeModal() {
		$('.part').show();
		$attendees.find('li').removeClass('active');
		modal.close();
	}

	function togglePresence() {
		$(this).toggleClass('active');
	}

	function nextQuestion() {
		$id = $(this).attr('id').replace(/[^\d]/g, '');
		$('#part' + $id).hide();
	}

	function previousQuestion() {
		$id = $(this).attr('id').replace(/[^\d]/g, '');
		$('#part' + $id).show();
	}

	function save() {
		loader.update('gathering the data...');
		bottle.user_id = $modal.find('.user-id').text();
		bottle.size  = $modal.find('#choose-size .active').index('.owl-item');

		var users = [];
		$('#bottlesPopupModule #choose-attendees li').each(function() {
			if ($(this).hasClass('active')) {
				var id = $(this).attr('id').replace('user_', '');
				users.push(id);
			}
		});
		
		loader.update('creating bottle object...');
		bottle.users = users;

		bottle.date = $modal.find('input.bottle-date').val() + ' ' + $modal.find('input.bottle-time').val();
		bottle.duration = $modal.find('input.bottle-duration:checked').val();
		bottle.price = $modal.find('input.bottle-price').val();
		
		bottle.save();
		
		closeModal();
	}

})();


