<div class="panel">

	<!-- SIDEBAR -->
	<div class="sidebar">
		<a href="<?php echo URL; ?>"> <img class="nav_logo" src="<?php echo URL; ?>img/stoli_logo_beta.png" alt="logo"/> </a>
		<?php $this->renderTemplate('templates/nav'); ?>
		<p class="copyright">
			wiebetaaltdestolli.nl &copy; 2016
		</p>
	</div>

	<!-- TOP BAR -->
	<div class="top_bar">
		
		<?php $this->get('user',true); ?>
		
		<?php $this->get('notifications',true); ?>
		
		<div class="loading"><i class="fa fa-circle-o-notch fa-spin"></i><span class="load-description"></span></div>
		
	</div>

	<div class="content">
		<div class="alert-container"></div>
