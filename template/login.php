<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LSync</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?= WEBROOT ?>css/style.min.css">
</head>
<body>
	<div id="background"></div>
	<div id="main">
		<div id="logo">LSYNC</div>
		<div id="content">
		<form action="login" method="POST" action="">
			<label for="email">Adresse Email</label><br/>
			<input type="text" id="email" name="email" />
			<div class="spacer"></div>
			<label for="pass">Mot de passe</label><br/>
			<input type="password" id="pass" name="pass" />
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<div class="spacer"></div>
			<input type="submit" value="Connexion">
		</form>
		</div>
	</div>
	<script src="<?= WEBROOT ?>js/jQuery.js"></script>
	<script src="<?= WEBROOT ?>js/main.js"></script>
	<?php $session = $GLOBALS["session"]; if($session->hasFlashes()): $flashes = $session->getFlashes(); ?>
	<script>
		jQuery(function($){
			humane.log("<?= $flashes["info"] ?>");
		});
	</script>
	<?php endif; ?>
</body>
</html>