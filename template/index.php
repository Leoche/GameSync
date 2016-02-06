<?php 
$server = new Server(SERVER_URI, SERVER_PORT);
$stats = Stats::retrieve($server);
 ?>
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
	<div id="main" class="opened">
		<div id="logo"></div>
		<div id="content">
			<div id="status" class="<?=($stats->is_online)?"online":"offline" ?>">
				<div class="title"><?=($stats->is_online)?"ONLINE":"OFFLINE" ?></div>
				<div class="subtitle"><?=($stats->is_online)?$stats->online_players."/".$stats->max_players." JOUEURS":"" ?></div>
			</div>
			<div id="menu">
				<a data-tab="pane-1" class="active">Status</a>
				<a data-tab="pane-2">Whitelist</a>
				<a data-tab="pane-3">Mods</a>
				<a data-tab="pane-4">Infos</a>
			</div>
			<div id="panes">
				<div id="pane-1" class="pane">
						 <div id="line1" class="line"></div>
						  <div id="line2" class="line"></div>
						  <div id="line3" class="line"></div>
					<div class="padded">
						<div class="spacer"></div>
						<h1 class="hero">LSync est en ligne</h1>
						<a href="" class="button" id="maintenance">Activer la maintenance</a>
					</div>
				</div>
				<div id="pane-2" class="pane">
					<ul>
						<li>mods/Optifine.jar<a href=""><i class="fa fa-times"></i></a></li>
						<li>launcher.settings<a href=""><i class="fa fa-times"></i></a></li>
						<li>options.txt<a href=""><i class="fa fa-times"></i></a></li>
						<li>server.dat<a href=""><i class="fa fa-times"></i></a></li>
					</ul>
					<div class="botbar">
						<form action="" class="form-group">
							<input type="text" name="whitelist" id="whitelist" placeholder="mods/Optifine.jar"/>
							<input type="submit" value="+">
						</form>
						<a href="" id="refresh-mods" class="button square pull-right"><i class="fa fa-refresh"></i></a>
					</div>
				</div>
				<div id="pane-3" class="pane">
					<ul>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>Chisel.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>furniture.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>Flansmod.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>Chisel.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>furniture.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>Flansmod.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>Chisel.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>furniture.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>Flansmod.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
						<li>LegacyJavaFixer.zip<a href=""><i class="fa fa-times"></i></a></li>
					</ul>
					<div class="botbar">
						<form action="" name="upload">
							<label for="mod" class="button pull-left">Uploader un mod</label>
							<input type="file" name="mod" id="mod" />
						</form>
						<a href="" id="refresh-mods" class="button square pull-right"><i class="fa fa-refresh"></i></a>
					</div>
				</div>
				<div id="pane-4" class="pane">
					<div class="padded">
						<h1>Ttile</h1>
						<p>"God bless ye," he seemed to half sob and half shout. "God bless ye, men. Steward! go draw the great measure of grog. But what's this long face about, Mr. Starbuck; wilt thou not chase the white whale? art not game for Moby Dick?"</p>
					</div>
				</div>
			</div>
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