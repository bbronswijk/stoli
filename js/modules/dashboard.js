var dashboard = (function() { 
	
	events.on('PageReady',getDates);
	events.on('PageReady',getUsersStats);
	
	
	function getDates(){
		
		if( !$('body').hasClass('dashboard-page') ) return false;
				
		var datums = [];
		
		for( i = 0; i <= 24; i++ ){
			datums.push(0);
		}		
		
		$.get('dashboard/getDates', function(response) {
			//alert(JSON.stringify(response));
			liters = 0;
			
			for(var i = 0; i < response.length; i++){
				liters += parseInt(response[i].size) / 100;
				// full date
				var datum = response[i].date.split(" ")[0];
				//alert('datum:'+datum);
				var month = datum.split("-")[1];
				var day = datum.split("-")[2];
				
				if(day < 15){
					datums[month * 2] += 1;
				} else{
					datums[month * 2 - 1] += 1;
				}
				
			   // CHART 1 verdeling flessen
				new Chartist.Line('.dateAdded', {
				  labels: ['Jan','' , 'Feb','' , 'Mrt','' , 'Apr','' , 'Mei','' , 'Jun','' ,'Jul','' ,'Aug','' ,'Sept','' ,'Okt','' ,'Nov','' ,'Dec','' ,''],
				  series: [
				    datums
				  ]
				}, {
					low: 0,
				  	showArea: true,
				  	showPoint: false,
				  	fullWidth: true,
				  	chartPadding: {
					    right: 40
					  }
				});
		
			}
			
			$('td.amount-liters').text(liters.toFixed(1)+' L');
			
		}, 'json');
	}
	
	// get XP users
	function getUsersStats(){
		// only run on dashboard page
		if( !$('body').hasClass('dashboard-page') ) return false;
		
		var bottles = [];
		var bottlesLabels = [];
		var xps = [];
		var xpsLabels = [];
		var trophies = [];
		var trophiesLabels = [];
		var totalBottles = 0; 
		var totalTrophies = 0; 
		
		$.get('dashboard/getUsers', function(response) {
			//alert(JSON.stringify(response));
			
			for(var i = 0; i < response.length; i++){
				var lastName = response[i].last_name;
				var bottle = response[i].bottles;
				var xp = response[i].xp;
				var trophie = response[i].trophies;
				
				if(bottle != null && bottle > 0){
					bottles.push( bottle );
					bottlesLabels.push( lastName );
					totalBottles += parseInt(bottle);
				}
				if(xp != null && xp > 0){
					xps.push( xp );
					xpsLabels.push( lastName );
				}
				if(trophie != null && trophie > 0){
					trophies.push( trophie );
					trophiesLabels.push( lastName );
				}
				
				if(response[i].most == 1){
					mostBottlesUser = lastName;
				}
				
			}
			
						
			mostXP = xps.indexOf(Math.max.apply(Math, xps).toString());
			mostXPUser = xpsLabels[mostXP];			
			
			totalUsers = response.length;
			
			$('td.amount-bottles').text(totalBottles);
			$('td.amount-users').text(totalUsers);
			$('td.most-bottles').text(mostBottlesUser);
			$('td.most-xp').text(mostXPUser);
			
			var user_level = 0;
			
			
					
			$.each(user.levels,function(i){
				if(user.levels[i]['xp'] < xps[mostXP]  ){
					user_level = user.levels[i]['level'];
				} else{
					return false;
				}
			});
			
			$('td.most-level').text('Level '+user_level);
			
			//alert('xpsLabels:'+xpsLabels+' xps:'+xps+' trophies:'+trophies);
			
			// CHART 2 VERDELING FLESSEN
			new Chartist.Pie('.divisionBottles', {
			  labels: bottlesLabels,
			  series: bottles
			}, {
			  donut: true,
			  donutWidth: 60,
			  startAngle: 0,
			  total: totalBottles,
			  labelOffset: 40 ,
			  chartPadding: 20
			});
			
				
			// CHART 3 XPS and trophies
			new Chartist.Bar('.horBarChart', {
			  labels: xpsLabels,
			  series: [
			    xps
			  ]
			}, {
			  seriesBarDistance: 10,
			  reverseData: true,
			  horizontalBars: true,
			  chartPadding: {
			    right: 40
			  },
			  axisY: {
			    offset: 70
			  }
			});
			
			// CHART 4 staafdiagram
			new Chartist.Bar('.barChart', {
			  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			  series: [
			    [5, 4, 3, 7, 5, 10, 3, 4, 8, 10, 6, 8],
			    [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4]
			  ]
			}, {
			  seriesBarDistance: 10
			});
		
			
		}, 'json');
	}
	
	
})();



