<nav>
	<ul id="nav_menu">		
		<li class="<?php echo $this->menuHelper->activeClass('dashboard'); ?>">
			<a href="<?php echo URL; ?>dashboard">dashboard</a>
		</li>
		<li class="<?php echo $this->menuHelper->activeClass('bottles'); ?>">
			<a href="<?php echo URL; ?>bottles"><span class="icon-bottle-empty"></span>Overzicht</a>
		</li>
		<li class="<?php echo $this->menuHelper->activeClass('deelnemers'); ?>">
			<a href="<?php echo URL; ?>deelnemers">deelnemers</a>
		</li>
		<li class="<?php echo $this->menuHelper->activeClass('trophies'); ?>">
			<a href="<?php echo URL; ?>trophies">trophies</a>
		</li>
		<li class="<?php echo $this->menuHelper->activeClass('ideas'); ?>">
			<a href="<?php echo URL; ?>ideas">ideeën box</a>
		</li>	
		<li class="<?php echo $this->menuHelper->activeClass('track'); ?>">
			<a href="<?php echo URL; ?>#">track & trace</a>
		</li>		
	</ul>
</nav>