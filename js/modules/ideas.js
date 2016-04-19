/**
 * @author bramb
 */
	
var ideas = (function(){		
	
	var	$ideas = $('#ideas');
	var $form = $ideas.find('form');
	var $inputIdea = $ideas.find('.idea-input');
	var $addIdea = $ideas.find('.btn');
	var $target = $('.loading .load-description');
	
	// bind events
	$addIdea.on('click',addIdea);
	$form.on('submit',addIdea);
	
	function addIdea(e){
		e.preventDefault();
		
		var data = {
			last_name : user.last_name,
			description: $inputIdea.val()
		};
				
		var action = link.base + '/ideas/insertIdea/';
		
		$.post(action, data, function(response) {
			
			if( response == 1){
				location.reload();
			}
			 
		},'json');
	}
	

})();
