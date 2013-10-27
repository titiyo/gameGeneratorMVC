<?php
/**
 * Created by IntelliJ IDEA.
 * User: ty
 * Date: 26/10/13
 * Time: 18:38
 * To change this template use File | Settings | File Templates.
 */
require_once 'Framework/Controller.php';
require_once 'Model/ModelGame.php';

class ControllerGame extends Controller {

    private $modelGame;
    /**
     * Constructeur
     */
    public function __construct() {
        $this->modelGame = new ModelGame();
    }

    /**
     *  Controleur par défaut
     */
    public function index() {
    }

    public function createGame()
    {
        $gameTitle = $this->request->existParameter("gameTitle") ? $this->request->getParameter("gameTitle") : null;
        $description = $this->request->existParameter("description") ? $this->request->getParameter("description") : null;
        $owner = $this->request->existParameter("owner") ? $this->request->getParameter("owner") : null;
        $difficulty = $this->request->existParameter("difficulty") ? $this->request->getParameter("difficulty") : null;


        if($gameTitle != null && $description != null && $owner != null && $difficulty != null)
        {
            // Create the game
            $this->modelGame->createGame($gameTitle ,$description, $owner, $difficulty);
            // Redirect to the game panel
            $this->executeAction("index");
            // header ('location: ../Index.php');
        }

        // Return the form with data
        $this->generateView(array('gameTitle' => $gameTitle, 'description' => $description,
                                'owner' => $owner, 'difficulty' => $difficulty));

    }

    public function CreateSituation()
    {
        $types = array(
            "1" => "Début",
            "2" => "Fin",
            "3" => "Combat",
            "4" => "Narration"
        );

        $maxResponse = 4;

        // Return the form with data
        $this->generateView(array('types' => $types, 'maxResponse' => $maxResponse));
    }
}