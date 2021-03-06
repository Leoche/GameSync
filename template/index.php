<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GameSync</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= WEBROOT ?>css/style.min.css">
    <link rel="icon" type="image/png" href="<?= WEBROOT ?>/imgs/favicon.png"/>
</head>
<body>
<div id="background"></div>
<div id="main" class="opened">
    <div id="logo"></div>
    <div id="content">
        <a href="logout" id="logout" class="button">Logout <i class="fa fa-power-off" style="font-size: 12px;"></i></a>
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
                    <h1 class="hero">GameSync est en ligne</h1>
                    <div class="button" id="maintenance">Activer la maintenance</div>
                </div>
            </div>
            <div id="pane-2" class="pane">
                <ul id="white-list">
                </ul>
                <div class="botbar">
                    <form action="" class="form-group">
                        <input type="text" name="whitelist" id="whitelist" placeholder="mods/Optifine.jar"/>
                        <input type="submit" value="+" id="add-whitelist">
                    </form>
                    <a href="" id="refresh-whitelists" class="button square pull-right"><i
                            class="fa fa-refresh"></i></a>
                </div>
            </div>
            <div id="pane-3" class="pane">
                <ul id="mod-list">
                </ul>
                <div class="botbar">
                    <form action="" name="upload" id="upload">
                        <label for="mod" id="modupload-label" class="button pull-left">Uploader un mod</label>
                        <input type="file" name="mod" id="mod"/>
                    </form>
                    <a href="" id="refresh-mods" class="button square pull-right"><i class="fa fa-refresh"></i></a>
                </div>
            </div>
            <div id="pane-4" class="pane">
                <div id="infos" class="padded">
                    <h1>GameSync</h1>
                    <p>GameSync est un outil de déploiement multiplateforme permettant une syncronisation sécurisé entre
                        un logiciel client et un serveur mère.</p>
                    <p>Le coté serveur de GameSync est Open Source et disponible sur <a
                            href="https://github.com/Leoche/GameSync" target="_blank">Github</a> à tous le monde sous
                        license <a href="https://opensource.org/licenses/mit-license.php" target="_blank">MIT</a>.</p>
                    <p>Contact: <a href="http://leoche.org/" target="_blank">Leoche</a></p>
                    <div class="changepassword button">Changer le mot de passe</div>
                    <p style="text-align: center;">
                        <small>License Id: <?= $config->get("id"); ?></small>
                    </p>
                    <p style="text-align: center;">
                        <script async src="<?= WEBROOT ?>js/paypal.js?merchant=leode.sigaux@gmail.com"
                                data-button="donate"
                                data-currency="EUR"
                                data-style="secondary"
                                data-type="form"
                                data-callback=""
                                data-name="Donation"
                        ></script>
                    </p>
                </div>
                <div id="passwordchanger" class="padded">
                    <h1>Mot de passe GameSync</h1>
                    <form action="" id="passwordchanger-form">
                        <label for="pass1" id="pass1-label">Nouveau Mot de passe</label>
                        <input type="password" name="pass1" placeholder="••••" id="pass1"/>
                        <div class="spacer"></div>
                        <label for="pass2" id="pass1-label">Confirmation du Mot de passe</label>
                        <input type="password" name="pass2" placeholder="••••" id="pass2"/>
                        <div class="spacer"></div>
                        <div class="spacer"></div>
                        <div class="changepassword button pull-left">Annuler</div>
                        <input type="submit"  class="pull-right" value="Sauvegarder" id="add-whitelist">
                        <div class="clear"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= WEBROOT ?>js/libs.js"></script>
<script src="<?= WEBROOT ?>js/main.js"></script>
<?php
if ($session->hasFlashes()): $flashes = $session->getFlashes(); ?>
    <script>
        jQuery(function ($) {
            humane.log("<?= $flashes["info"] ?>");
        });
    </script>
<?php endif; ?>
</body>
</html>