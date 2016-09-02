<?php $user = $this->userdata[0]; ?>
<?php $stats = $this->userstats[0]; ?>
<div class="online-user">
	<span class="first-name"><?php echo $user['first_name']; ?> </span><span class="last-name"><?php echo $user['last_name']; ?></span>
	<div class="online-user-container">
		<h1>Profiel</h1>
		<div id="user-id"><?php echo Session::get('fb_user_id'); //$user['id']; ?></div>
		<div class="profile-img">
			<?php 
				// check if connected to internet			
				if(!$sock = @fsockopen('www.google.com', 80)){
					echo '<img src="'.URL.'img/profile.png" alt="profile"/>';
					
				} else{
					echo '<img src="'.$user['picture'].'" alt="profile"/>';
				}
			?>
		</div>		
		<div class="statistics">
			<div class="number-bottles">
				<?php echo $this->numBottles; ?>
			</div>
			<div class="bottle-trophies">
				<?php echo $stats['trophies']; ?>
			</div>
		</div>
		<div class="user-name">
			<a href="<?php echo URL; ?>deelnemers/trophies/<?php echo $user['id']; ?>"><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></a>
		</div>
		<div class="user-level">
			<p class="level" id="xp"><?php echo ( $stats['tax'] == 1 )? $stats['xp']/2 :  $stats['xp']; ?> XP</p><p class="level" id="level">Sober</p>
		</div>
		
		<a href="#" class="logout">uitloggen</a>
	</div>
</div>