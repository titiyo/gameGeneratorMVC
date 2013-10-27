<?php

require_once 'Framework/Controller.php';

class ControllerHome extends Controller {

    public function __construct() {

    }

    // Affiche la liste de tous les billets du blog
    public function Index() {
        $this->generateView();
    }
}

