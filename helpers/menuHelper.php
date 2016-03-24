<?php

Class menuHelper{
	
	public function activeClass($url){
		if($this->controller === $url){
			return 'current-item';
		}
		
		
	}
}
