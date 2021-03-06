<?php

require_once 'Request.php';
require_once 'View.php';

/**
 * Classe abstraite Controleur
 * Fournit des services communs aux classes Controleur dérivées
 * 
 * @version 1.0
 * @author Baptiste Pesquet
 */
abstract class Controller {

    /** Action à réaliser */
    private $action;
    
    /** Requête entrante */
    protected $request;

    /**
     * Définit la requête entrante
     * 
     * @param $request $request Requete entrante
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Exécute l'action à réaliser.
     * Appelle la méthode portant le même nom que l'action sur l'objet Controleur courant
     * 
     * @throws Exception Si l'action n'existe pas dans la classe Controleur courante
     */
    public function executeAction($action)
    {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        }
        else {
            $classController = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $classController");
        }
    }

    /**
     * Méthode abstraite correspondant à l'action par défaut
     * Oblige les classes dérivées à implémenter cette action par défaut
     */
    public abstract function index();

    /**
     * Génère la vue associée au contrôleur courant
     * 
     * @param array $viewData Données nécessaires pour la génération de la vue
     */
    protected function generateView($viewData = array())
    {
        // Détermination du nom du fichier vue à partir du nom du contrôleur actuel
        $classController = get_class($this);
        $controller = str_replace("Controller", "", $classController);
        
        // Instanciation et génération de la vueF
        $vue = new View($this->action, $controller);
        $vue->generate($viewData);
    }
}
