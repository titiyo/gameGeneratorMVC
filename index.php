<?php

// Contrôleur frontal : instancie un routeur pour traiter la requête entrante

require 'Framework/Router.php';

session_start();

$router = new Router();
$router->routeRequest();


