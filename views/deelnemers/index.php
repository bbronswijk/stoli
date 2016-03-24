<h1 class="page-title">Deelnemers</h1>

<ul id="users" class="items">
	<?php
	foreach ($this->users as $key => $value) {
		echo '<li class="item user" id="user_' . $value['id'] . '">';	
		echo '<div class="profile-picture">';		
			if($sock = @fsockopen('www.google.com', 80)){
				echo '<img src="'.$value['picture'].'" alt="profile"/>';
			} else{
				echo '<img src="'.URL.'img/profile.png" alt="profile"/>';
			}
		echo '</div>';
		echo '<div class="owner">' . $value['first_name'] . ' ' . $value['last_name'] . '</div>';
		echo '</li>';

	}
?>
</ul>