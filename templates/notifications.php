<?php //$notifications = $this -> notifications[0]; ?>
<div class="notifications">
	<div class="notification-icon <?php echo ( $this->new != 0)? '': 'empty';  ?>">
		
		<?php if( $this->new == 0){ echo '<a href="'.URL.'notificaties">'; } ?>
		<i class="fa fa-bell-o"></i>
		<?php
			if( $this->new > 0){
				echo '<div class="counter">';
					echo $this->new; 
				echo '</div>';
			} else{
				echo '</a>';
			}		
		?>		
	</div>
	
	<?php if( $this->new > 0): ?>
	<div class="notifications-container">
		<h1>Notifications</h1>
		<ul> <?php
			foreach ($this->notifications as $key => $value) {
				
				if($sock = @fsockopen('www.google.com', 80)){
					$userImg = $value['picture'];
				} else{
					$userImg = URL.'img/profile.png';
				}
								
				echo '<li id="notification_'.$value['id'].'">';
					echo '<div class="profile-img" style="background-image:url('.$userImg.');">';
						
							
					echo '</div>';
					echo '<strong>'.$value['last_name'].' </strong>';
					echo $value['message'];
					//$date = explode("-", $value['date']);
					//echo '<div class="date">'.$date[2].'-'.$date[1].'-'.$date[0].'</div>';
					echo '<div class="date">'.$value['date'].'</div>';
				echo '</li>';
			}	?>
		</ul>
		<a href="<?php echo URL; ?>notificaties">alles bekijken</a>
	</div>
	<?php endif; ?>
</div>