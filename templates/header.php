<!doctype html>
<html lang="nl">
	<head>
		<meta charset="utf-8">

		<title>WiebetaaltdeStoli</title>

		<meta name="description" content="Stoli">
		<meta name="author" content="Bram Bronswijk">
		<meta name="viewport" id="viewport" content="width=device-width, user-scalable=no">

		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="apple-touch-icon" href="apple-touch-icon.png" />

		<!-- stylesheets -->
		<!--<link rel="stylesheet" href="https://file.myfontastic.com/7f4QfTp7u8s5odez2vphfY/icons.css">	-->	
		<link rel="stylesheet" href="<?php echo URL; ?>css/main.css">
		<link rel="stylesheet" href="<?php echo URL; ?>css/queries.css">
		<link rel="stylesheet" href="<?php echo URL; ?>css/vendor.css">
		<link rel="stylesheet" href="<?php echo URL; ?>css/stoli-icons.css">	
		<?php 
			if($sock = @fsockopen('www.google.com', 80)){
						echo '<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">';
			} else{
				echo '<link rel="stylesheet" href="'.URL.'css/chartist.min.css">';
			}
		?>
		
	</head>
	<body class="<?php echo $this->bodyHelper->bodyClass(); ?>-page">

		