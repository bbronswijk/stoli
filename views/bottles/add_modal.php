<!-- POPUP MODULE -->
<div id="bottlesPopupModule">
	<div class="overlay"></div>
	<div class="modal add-bottle-survey">
		<div class="user-id"><?php echo Session::get('fb_user_id'); ?></div>
		<h1>Nieuwe Fles</h1>
		<div class="exit_popup">&times;</div>
		
		<!-- PART 1 -->
		<div class="part" id="part1">
			<div class="question">
				Kies type fles
			</div>
			<div id="choose-size" class="owl-carousel">
				<div id="small">
					<img src="img/bottle.svg" alt="stoli" />
					<div class="bottle-size">
						0,7 L
					</div>
				</div>
				<div id="medium">
					<img src="img/bottle.svg" alt="stoli" />
					<div class="bottle-size">
						1 L
					</div>
				</div>
				<div id="large">
					<img src="img/bottle-icon.png" alt="stoli" />
					<div class="bottle-size">
						1,5 L
					</div>
				</div>
			</div>
			<div class="bottom">
				<button class="btn red next" id="btn1">volgende</button>
			</div>			
		</div> <!-- /PART 1 -->
		
		<!-- PART 2 -->
		<div class="part" id="part2">
			<div class="question">
				Wie waren er bij?
			</div>
			<ul id="choose-attendees">
				<?php foreach ($this->users as $key => $value) { ?>
					<li id="user_<?php echo $value['id']; ?>"><?php echo $value['last_name']; ?></li>
				<?php } ?>
			</ul>
			<div class="bottom">
				<a href="#" id="back1" class="back-btn">terug</a>
				<button class="btn red next" id="btn2">volgende</button>
			</div>
		</div> <!-- /PART 2 -->
		
		<!-- PART 3 -->
		<div class="part" id="part3">
			<div class="questions">
				<div class="question">
					Hoe laat was de fles op?
				</div>
				
				<input type="date" class="bottle-date" value="<?php echo date('Y-m-d'); ?>"/>
				<input type="time" class="bottle-time" step="1" value="<?php echo date('H:i:s'); ?>"/>
				<hr>
				<div class="question">
					Hoe snel was de fles op?
				</div>
				<ul class="time-bottle">
					<li>
						<label for="30">< 30min</label><input class="bottle-duration" type="radio" name="time" id="30" value="30">
					</li>
					<li>
						<label for="60">< 1u</label><input class="bottle-duration" type="radio" name="time" id="60" value="60">
					</li>
					<li>
						<label for="120">< 2u</label><input class="bottle-duration" type="radio" name="time" id="120" value="120" checked>
					</li>
					<li>
						<label for="240">< 4u</label><input class="bottle-duration" type="radio" name="time" id="240" value="240">
					</li>
					<li>
						<label for="500">> 1 dag</label><input class="bottle-duration" type="radio" name="time" id="480" value="480">
					</li>
				</ul>
				<hr>
				<div class="question">
					prijs fles
				</div>
				<label for="price">&euro;</label>
				<input type="number" class="bottle-price" step="0.50" id="price" max="100" value="27.00"/>
			</div>
			<div class="bottom">
				<a href="#" id="back2" class="back-btn">terug</a>
				<button class="btn red add" id="btn3">toevoegen</button>
			</div>
		</div> <!-- /PART 3 -->
		
	</div>
</div> <!-- /POPUP MODULE -->