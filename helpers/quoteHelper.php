<?php
Class quoteHelper{
	
	public function getQuote(){
		$quotes = array(
			"Alcohol is the liquid version of Photoshop",
			"If you don't drink, how will you friends know you love them at 2 AM",
			"I cook with wine, sometimes I even add it to the food",
			"I don't have a drinking problem, except when I can't get a drink",
			"In alchohol's defense, I've done some pretty dumb shit while completely sober too",
			"I drink to make other people more interesting",
			"We're not alcoholics. We generally only drink on the weekends. Except for special occasions. And boredome. And Thursdays. Which some people consider weekends",
			"A party without alchohol is just a meeting",
			"Always keep a bottle in your fridge for special occasions. You know like Wednesdays",
			"You don't need alcohol to have fun. Well, you don't need running shoes to run, but it fucking helps.",
			"I pretend to like people everyday. It's called being an adult and that is why we are allow to buy alcohol",
			"It doens't matter if the glass is half empty, or half full. There is clearly room for more alcohol",
			"When life gives tou  lemons. Slice those suckers up and find some tequila",
			"Drinking rum before 10 AM makes you a pirate not an alcoholic",
			"I'm worried that if I give up drinking, I'll replace it with murdering",
			"I don't like the word 'alcoholic.' I like to think of myself as an advanced drinker.",
			"There are better things in the world than alcohol. But alcohol sort of compensates for not getting them.",
			"I don't remember much from last night, but the fact I need sunglasses to open the fridge this morning tells me it was awesome!",	
			"In mexico we mix tequila with bad decisions, we call it life",
			"I don't abuse alcohol, I teach it a fucking lesson",
			"The best thing about having a penis, is sharing it with people who don't",
			"It's stupid when girls say they can't find a nice guy. Yet they ignore me! It's like saying you're hungry when there's a hot dog on the ground outside!",
			"Just went over my bank account, and figured out I can live comfortably without working for the rest of my life. As long as I die on thursday.",
			"Ik wil je problemen wel voor je wegdrinken",
			"Having gay parents must be though, I mean you either get twice the usual mount of dad jokes or get stuck into an infinite loop of 'go ask your mom'",
			"When I offer to wash your back, all you have to say is yes or no. Not all this 'who are you, and how did you get in here?' nonsense",
			"Drink coffee, do stupid things faster with more energy",
			"I'm not sayin it is hot, but two hobbits just threw a ring in my backyard",
			"In my defense I was unsupervised",
			"Well.. That didn't work..",
			"Ever since I started playing online games, I lost all respect for my mom.. Apparently she had sex with countless 8 years olds",
			"Never tell a goat about your travel plans. Goats have no idea what to do with that information!",
			"Left handed people have a higher chance of finishing their exam on time than people with no hands",
			"A meal without wine, is called breakfast",
			"Should I drink today, or drink today & tomorrow?",
			"Hey, I'm really bad at portioning uncooked spaghetti, so if you and 110 of your friends wanna come over? Dinner is ready..",
			"Friends, are like snowflakes. If you pee on them, they disappear",
			"The path of inner peace begins with four words: 'not my fucking problem'"
			
		);	
	
		$select = rand(0,count($quotes) - 1 );
		return '"'.$quotes[$select].'"';
	}
}