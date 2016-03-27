<h1 class="page-title">Trophies</h1>

<?php 
$completed = array(); 

foreach ($this->userTrophies as $key => $value) {
	$completed[] = $value['trophy_id'];
}


?>


<ul id="trophies" class="items">
	<?php foreach ($this->trophies as $key => $value) { ?>
		<?php 
		$class = '';
		
		if( in_array($value['id'], $completed) ){
			$class = 'complete';
		}
		
		?>
		<li class="item trophy <?php echo $class ?>">
			<img src="<?php echo URL; ?>img/achievements/<?php echo $value['img']; ?>.svg" alt="badge"/>
			<p class="description"><?php echo $value['description'] ?></p>
			<p class="xp"><?php echo $value['xp']; ?> XP</p>
		</li>
	<?php } ?>
</ul>