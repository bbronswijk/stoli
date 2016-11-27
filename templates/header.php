<!DOCTYPE html>
<html lang="nl">
	<head>
		<meta charset="utf-8">

		<title>WiebetaaltdeStoli</title>

		<meta name="description" content="Stoli">
		<meta name="author" content="Bram Bronswijk">
		<meta name="viewport" id="viewport" content="width=device-width, user-scalable=no">

		<link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" />
		<link rel="apple-touch-icon" href="apple-touch-icon.png" />

		<!-- stylesheets -->
		<!--<link rel="stylesheet" href="https://file.myfontastic.com/7f4QfTp7u8s5odez2vphfY/icons.css">	-->	
		<link href='https://fonts.googleapis.com/css?family=Open+Sans|Montserrat:700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo URL; ?>css/main.css">
		<link rel="stylesheet" href="<?php echo URL; ?>css/queries.css">
		<link rel="stylesheet" href="<?php echo URL; ?>css/vendor.css">
		<link rel="stylesheet" href="<?php echo URL; ?>css/stoli-icons.css">	'
		
		<?php 
			if($sock = @fsockopen('www.google.com', 80)){
						echo '<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">';
			} else{
				echo '<link rel="stylesheet" href="'.URL.'css/chartist.min.css">';
			}
		?>
		<!-- GOOGLE ANALYTICS -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-61876782-3', 'auto');
		  ga('send', 'pageview');
		
		</script><script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-61876782-3', 'auto');
		  ga('send', 'pageview');

		</script>
		
		
		
	</head>
	<body class="<?php echo $this->bodyHelper->bodyClass(); ?>-page">

		