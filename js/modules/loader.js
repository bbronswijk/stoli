/**
 * @author bramb
 */
	
var loader = (function(){		
	
	var	$loader = $('.loading');
	var $target = $('.loading .load-description');
	
	// update number of bottles 
	function updateLoader(text){
		$loader.show();
		$target.text(text);
		
		return; 
	}
	
	// update xp 
	function hideLoader(amount){
		$loader.hide();
		$target.text('');
		
		return; 
	}
	
	return {
		update : updateLoader,
		hide : hideLoader
	};

})();
