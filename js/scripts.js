/**
 * @author Bram
 */

$(document).ready(function() {

var bottle = (function(){
	owner = 'online-user';
	time = 'took-time';
	size = '';
	price = '';
	
	function save(){
		// save to database using ajax
	}
});
	
var bottlePopup = (function() {
	// open
	// hide
	// get users
	// get type of bottles
	// go to next question
	// save bottle in db 
	// add bottle to list
})();

$('#add-bottle').on('click',function(){
	$('#bottlesPopupModule').show();
});

$('#bottlesPopupModule .exit_popup').on('click',function(){
	$('#bottlesPopupModule').hide();
});

$('#bottlesPopupModule .overlay').on('click',function(){
	$(this).parent().hide();
});

$('#bottlesPopupModule #btn1').on('click',function(){
	$size = $('#choose-size .active').index('.owl-item');
	$('#part1').hide();
});

$('#bottlesPopupModule #back1').on('click',function(){
	$('#part1').show();
});

$('#bottlesPopupModule #btn2').on('click',function(){
	var users = [];
	
	$('#bottlesPopupModule #choose-attendees li').each(function(){
		if($(this).hasClass('active')){
			var id = $(this).attr('id').replace('user_','');
			users.push(id);
		}
	});
	
	$('#part2').hide();
});

$('#bottlesPopupModule #back2').on('click',function(){
	$('#part2').show();
});

$('#bottlesPopupModule #btn3').on('click',function(){
	$('#bottlesPopupModule').hide();
	$('#bottlesPopupModule .part').show();
});

$('#bottlesPopupModule #choose-attendees li').on('click',function(){
	$(this).toggleClass('active');
});



}); // END JQUERY	
/**
 * @author Bram
 */

$(document).ready(function() { 	

	// bottles is dependent of the user 	
	var bottles = (function() {
		// bottles is property
				
		var bottles = [
			{	owner :'Jasper Wijkhuizen',
				size : '0,7L',
				trophies : 2,
				attendees : [	
					'Pim Heemskerk',
					'Bram Bronswijk'				
				],
				date : '4 Jan 2016' },
			{	owner :'Pim Heemskerk',
				size : '1,5L',
				trophies : 4,
				attendees : [	
					'Pim Heemskerk',
					'Vincent van den Hil',
					'Bram Bronswijk',
					'Daniel Toten'				
				],
				date : '28 Dec 2015' },
			{	owner :'Bram Bronswijk',
				size : '1 L',
				trophies : 0,
				attendees : [	
					'Pim Heemskerk',
					'Vincent van den Hil',
					'Bram Bronswijk',					
					'Daniel Toten',
					'Jasper Wijkhuizen'				
				],
				date : '15 Dec 2015' },
			{	owner :'Daniel Toten',
				size : '0,7L',
				trophies : 8,
				attendees : [],
				date : '13 Dec 2015' }];
					
		var $el = $('#bottlesModule');
		var $header = $el.find('#bottle-filter');
		var $ul = $el.find('ul#bottles');
		var $bottle = $el.find('.bottle');
		var $button = $el.find('#add-bottle');
		var $bottleFilter = $el.find('#bottle-filter');
		var template = $el.find('#bottles-template').html();
		var template_header = $el.find('#bottles-header').html();
		
		bottles.filter = 'all';
		
		_getFilter();
		
		// bind events
		$button.on('click', addBottle);
		$ul.delegate('i.delete','click', deleteBottle);
		$bottleFilter.delegate('li a','click',setFilter);
		
		_render();		
		
		function _render(){	
			var queryBottles = getFilteredBottles();
					
			//$ul.html(Mustache.render(template, queryBottles));
			
			_renderHeader();
		}
		
		function _renderHeader(){			
			var dataHeader = {
				all : bottles.filter === 'all',
				present : bottles.filter === 'present',
				own : bottles.filter === 'own'
			};			
			//$header.html(Mustache.render(template_header, dataHeader));
		}
		
		function addBottle(){
			var newBottle = {
				owner : user.name, 
				size : '1L',
				trophies : 3,
				attendees : [	
					'Pim Heemskerk',
					'Bram Bronswijk',					
					'Daniel Toten',
					'Jasper Wijkhuizen'				
				],
				date : '16 Jan 2016' };
			
			// put new bottle at beginning of array	
			bottles.unshift(newBottle);	
				
			
			// render the view	
        	_render();
        	
		}
		
		function deleteBottle(event){
			// get object to remove
			var $remove = $(event.target).closest('.bottle');
			var i = $ul.find('.bottle').index($remove);
			
			// remove object from array
			bottles.splice(i,1);
			
			_render();
		}
		
		function _getFilter(){ // gets called only when the page loads 
			var route = window.location.href.split('#');
			var curFilter = route[1];
			if( typeof curFilter != 'undefined' ){
				bottles.filter = curFilter;
			} else{
				bottles.filter = 'all';
			}
		}
		
		function setFilter(event){	// when filter button is clicked	
			bottles.filter = $(event.target).data('filter');
				
			_render();
		}
		
		function getFilteredBottles(){ // supply all the necessary bottles for the render method
			var filteredBottles = [];
			
			if(bottles.filter === "own" || bottles.filter === "present"){
				// loop through orgininal array of bottles
				$.each(bottles,function(index){					
					if( user.name === this.owner ){
						var target = bottles[index];
						filteredBottles.push(target);
					}
				});
			}
			if(bottles.filter === "present"){
				// check if user is in attendees
				$.each(bottles,function(index){						
					$.each(this.attendees,function(){
						if( user.name == this){
							var target = bottles[index];
							filteredBottles.push(target);
						}
					});
				});	
			} else if(bottles.filter === "all"){
				filteredBottles = bottles;
			}
			
			// sort filtered bottles array
			filteredBottles = filteredBottles.sort(function(a, b) {
			    return new Date(b.date) - new Date(a.date);
			});
			
			return { bottles: filteredBottles};
		}
		
		// API
		return{
			create : addBottle	// bottles.create > niet alleen deze module kan een fles toevoegen TODO andere module voor add bottle
		};
		
	})();
	
	

}); // END JQUERY	
/**
 * @author bramb
 */
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
	
});
/**
 * @author bramb
 */

$(document).ready(function() { 	

	$("#choose-size").owlCarousel({
	 	singleItem : true,
	 	navigation : true,
	 	navigationText : ["",""],	 
	 	addClassActive : true,	
	 });
	  
});
/**
 * @author bramb
 */
	
	var user = (function(){
		var user = [];			
		
		user.name = 'Vincent van den Hil';
		
		return{
			name : user.name
		};
	})();
