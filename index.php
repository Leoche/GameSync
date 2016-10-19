<?php
$time_start = microtime();
require("libs/Session.php");
require("libs/Auth.php");
require("libs/Router.php");
require("libs/Route.php");
require("libs/Config.php");
define("ROOT", '//' . $_SERVER['HTTP_HOST'] . str_replace("index.php", "", $_SERVER["PHP_SELF"]));
define("WEBROOT", ROOT . "template/");

$config = new Config();
$session = new Session();
$auth = new Auth($session, $config);
$router = new Router($_GET['url']);

$router->get('', function () use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    } else require("template/index.php");
});

/* AUTH */
$router->get('logout', function () use ($auth, $config, $session) {
    $auth->logout();
    header("Location: " . ROOT . "login");
});
$router->get('login', function () use ($auth, $config, $session) {
    if (!$config->isInitialized())
        header("Location: " . ROOT . "install");
    if ($auth->isConnected())
        header("Location: " . ROOT);
    else require("template/login.php");
});
$router->post('login', function () use ($auth, $config, $session) {
    if ($auth->login($_POST["email"], $_POST["pass"])) {
        $session->setFlash("info", "Connexion réussie");
        header("Location: " . ROOT);
    } else $session->setFlash("info", "Identifiants incorrects");
    require("template/login.php");
});
$router->get('install', function () use ($auth, $config, $session) {
    if ($config->isInitialized()) {
        header("Location: " . ROOT);
        die();
    }
    require("template/install.php");
});
$router->post('install', function () use ($auth, $config, $session) {
    if ($config->isInitialized()) {
        header("Location: " . ROOT);
        die();
    }
    if (isset($_POST) && isset($_POST["email"]) && isset($_POST["pass"]) && $_POST["email"] != "" && $_POST["pass"] != "") {
        if (strlen($_POST["pass"]) > 3) {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                if ($config->init($_POST["email"], $_POST["pass"])) {
                    $session->setFlash("info", "Installation réussie");
                    header("Location: " . ROOT);
                    die();
                }
            } else $session->setFlash("info", "Votre adresse email est invalide");
        } else $session->setFlash("info", "Votre mot de passe est trop court");
    } else $session->setFlash("info", "Veuillez remplir tous les champs");
    require("template/install.php");
});

/* WHITELIST */
$router->get('/api/whitelist', function () use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    echo json_encode($config->get("whitelist"));
});
$router->post('/api/whitelist/:entry', function ($entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $newwhitelist = $config->get("whitelist");
    if (!in_array($entry, $newwhitelist)) {
        $newwhitelist[] = $entry;
        $config->set("whitelist", $newwhitelist);
    }
    echo json_encode(array("code" => "200"));
});
$router->post('/api/whitelist/:folder/:entry', function ($folder, $entry) use ($auth, $config, $session) {
    $entry = $folder . "/" . $entry;
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $newwhitelist = $config->get("whitelist");
    if (!in_array($entry, $newwhitelist)) {
        $newwhitelist[] = $entry;
        $config->set("whitelist", $newwhitelist);
    }
    echo json_encode(array("code" => "200"));
});
$router->post('/api/whitelist/:folder/:subfolder/:entry', function ($folder, $subfolder, $entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $entry = $folder . "/" . $subfolder . "/" . $entry;
    $newwhitelist = $config->get("whitelist");
    if (!in_array($entry, $newwhitelist)) {
        $newwhitelist[] = $entry;
        $config->set("whitelist", $newwhitelist);
    }
    echo json_encode(array("code" => "200"));
});
$router->delete('/api/whitelist/:entry', function ($entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $newwhitelist = $config->get("whitelist");
    foreach ($newwhitelist as $i => $item)
        if ($item == $entry)
            array_splice($newwhitelist, $i, 1);
    $config->set("whitelist", $newwhitelist);
    echo json_encode(array("code" => "200"));
});
$router->delete('/api/whitelist/:folder/:entry', function ($folder, $entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $entry = $folder . "/" . $entry;
    $newwhitelist = $config->get("whitelist");
    foreach ($newwhitelist as $i => $item)
        if ($item == $entry)
            array_splice($newwhitelist, $i, 1);
    $config->set("whitelist", $newwhitelist);
    echo json_encode(array("code" => "200"));
});
$router->delete('/api/whitelist/:folder/:subfolder/:entry', function ($folder, $subfolder, $entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $entry = $folder . "/" . $subfolder . "/" . $entry;
    $newwhitelist = $config->get("whitelist");
    foreach ($newwhitelist as $i => $item)
        if ($item == $entry)
            array_splice($newwhitelist, $i, 1);
    $config->set("whitelist", $newwhitelist);
    echo json_encode(array("code" => "200"));
});

/* MODS */
$router->get('/api/mods', function () use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $files = array();
    foreach (scandir("gamefiles/mods") as $f) {
        if ($f != "." && $f != "..") {
            if (is_dir("gamefiles/mods/" . $f)) {
                foreach (scandir("gamefiles/mods/" . $f) as $g)
                    if ($g != "." && $g != "..")
                        $files[] = $f . "/" . $g;
            } else $files[] = $f;
        }
    }
    echo json_encode($files);
});
$router->delete('/api/mods/:entry', function ($entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    if (@unlink("gamefiles/mods/" . $entry)) {
        echo json_encode(array("code" => "200"));
    } else echo json_encode(array("code" => "401"));
});
$router->delete('/api/mods/:folder/:entry', function ($folder, $entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $entry = $folder . "/" . $entry;
    if (@unlink("gamefiles/mods/" . $entry)) {
        echo json_encode(array("code" => "200"));
    } else echo json_encode(array("code" => "401"));
    if (count(scandir("gamefiles/mods/" . $folder)) == 2) rmdir("gamefiles/mods/" . $folder);
});
$router->delete('/api/mods/:folder/:subfolder/:entry', function ($folder, $subfolder, $entry) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $entry = $folder . "/" . $subfolder . "/" . $entry;
    if (@unlink("gamefiles/mods/" . $entry)) {
        echo json_encode(array("code" => "200"));
    } else echo json_encode(array("code" => "401"));
    if (count(scandir("gamefiles/mods/" . $folder)) == 2) rmdir("gamefiles/mods/" . $folder);
});
$router->post("/api/mods", function () use ($auth) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    $extensions = array("jar", "zip", "txt", "json");
    if (isset($_FILES) && isset($_FILES["mod"])) {
        $file = $_FILES["mod"];
        $file["name"] = strtolower($file["name"]);
        if (in_array(pathinfo($file["name"], PATHINFO_EXTENSION), $extensions)) {
            if (move_uploaded_file($file["tmp_name"], "gamefiles/mods/" . $file["name"]))
                echo json_encode(array("code" => "200"));
            else
                echo json_encode(array("code" => "403"));
        } else echo json_encode(array("code" => "500"));
    } else echo json_encode(array("code" => "401"));
});

/* STATUS */
$router->get("/api/status", function () use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    echo json_encode($config->get("online"));
});
$router->post("/api/status/:bool", function ($bool) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    if (intval($bool) == 1) $bool = true;
    else $bool = false;
    $config->set("online", $bool);
    echo json_encode(array("code" => "200"));
    die();
});

/* MISC */
$router->post("/api/changepassword/:newpass/:newpass2", function ($newpass, $newpass2) use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    if($newpass != $newpass2) die(json_encode(array("code" => "600", "message" => "Ces mot de passes ne correspondent pas!")));
    if(strlen($newpass) < 6) die(json_encode(array("code" => "600", "message" => "Votre nouveau mot de passe est trop court! (<7 caractères)")));
    $config->changePassword($newpass);
    echo json_encode(array("code" => "200"));
    die();
});


$router->get("/api/status", function () use ($auth, $config, $session) {
    if (!$auth->isConnected()) {
        header("Location: " . ROOT . "login");
        die();
    }
    echo json_encode($config->get("online"));
});
$router->get("/api/retrieve", function () use ($auth, $config, $session) {
    if (!function_exists('getallheaders')) {
        function getallheaders(){ 
            $headers = ''; 
            foreach ($_SERVER as $name => $value) 
                if (substr($name, 0, 5) == 'HTTP_') 
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            return $headers; 
        } 
    }
    $headers = getallheaders();
    if (!isset($headers["GameSync-Id"]) || $headers["GameSync-Id"] != $config->get("id")) die(json_encode(array("code" => "401")));
    function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = $dir . DIRECTORY_SEPARATOR . $value;
            if (!is_dir($path)) {
                $results[] = array(
                    "name" => str_replace("gamefiles\\", "", str_replace("gamefiles/", "", $path)),
                    "size" => filesize($path),
                    "md5" => md5_file($path)
                );
            } else if ($value != "." && $value != "..") {
                getDirContents($path, $results);
            }
        }

        return $results;
    }

    $time = microtime() - $GLOBALS["time_start"];
    $infos = array(
        "online" => $config->get("online"),
        "whitelist" => $config->get("whitelist"),
        "infos" => getDirContents('gamefiles'),
        "exec_time" => $time
    );
    echo json_encode($infos);
});
$router->run();
