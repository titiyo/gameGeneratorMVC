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

    private $createDate;
    private $modelGame;
    private $gameTitle;
    private $description;
    private $difficulty;
    private $idSituation;
    
    private $situationType;
    private $situationTitle;
    private $situationExposition;
    private $situationQuestion;
    private $situationReponse1;
    private $situationNbPoint1;
    private $situationReponse2;
    private $situationNbPoint2;
    private $situationReponse3;
    private $situationNbPoint3;
    private $winPoint;
    private $loosePoint;
    
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
        $situations = null;

        if($this->request->existParameter("gameTitle"))
        {
            $this->gameTitle = $this->request->getParameter("gameTitle");
        }
        if($this->request->existParameter("createDate"))
        {
            $this->createDate = $this->request->getParameter("createDate");
        }
        if($this->gameTitle != null && $this->createDate != null)
        {
            $gameFilePath = "Content/xml/members/".$_SESSION["login"]."/".$this->gameTitle."/fileGame_".$_SESSION["login"]."_".$this->createDate.".xml";

            if(file_exists($gameFilePath))
            {
                // Get all Caracters

                // Get all Situations
                $situations = $this->modelGame->getAllSituations($gameFilePath);
            }
        }

        $this->generateView(array('gameTitle' => $this->gameTitle,'createDate' => $this->createDate, 'situations' => $situations));
    }

    public function createGame()
    {
        $difficultyList = array(
            "1" => "*",
            "2" => "**",
            "3" => "***",
            "4" => "****",
            "5" => "*****"
        );

        // Return the form with empty data
        $this->generateView(array('gameTitle' => null, 'description' => null, 'difficultyList' => $difficultyList));
    }

    public function createGameFile()
    {
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->description = $this->request->getParameter("description");
        $this->difficulty = $this->request->getParameter("difficulty");

        if($this->gameTitle != null && $this->description != null && $this->difficulty != null)
        {
            /***************************************************************************
            *                    Create File Game
            **************************************************************************/
            $login = $_SESSION["login"];
            setlocale(LC_TIME, 'fra_fra');
            $this->createDate = strftime('%d%m%Y');
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
            $this->modelGame->createFileGame($fileGameDirectory, $id, $this->createDate, $this->gameTitle ,$this->description, $this->difficulty, $login);

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
            $this->executeAction("createGame");
        }
    }

    public function createSituation()
    {
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");

    	$types = array(
            "1" => "Début",
            "2" => "Fin",
            "3" => "Combat",
            "4" => "Narration"
        );

        $situation = array("title" => null, "code" => null, "exposition" => null, "question" => null, "answers" => array(), "points" => array());

        $maxResponse = 3;

        // Return the form with data
        $this->generateView(array('types' => $types, 'maxResponse' => $maxResponse, 'gameTitle' => $this->gameTitle, 'createDate' => $this->createDate
                                  ,'situation' => $situation));
    }

    public function createSituations()
    {
    	//récupérer les données du form
    	$this->situationType = $this->request->getParameter("type");
    	$this->situationTitle = $this->request->getParameter("situationTitle");
    	$this->situationExposition = $this->request->getParameter("situationExposition");
    	$this->situationQuestion = $this->request->getParameter("situationQuestion");
    	$this->situationReponse1 = $this->request->getParameter("situationReponse1");
    	$this->situationNbPoint1 = $this->request->getParameter("situationNbPoint1");
    	$this->situationReponse2 = $this->request->getParameter("situationReponse2");
    	$this->situationNbPoint2 = $this->request->getParameter("situationNbPoint2");
    	$this->situationReponse3 = $this->request->getParameter("situationReponse3");
    	$this->situationNbPoint3 = $this->request->getParameter("situationNbPoint3");

    	$this->winPoint = $this->request->getParameter("winPoint");
    	$this->loosePoint = $this->request->getParameter("loosePoint");

    	$this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");

    	if($this->situationType && $this->situationTitle!=null && $this->situationExposition!=null && $this->situationQuestion!=null && $this->situationReponse1!=null && $this->situationNbPoint1!=null)
    	{
    		$login = $_SESSION["login"];
    		$rootDirectory = "Content/xml/Members/".$login;
    		$fileGameDirectory = $rootDirectory . "/" . $this->gameTitle. "/";
    		//get game file name
    		$gameFile = $fileGameDirectory."fileGame_".$login."_".$this->createDate.".xml";

    		$arrayForm = array($this->situationType, $this->situationTitle, $this->situationExposition, $this->situationQuestion, $this->situationReponse1, $this->situationNbPoint1, $this->situationReponse2, $this->situationNbPoint2, $this->situationReponse3, $this->situationNbPoint3, $this->winPoint, $this->loosePoint);

    		//add situation to the gameFile
    		$this->modelGame->addSituationInGameFile($gameFile, $arrayForm);

            //Update metadata Number Of Situation
            $this->modelGame->UpdateNumberOfSituation($gameFile);
    	}
    	$this->executeAction("Index");
    }

    public function editSituation()
    {
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        $this->idSituation = $this->request->getParameter("idSituation");

        $login = $_SESSION["login"];
        //get game file name
        $rootDirectory = "Content/xml/Members/".$login;
        $fileGameDirectory = $rootDirectory . "/" . $this->gameTitle. "/";
        $gameFile = $fileGameDirectory."fileGame_".$login."_".$this->createDate.".xml";

        $situation = null;
        if(file_exists($gameFile))
        {
            $situation = $this->modelGame->situationDetails($gameFile ,$this->idSituation);
        }

        $types = array(
            "1" => "Début",
            "2" => "Fin",
            "3" => "Combat",
            "4" => "Narration"
        );

        $maxResponse = 3;

        // Return the form with data
        $this->generateView(array('types' => $types, 'maxResponse' => $maxResponse, 'gameTitle' => $this->gameTitle, 'createDate' => $this->createDate,
                                  'situation' => $situation, 'idSituation' => $this->idSituation));
    }

    public function editSituations()
    {
        //récupérer les données du form
        $this->situationType = $this->request->getParameter("type");
        $this->situationTitle = $this->request->getParameter("situationTitle");
        $this->situationExposition = $this->request->getParameter("situationExposition");
        $this->situationQuestion = $this->request->getParameter("situationQuestion");
        $this->situationReponse0 = $this->request->getParameter("situationReponse0");
        $this->situationNbPoint0 = $this->request->getParameter("situationNbPoint0");
        echo($this->situationReponse0." / ".$this->situationNbPoint0."<br/>");
        $this->situationReponse1 = $this->request->getParameter("situationReponse1");
        $this->situationNbPoint1 = $this->request->getParameter("situationNbPoint1");
        echo($this->situationReponse1." / ".$this->situationNbPoint1."<br/>");
        $this->situationReponse2 = $this->request->getParameter("situationReponse2");
        $this->situationNbPoint2 = $this->request->getParameter("situationNbPoint2");
        echo($this->situationReponse2." / ".$this->situationNbPoint2."<br/>");

        $this->winPoint = $this->request->getParameter("winPoint");
        $this->loosePoint = $this->request->getParameter("loosePoint");

        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        $this->idSituation = $this->request->getParameter("idSituation");

        if($this->situationType && $this->situationTitle!=null && $this->situationExposition!=null && $this->situationQuestion!=null && $this->situationReponse1!=null && $this->situationNbPoint1!=null)
        {
            $login = $_SESSION["login"];
            $rootDirectory = "Content/xml/Members/".$login;
            $fileGameDirectory = $rootDirectory . "/" . $this->gameTitle. "/";
            $gameFile = $fileGameDirectory."fileGame_".$login."_".$this->createDate.".xml";

            $arrayForm = array("type" => $this->situationType, "title" => $this->situationTitle, "exposition" => $this->situationExposition,
                "question" => $this->situationQuestion, "answer0" => $this->situationReponse1, "nbPoint0" => $this->situationNbPoint1,
                "answer1" => $this->situationReponse2, "nbPoint1" => $this->situationNbPoint2, "answer2" => $this->situationReponse3,
                "nbPoint2" => $this->situationNbPoint3, "winPoint" => $this->winPoint, "loosePoint" => $this->loosePoint);

            //add situation to the gameFile
            $this->modelGame->editSituationInGameFile($gameFile, $arrayForm, $this->idSituation);
        }
        $this->executeAction("Index");
    }

    public function viewGame()
    {
        $this->generateView(array('games' => $this->modelGame->getGameList($_SESSION["login"])));
    }
}