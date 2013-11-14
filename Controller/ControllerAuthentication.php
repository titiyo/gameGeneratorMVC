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

    private $lname;
    private $fname;
    private $login;
    private $email;
    private $pwd;
    private $pwdConf;

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

    public function inscription()
    {
        $this->generateView();
    }

    public function createUser()
    {
        $this->lname = $this->request->getParameter("lname");
        $this->fname = $this->request->getParameter("fname");
        $this->login = $this->request->getParameter("login");
        $this->email = $this->request->getParameter("email");
        $this->pwd = $this->request->getParameter("pwd");
        $this->pwdConf = $this->request->getParameter("pwdConf");

        if($this->pwd == $this->pwdConf )
        {
            $this->modelUser->createUser($this->lname, $this->fname, $this->login, $this->email, $this->pwd);

            $_SESSION["login"] = $this->login;
            // Redirect to Index
            $this->executeAction("Index");
        }
        else
        {
            $this->executeAction("Inscription");
        }
    }

    /**
     * Connection de l'utilisateur
     */
    public function signIn() {
        $login = $this->request->getParameter("login");
        $pwd = $this->request->getParameter("pwd");

        $user = $this->modelUser->getUser($login, $pwd);
        if($user != null)
        {
            $_SESSION["login"] = $user["login"];
            $_SESSION["group"] = $user["group"];
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

