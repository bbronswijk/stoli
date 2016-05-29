
<h1 class="page-title">Trophy | <?php foreach ($this->trophy as $key => $value) { echo $value['img']; } ?></h1>

<ul id="trophy-users" class="items">

<?php foreach ($this->trophy as $key => $value) { ?>
			<li class="item trophy complete">
				<img src="<?php echo URL; ?>img/achievements/<?php echo $value['img']; ?>.svg" alt="badge"/>
			</li>
	<?php } ?>
		
		<?php
	
	
	
	foreach ($this->users as $key => $value) {
				
		echo '<li class="item user" id="user_' . $value['id'] . '">';	
			echo '<div class="profile-picture">';	
					echo '<img src="'.URL.'img/achievements/1-fles.svg" alt="badge"/>';	
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