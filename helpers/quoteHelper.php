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
			"I don't lie the word 'alcoholic.' I like to think of myself as an advanced drinker.",
			"There are better things in the world than alcohol. But alcohol sort of compensates for not getting them.",
			"I don't remember much from last night, but the fact I need sunglasses to open the fridge this morning tells me it was awesome!",	
			"In mexico we mix tequila with bad decisions, we call it life"		
		);	
	
		$select = rand(0,count($quotes) - 1 );
		return '"'.$quotes[$select].'"';
	}
}