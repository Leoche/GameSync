<?php
require("libs/Session.php");
require("libs/Auth.php");
require("libs/Router.php");
require("libs/Route.php");
require("libs/Config.php");
define("ROOT",'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", $_SERVER["PHP_SELF"]));
define("WEBROOT",ROOT."template/");

$config = Config::getInstance();
$session = Session::getInstance();
$auth = new Auth($session,$config);

$router = new Router($_GET['url']);
$router->get('', function(){
	$auth = $GLOBALS["auth"];
	$config = $GLOBALS["config"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}else require("template/index.php");
});

/* AUTH */
$router->get('logout', function(){
	$auth = $GLOBALS["auth"];
	$auth->logout();
	header("Location: ".ROOT."login");
});
$router->get('login', function(){
	$auth = $GLOBALS["auth"];
	if($auth->isConnected())
		header("Location: ".ROOT);
	else require("template/login.php");
});
$router->post('login', function(){
	$auth = $GLOBALS["auth"];
	$session = $GLOBALS["session"];
	if($auth->login($_POST["email"],$_POST["pass"])){
		$session->setFlash("info","Connexion réussie");
		header("Location: ".ROOT);
	}else $session->setFlash("info","Identifiants incorrects");
	require("template/login.php");
});

/* WHITELIST */
$router->get('/api/whitelist', function(){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$config = $GLOBALS["config"];
	echo json_encode($config->get("whitelist"));
});
$router->post('/api/whitelist/:entry', function($entry){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$config = $GLOBALS["config"];
	$newwhitelist = $config->get("whitelist");
	if(!in_array($entry, $newwhitelist)){
		$newwhitelist[] = $entry;
		$config->set("whitelist",$newwhitelist);
	} echo json_encode(array("code"=>"200"));
});
$router->post('/api/whitelist/:folder/:entry', function($folder, $entry){
	$auth = $GLOBALS["auth"];
	$entry = $folder."/".$entry;
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$config = $GLOBALS["config"];
	$newwhitelist = $config->get("whitelist");
	if(!in_array($entry, $newwhitelist)){
		$newwhitelist[] = $entry;
		$config->set("whitelist",$newwhitelist);
	} echo json_encode(array("code"=>"200"));
});
$router->delete('/api/whitelist/:entry', function($entry){
	$auth = $GLOBALS["auth"];
	$config = $GLOBALS["config"];
	$newwhitelist = Config::getInstance()->get("whitelist");
	foreach($newwhitelist as $i=>$item)
		if($item == $entry)
			array_splice($newwhitelist,$i,1);
	$config->set("whitelist",$newwhitelist);
	echo json_encode(array("code"=>"200"));
});
$router->delete('/api/whitelist/:folder/:entry', function($folder, $entry){
	$auth = $GLOBALS["auth"];
	$config = $GLOBALS["config"];
	$entry = $folder."/".$entry;
	$newwhitelist = Config::getInstance()->get("whitelist");
	foreach($newwhitelist as $i=>$item)
		if($item == $entry)
			array_splice($newwhitelist,$i,1);
	$config->set("whitelist",$newwhitelist);
	echo json_encode(array("code"=>"200"));
});

/* MODS */
$router->get('/api/mods', function(){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$files = array();
	foreach(scandir("gamefiles/mods") as $f){
		if($f != "." && $f != ".."){
			if(is_dir("gamefiles/mods/".$f)){
				foreach(scandir("gamefiles/mods/".$f) as $g)
					if($g != "." && $g != "..")
						$files[] = $f."/".$g;
			}
			else $files[] = $f;
		}
	}
	echo json_encode($files);
});
$router->delete('/api/mods/:entry', function($entry){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	if(@unlink("gamefiles/mods/".$entry)){
		echo json_encode(array("code"=>"200"));
	}
	else echo json_encode(array("code"=>"401"));
});
$router->delete('/api/mods/:folder/:entry', function($folder, $entry){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$entry = $folder."/".$entry;
	if(@unlink("gamefiles/mods/".$entry)){
		echo json_encode(array("code"=>"200"));
	}
	else echo json_encode(array("code"=>"401"));
	if(count(scandir("gamefiles/mods/".$folder)) == 2) rmdir("gamefiles/mods/".$folder);
});
$router->post("/api/mods" , function(){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$extensions = array("jar","zip","txt","json");
	if(isset($_FILES) && isset($_FILES["mod"])){
		$file = $_FILES["mod"];
		$file["name"] = strtolower($file["name"]);
		if(in_array(pathinfo($file["name"], PATHINFO_EXTENSION), $extensions)){
			if(move_uploaded_file($file["tmp_name"], "gamefiles/mods/".$file["name"]))
				echo json_encode(array("code"=>"200"));
			else 
				echo json_encode(array("code"=>"403"));
		}else echo json_encode(array("code"=>"500"));
	}else echo json_encode(array("code"=>"401"));
});

/* STATUS */
$router->get("/api/status", function(){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$config = $GLOBALS["config"];
	echo json_encode($config->get("online"));
});
$router->post("/api/status/:bool", function($bool){
	$auth = $GLOBALS["auth"];
	if(!$auth->isConnected()){
		header("Location: ".ROOT."login");
		die();
	}
	$config = $GLOBALS["config"];
	if(intval($bool) == 1) $bool = true;
	else $bool = false;
	$config->set("online",$bool);
});
$router->run();