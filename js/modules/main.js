/**
 * @author bramb
 */

$(document).ready(function() { 	
	
	events.emit('PageReady');
	
	$(".owl-carousel").owlCarousel({
	 	singleItem : true,
	 	navigation : true,
	 	navigationText : ["",""],	 
	 	addClassActive : true,	
	 });
	  
});