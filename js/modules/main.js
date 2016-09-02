// get largest property value
	
// get smallest property value
function compareValue(object,property){		
	var index_min = 0;
	var index_max = 0;
	var min_property = null;
	var max_property = null;
	
	$.each(object,function(i){
		if( typeof object[i][property] != 'undefined' ){			
			if( i == 0 ){
				min_property = object[i][property];
				max_property = object[i][property];
			}
										
			if( object[i][property] <  min_property ){
				min_property = object[i][property];
				index_min = i;
			}
			
			if( object[i][property] >  max_property ){
				max_property = object[i][property];
				index_max = i;
			}
		}
	});
	
	return [index_min, min_property, index_max, max_property];
}
 

$(document).ready(function() { 	
	
	events.emit('PageReady');
	
	$(".owl-carousel").owlCarousel({
	 	singleItem : true,
	 	navigation : true,
	 	navigationText : ["",""],	 
	 	addClassActive : true,	
	 });
	  
});