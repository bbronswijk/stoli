/**
 * @author bramb
 */
var link = (function() { 
	
	var base = window.location.origin.replace('#', '')+'/stoli';
	
	return {
		base : base
	};
})();

$(document).ready(function() {
	/* When user clicks the nav Icon */
	$(".nav-toggle").click(function(e) {
		e.preventDefault();
		$(".navicon").toggleClass("active");
		$(".nav_overlay").toggleClass("open");
		$("body").toggleClass("noscroll");
	});
	
	/* When user clicks a link */
	$(".nav_overlay ul li a").click(function() {
		$(".navicon").toggleClass("active");
		$(".nav_overlay").toggleClass("open");
	});
	
	/* When user clicks outside */
	$(".nav_overlay").click(function() {
		$(".navicon").toggleClass("active");
		$(".nav_overlay").toggleClass("open");
		$("body").toggleClass("noscroll");
	});
	
	/* set viewport for small screens */
	window.onload = function () {
	    if(screen.width <= 350) {
	        $('#viewport').attr('content','width=500');
	    }
	};
	
	// hide alerts
	$(document).on('click', '.warning', function() {
		$(this).fadeOut(300, function() {
			$(this).remove();
		});
	});
});