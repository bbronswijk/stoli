<h1 class="page-title">Notificaties</h1>

<div class="notificaties">
	<ul class="list-notificaties">
		<?php
		foreach ($this->notificaties as $key => $value) {
			
			if($sock = @fsockopen('www.google.com', 80)){
				$userImg = $value['picture'];
			} else{
				$userImg = URL.'img/profile.png';
			}
			
			echo '<li id="notification_' . $value['id'] . '">';
				echo '<div class="profile-img" style="background-image:url('.$userImg.');">';
		
					
		
				echo '</div>';
				echo '<strong>' . $value['last_name'] . ' </strong>';
				echo $value['message'];
				//$date = explode("-", $value['date']);
				//echo '<div class="date">'.$date[2].'-'.$date[1].'-'.$date[0].'</div>';
				echo '<div class="date">'.$value['date'].'</div>';
			echo '</li>';
		}
		?>
	</ul>
	
	<button id="load-btn" class="btn red add">laad meer</button>
</div>