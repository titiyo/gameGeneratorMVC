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
    private $gameTitle;
    private $description;
    private $owner;
    private $difficulty;
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
        $this->generateView(array('gameTitle' => $this->gameTitle));
    }

    public function createGame()
    {
        // Return the form with empty data
        $this->generateView(array('gameTitle' => null, 'description' => null,
            'owner' => null, 'difficulty' => null));
    }

    public function createGameFile()
    {
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->description = $this->request->getParameter("description");
        $this->owner = $this->request->getParameter("owner");
        $this->difficulty = $this->request->getParameter("difficulty");

        if($this->gameTitle != null && $this->description != null && $this->owner != null && $this->difficulty != null)
        {
            /***************************************************************************
            *                    Create File Game
            **************************************************************************/
            $login = $_SESSION["login"];
            setlocale(LC_TIME, 'fra_fra');
            $createDate = strftime('%d%m%Y');
            $id = uniqid();

            $rootDirectory = "Content/xml/Members/".$login;
            $fileGameDirectory = $rootDirectory . "/" .$this->gameTitle;

            // Create the userGame directory if not existing and move in this directory
            if(!file_exists($rootDirectory))
            {
                // Create the directory
                mkdir($rootDirectory, 0777);
            }
            // Create Game Directory and move in this directory
            if(!file_exists($fileGameDirectory))
            {
                // Create the directory
                mkdir($fileGameDirectory, 0777);
            }

            // Create the game
            $this->modelGame->createFileGame($fileGameDirectory, $id, $createDate, $this->gameTitle ,$this->description, $this->owner, $this->difficulty, $login);

            /***************************************************************************
             *                    Create User Games
             **************************************************************************/
            $UserGameFile = $rootDirectory . "/userGames.xml";

            if(!file_exists($UserGameFile))
            {
                // Create File User Game
                $this->modelGame->createUserFileGame($UserGameFile);
            }
            //Add game
            $this->modelGame->addGameInUserFileGame($UserGameFile, $this->gameTitle);

            // Redirect to the game panel
            $this->executeAction("Index");
        }
        else
        {
            // Return the form with data
            $this->generateView(array('gameTitle' => $this->gameTitle, 'description' => $this->description,
                                'owner' => $this->owner, 'difficulty' => $this->difficulty));
        }
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