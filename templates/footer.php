
<!-- JavaScript -->
<script type="text/javascript" src="<?php echo URL; ?>js/vendor.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/vendor/mustache.min.js"></script>


<?php 
	if($sock = @fsockopen('www.google.com', 80)){
				echo '<script type="text/javascript" src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>';
	} else{
				echo '<script type="text/javascript" src="'.URL.'js/vendor/chartist.min.js"></script>';
	}
?>
<!-- <script type="text/javascript" src="<?php echo URL; ?>js/scripts.js"></script> --> 
<script type="text/javascript" src="<?php echo URL; ?>js/modules/pubsub.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/main.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/modal.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/header.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/ideas.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/alert.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/loader.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/user.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/bottles.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/bottle.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/bottlePopup.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/notificaties.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/notifications.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/track.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/trophies.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/modules/dashboard.js"></script>

</body>
</html>