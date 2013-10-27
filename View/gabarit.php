<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?= $title ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <base href="<?= $rootWeb ?>" >

        <!-- Le styles -->
        <link href="<?= $rootWeb?>/Content/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link href="<?= $rootWeb?>/Content/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= $rootWeb?>/Content/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= $rootWeb?>/Content/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= $rootWeb?>/Content/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= $rootWeb?>/Content/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?= $rootWeb?>/Content/ico/favicon.png">
    </head>
    <body>
    <div id="global">
        <header>
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="brand" href="#">Game generator</a>
                        <div class="nav-collapse collapse">
                            <ul class="nav">
                                <li class="active"><a href="#">Acceuil</a></li>
                            </ul>
                            <ul class="nav">
                                <li class="active"><a href="#">Catalogue</a></li>
                            </ul>
                            <ul class="nav">
                                <li class="active"><a href="game/createGame">Créer un jeu</a></li>
                            </ul>
                            <ul class="nav">
                                <li class="active"><a href="#">Voir mes jeux</a></li>
                            </ul>
                            <?php
                            if (!isset($_SESSION["login"]))
                            {
                                ?>
                                <form method="post" class="navbar-form pull-right" action="Authentication/signIn">
                                    <input class="span2" id="login" name="login" type="text">
                                    <input class="span2" id="pwd" name="pwd" type="password" >
                                    <button type="submit" class="btn">Connexion</button>
                                </form>
                            <?php
                            }
                            else
                            {
                                echo "<form method='post' class='navbar-form pull-right' action='Authentication/logout'>";
                                echo "<label style='color:white;float:right;'>Bienvenue ".$_SESSION["login"]."</label>";
                                echo "<button type='submit' class='btn'>Deconnexion</button>";
                                echo "</form>";
                            }
                            ?>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>
        </header>
        <div id="contenu">
            <?= $content ?>
        </div> <!-- #contenu -->
        <hr>
        <footer>
            <center>&copy; ESGI 2013 - BARRETO Christophe	BONDEAU Yohann	BRETON Julien</center>
        </footer>
    </div> <!-- #global -->
    <!-- Le javascript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?= $rootWeb?>/Content/js/bootstrap.js"></script>
    <script src="<?= $rootWeb?>/Content/js/bootstrap.min.js"></script>
    </body>
</html>