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
require_once 'Model/ModelUser.php';

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
    private $winPoint;
    private $loosePoint;

    private $tabSituationReponse;
    private $tabSituationPoints;
<<<<<<< HEAD
    
    private $enemyCharacter;
    
=======


>>>>>>> 9004a8df32f252a407e5e2049fe5453e53be6b96
    /**
     * Constructeur
     */
    public function __construct() {
        $this->modelGame = new ModelGame();
        $this->modelUser = new ModelUser();

    }

    /**
     *  Controleur par défaut
     */
    public function index()
    {
        $situations = null;
        $characters = null;

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
            $charFilePath = "Content/xml/members/".$_SESSION["login"]."/".$this->gameTitle."/".$this->gameTitle."Characters.xml";
            if(file_exists($gameFilePath))
            {
                // Get all Situations
                $situations = $this->modelGame->getAllSituations($gameFilePath, 0);
            }
            if(file_exists($charFilePath))
            {
                // Get all Characters
                $characters = $this->modelGame->getAllCharacters($charFilePath);
            }
        }

        /*if($this->gameTitle != null)
        {
            $charFilePath = "Content/xml/members/".$_SESSION["login"]."/".$this->gameTitle."/".$this->gameTitle."Characters.xml";

            if(file_exists($charFilePath))
            {
                // Get all Characters
                $characters = $this->modelGame->getAllCharacters($charFilePath);
            }
        }*/
        $this->generateView(array('gameTitle' => $this->gameTitle,'createDate' => $this->createDate, 'situations' => $situations, 'characters' => $characters));
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
            $gameFileName = $this->modelGame->createFileGame($fileGameDirectory, $id, $this->createDate, $this->gameTitle ,$this->description, $this->difficulty, $login);

            $arrayForm = array("situationType" => "Debut", "situationTitle" => "A modifier", "situationExposition" => "A modifier",
                "situationQuestion" => "A modifier", "tabSituationReponses" => array("A modifier"), "tabSituationPoints" => array("A modifier"),
                "winPoint" => "", "loosePoint" =>"");
            
            $this->modelGame->addSituationInGameFile($gameFileName, $arrayForm);

            //Update metadata Number Of Situation
            $this->modelGame->UpdateNumberOfSituation($gameFileName);
            
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
            "1" => "Narration",
            "2" => "Combat"
        );

        $situation = array("title" => null, "code" => null, "exposition" => null, "question" => null, "answers" => array(), "points" => array());
        $maxResponse = 3;

        $characters = $this->modelGame->getCharacterByType($this->gameTitle, "E");
        
        // Return the form with data
        $this->generateView(array('types' => $types, 'maxResponse' => $maxResponse, 'gameTitle' => $this->gameTitle, 'createDate' => $this->createDate
                                  ,'situation' => $situation, 'characters' => $characters));
    }

    public function createSituations()
    {
    	//récupérer les données du form
    	$this->situationType = $this->request->getParameter("type");
    	$this->situationTitle = $this->request->getParameter("situationTitle");
    	$this->situationExposition = $this->request->getParameter("situationExposition");
        $this->tabSituationReponse = $this->request->getParameter("situationReponse");
        $this->tabSituationPoints = $this->request->getParameter("situationNbPoint");
    	$this->situationQuestion = $this->request->getParameter("situationQuestion");

    	$this->winPoint = $this->request->getParameter("winPoint");
    	$this->loosePoint = $this->request->getParameter("loosePoint");

    	$this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        
        $this->enemyCharacter = $this->request->getParameter("enemyCharacter");

    	if($this->situationType != null && $this->situationTitle != null && $this->situationExposition != null && $this->situationQuestion != null)
    	{
    		$login = $_SESSION["login"];
    		$rootDirectory = "Content/xml/Members/".$login;
    		$fileGameDirectory = $rootDirectory . "/" . $this->gameTitle. "/";
    		//get game file name
    		$gameFile = $fileGameDirectory."fileGame_".$login."_".$this->createDate.".xml";

    		$arrayForm = array("situationType" => $this->situationType, "situationTitle" => $this->situationTitle, "situationExposition" => $this->situationExposition,
                "situationQuestion" => $this->situationQuestion, "tabSituationReponses" => $this->tabSituationReponse, "tabSituationPoints" => $this->tabSituationPoints,
                "winPoints" => $this->winPoint, "loosePoints" =>$this->loosePoint, "enemyCharacter" => $this->enemyCharacter);

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
            $characters = $this->modelGame->getCharacterByType($this->gameTitle, "E");
        }

        $types = array(
            "1" => "Narration",
            "2" => "Combat",
        );

        $maxResponse = 3;

        // Return the form with data
        $this->generateView(array('types' => $types, 'maxResponse' => $maxResponse, 'gameTitle' => $this->gameTitle, 'createDate' => $this->createDate,
                                  'situation' => $situation, 'characters' => $characters));
    }

    public function editSituations()
    {
    	//récupérer les données du form
        $this->situationType = $this->request->getParameter("type");
        $this->situationTitle = $this->
        request->getParameter("situationTitle");
        $this->idSituation = $this->request->getParameter("idSituation");

        $this->situationExposition = $this->request->getParameter("situationExposition");
        $this->situationQuestion = $this->request->getParameter("situationQuestion");

        $this->tabSituationReponse = $this->request->getParameter("situationReponse");
        $this->tabSituationPoints = $this->request->getParameter("situationNbPoint");

        $this->situationMapping = $this->request->getParameter("mappingSituation");

        $this->winPoint = $this->request->getParameter("winPoint");
        $this->loosePoint = $this->request->getParameter("loosePoint");

        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        
        $this->enemyCharacter = $this->request->getParameter("enemyCharacter");
        

        if($this->situationType != null && $this->situationTitle!=null && $this->situationExposition!=null && $this->situationQuestion!=null)
        {
            $login = $_SESSION["login"];
            $rootDirectory = "Content/xml/Members/".$login;
            $fileGameDirectory = $rootDirectory . "/" . $this->gameTitle. "/";
            //get game file name
            $gameFile = $fileGameDirectory."fileGame_".$login."_".$this->createDate.".xml";

            $arrayForm = array("situationType" => $this->situationType, "situationTitle" =>$this->situationTitle,
            		"situationExposition" => $this->situationExposition, "situationQuestion" => $this->situationQuestion,
            		"tabSituationReponses" => $this->tabSituationReponse, "tabSituationPoints" => $this->tabSituationPoints ,
            		"winPoints" => $this->winPoint, "loosePoints" => $this->loosePoint,"situationMapping" => $this->situationMapping, 
            		"enemyCharacter" => $this->enemyCharacter);

            //add situation to the gameFile
            $this->modelGame->editSituationInGameFile($gameFile, $arrayForm, $this->idSituation);

        }
        $this->executeAction("Index");
    }


    public function viewGame()
    {
        $this->generateView(array('games' => $this->modelGame->getGameList($_SESSION["login"])));
    }

    public function createCharacter()
    {
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        $this->generateView(array('gameTitle' => $this->gameTitle, 'createDate' => $this->createDate));
    }

    public function createCharacters()
    {
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        $this->charName = $this->request->getParameter("charName");
        $this->charType = $this->request->getParameter("charType");
        $this->lifePoint = $this->request->getParameter("lifePoint");
        $this->defPoint = $this->request->getParameter("defPoint");
        $this->atkPoint = $this->request->getParameter("atkPoint");
        $this->escPoint = $this->request->getParameter("escPoint");
        $login = $_SESSION["login"];
        $fileGameDirectory = "Content/xml/members/".$login."/".$this->gameTitle."/";

        //$founded=false;
        $xmlFile = $fileGameDirectory.$this->gameTitle."Characters.xml";

        if(file_exists($xmlFile))
        {
            $this->modelGame->createNewCharacter($fileGameDirectory, $this->gameTitle, $this->charName, $this->charType, $this->lifePoint, $this->defPoint, $this->atkPoint, $this->escPoint);
        }
        else
        {
            $this->modelGame->createFileCharacter($fileGameDirectory, $this->gameTitle, $this->charName, $this->charType, $this->lifePoint, $this->defPoint, $this->atkPoint, $this->escPoint);
        }
        $this->executeAction("Index");
    }

    public function EditCharacter()
    {
        $this->charName = $this->request->getParameter("charName");
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        $character = $this->modelGame->getCharacterByName($this->charName, $this->gameTitle);
        $this->generateView(array('character' =>$character, 'gameTitle' => $this->gameTitle, 'createDate' => $this->createDate));
    }

    public function EditCharacters()
    {
        $this->gameTitle = $this->request->getParameter("gameTitle");
        $this->createDate = $this->request->getParameter("createDate");
        $charName =  $this->request->getParameter("charName");
        $type =  $this->request->getParameter("charType");
        $lifePoint =  $this->request->getParameter("lifePoint");
        $defPoint =   $this->request->getParameter("defPoint");
        $atkPoint =   $this->request->getParameter("atkPoint");
        $initPoint =   $this->request->getParameter("iniPoint");
        $this->modelGame->updateCharacter($this->gameTitle, $charName, $type, $lifePoint, $defPoint, $atkPoint, $initPoint);

        $this->executeAction("Index");
    }

    public function viewUserGame()
    {
        $userList=$this->modelUser->getUserList();
        $gamesList = array();
        foreach($userList as $user)
        {
            $login= $user->login;
            $fileXml = "Content/xml/members/".$login."/userGames.xml";
            if(file_exists($fileXml))
            {
                $gameFileXml = simplexml_load_file("Content/xml/members/".$login."/userGames.xml");
                foreach($gameFileXml->jeu as $item)
                {
                    array_push($gamesList,array("title" => $item, "gameDetail" => $this->modelGame->gameDetails($user->login,$item)));
                }
            }
        }
        $this->generateView(array('gamesList' =>$gamesList));
    }
}