<?php

require_once 'Model/ModelUser.php';
require_once 'Framework/Controller.php';
/**
 * Contrôleur des actions liées aux billets
 *
 * @author Baptiste Pesquet
 */
class ControllerAuthentication extends Controller {
    private $modelUser;

    /**
     * Constructeur
     */
    public function __construct() {
        $this->modelUser = new ModelUser();
    }

    /**
     *  Controleur par défaut
     */
    public function index() {
        // On redirige le visiteur vers la page d'accueil
        header ('location: ../index.php');
    }

    /**
     * Connection de l'utilisateur
     */
    public function signIn() {
        $login = $this->request->getParameter("login");
        $pwd = $this->request->getParameter("pwd");

        if($this->modelUser->isExit($login, $pwd))
        {
            $_SESSION["login"] = $login;
        }

        // On redirige le visiteur vers la page d'accueil
        header ('location: ../Index.php');
    }

    /**
     * Déconnection de l'utilisateur
     */
    public function logout()
    {
        // On détruit les variables de notre session
        session_unset();
        // On détruit notre session
        session_destroy();
        // On redirige le visiteur vers la page d'accueil
        header ('location: ../Index.php');
    }
}

