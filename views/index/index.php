<h1 class="page-title">index</h1>
<?php

session_start();

$fb = fb-init;

$accessToken = $_SESSION['fb_access_token'];

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();

echo  $user['id'];

?>
<ul id="bottles">
<?php
	foreach($this->bottles as $key => $value){
		echo '<li class="bottle" id="bottle_'.$value['id'].'">';
			echo '<i class="fa fa-times delete"></i>';
			echo '<div class="bottle-size">'.$value['size'].' L</div>';
			echo '<img src="'.URL.'img/bottle_icon.png" alt="stoli" />';
			echo '<div class="bottle-trophies">4</div>';
			echo '<div class="bottle-people"><div class="owner">'.$value['first_name'].' '.$value['last_name'].'</div>';
			echo '<div>en 2 anderen </div><ul class="bottle-attendees">';			
				$attendees = explode(',',$this->attendees[$value['id'] - 1]['attendees']);	
				foreach( $attendees as $attendee){
					echo '<li class="attendee">'.$attendee.'</li>';
				}
			echo '</ul></div><div class="bottle-date">'.date_format(date_create($value['date']),'j M Y').'</div>';
		echo '</li>';
		
	}

?>
</ul>