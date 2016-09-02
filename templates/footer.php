
<!-- JavaScript -->
<script type="text/javascript" src="<?php echo URL; ?>js/vendor.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/vendor/Chart.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/vendor/mustache.min.js?ver=12"></script>


<?php

	if($sock = @fsockopen('www.google.com', 80)){
				echo '<script type="text/javascript" src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>';
	} else{
				echo '<script type="text/javascript" src="'.URL.'js/vendor/chartist.min.js?ver=12"></script>';
	}

?>
<!-- <script type="text/javascript" src="<?php echo URL; ?>js/scripts.js"></script> --> 
<script type="text/javascript" src="<?php echo URL; ?>js/modules/pubsub.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/main.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/modal.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/header.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/ideas.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/alert.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/loader.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/user.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/bottles.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/bottle.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/bottlePopup.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/notificaties.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/notifications.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/track.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/trophies.js?ver=12"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/dashboard.js?ver=12"></script>
<script type="text/javascript" src="https://use.fontawesome.com/3f64b8f72f.js?ver=12"></script>

</body>
</html>