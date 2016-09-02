<h1 class="page-title">Deelnemers</h1>
<p>Klik op een deelnemer om zijn trophies te bekijken.</p>
<ul id="users" class="items" style="margin-top: 15px;">
	<?php
	
	$levels = array(
					0 		=> 'sober',
					100 	=> 'tipsy',
					300 	=> 'horny',
					600		=> 'reckless',
					1000 	=> 'drunk',
					1500 	=> 'hammered',
					2100 	=> 'trainwreck',
					2800 	=> 'wasted',
					3600 	=> 'black out',
					4500 	=> 'coma',
					5500 	=> 'probably dead'
				);
	
	foreach ($this->users as $key => $value) {
		
		$userXP = $value['xp'];
		
		$userLevel =  $levels[0];

		foreach( $levels as $xp => $level ){
			if( $userXP >= $xp ){
				$userLevel = $level;
			}
		}
		echo '<a href="'.URL.'deelnemers/trophies/'.$value['id'].'">';
		echo '<li class="item user" id="user_' . $value['id'] . '">';	
			echo '<div class="profile-picture">';		
				if($sock = @fsockopen('www.google.com', 80)){
					echo '<img src="http://graph.facebook.com/'.$value['id'].'/picture?type=large" alt="profile"/>';
				} else{
					echo '<img src="'.URL.'img/profile.png" alt="profile"/>';
				}
			echo '</div>';
			echo '<div class="bottles"> ';
				if(!empty($value['bottles'])){
					echo '<div class="number-bottles"><span class="icon-bottle-empty"></span> '.$value['bottles'].'</div>';
				} else{
					echo '<div class="number-bottles"><span class="icon-bottle-empty"></span> 0</div>';
				}
			
				
				if(!empty($value['trophies'])){
					echo '<div class="number-trophies"><i class="fa fa-trophy"></i> '.$value['trophies'].'</div>';
				} else{
					echo '<div class="number-trophies"><i class="fa fa-trophy"></i> 0</div>';
				}
			echo '</div>';
			echo '<div class="owner">' . $value['first_name'] . ' ' . $value['last_name'] . '</div>';
			if(!empty($value['xp'])){
				echo '<div class="stats"><p>'.$value['xp'].' XP</p><p>'.$userLevel.'<p></div>'; 
			} else{
				echo '<div class="stats"><p>0 xp</p><p>'.$userLevel.'</p></div>'; 	
			}
		echo '</li>';
		echo '</a>';
	}
?>
</ul>