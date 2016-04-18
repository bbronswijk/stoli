<h1 class="page-title">Notificaties</h1>

<div class="notificaties">
	<ul class="list-notificaties">
		<?php
		foreach ($this->notificaties as $key => $value) {
			echo '<li id="notification_' . $value['id'] . '">';
				echo '<div class="profile-img">';
		
					// check if connected to internet
					if (!$sock = @fsockopen('www.google.com', 80)) {
						echo '<img src="' . URL . 'img/profile.png" alt="profile"/>';		
					} else {
						echo '<img src="' . $value['picture'] . '" alt="profile"/>';
					}
		
				echo '</div>';
				echo '<strong>' . $value['last_name'] . ' </strong>';
				echo $value['message'];
			echo '</li>';
		}
		?>
	</ul>
	
	<button id="load-btn" class="btn red add">laad meer</button>
</div>