<!-- POPUP MODULE -->
<div id="trackPopupModule">
	<div class="overlay"></div>
	<div class="modal add-bottle-survey">
		<div class="user-id"><?php echo Session::get('fb_user_id'); ?></div>
		<h1>Nieuwe Fles</h1>
		<div class="exit_popup">&times;</div>
				
		<!-- PART 1 -->
		<div class="part" id="part1">
			<div class="question">
				Van wie is de fles?
			</div>
			<ul id="choose-attendees">
				<?php foreach ($this->users as $key => $value) { ?>
					<li id="user_<?php echo $value['id']; ?>"><?php echo $value['last_name']; ?></li>
				<?php } ?>
			</ul>
			<div class="bottom">
				<button class="btn red next" id="btn1">volgende</button>
			</div>
		</div> <!-- /PART 1 -->
		
		<!-- PART 2 -->
		<div class="part" id="part2">
			<div class="questions">
				<div class="question">
					Wanneer is de fles gekocht?
				</div>
				<input type="date" class="bottle-date" value="<?php echo date('Y-m-d'); ?>"/>
				
			</div>
			<div class="bottom">
				<a href="#" id="back1" class="back-btn">terug</a>
				<button class="btn red add" id="btn2">toevoegen</button>
			</div>
		</div> <!-- /PART 2 -->
		
	</div>
</div> <!-- /POPUP MODULE -->