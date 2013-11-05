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

    public function createSituation()
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
    	
    	//echo($this->situationTitle.", ".$this->situationExposition.", ".$this->situationQuestion.", ".$this->situationReponse1.", ".$this->situationNbPoint1.", ".$this->situationReponse2.", ".$this->situationNbPoint2.", ".$this->situationReponse3.", ".$this->situationNbPoint3);
    	if($this->situationType && $this->situationTitle!=null && $this->situationExposition!=null && $this->situationQuestion!=null && $this->situationReponse1!=null && $this->situationNbPoint1!=null)
    	{
    		$login = $_SESSION["login"];
    		$rootDirectory = "Content/xml/Members/".$login;
    		//$fileGameDirectory = $rootDirectory . "/" .$this->gameTitle;
    		$fileGameDirectory = $rootDirectory . "/Star Wars";
    		
    		//get game file name
    		$gameFile = scandir($fileGameDirectory,1);
    		
    		$arrayForm = array($this->situationType, $this->situationTitle, $this->situationExposition, $this->situationQuestion, $this->situationReponse1, $this->situationNbPoint1, $this->situationReponse2, $this->situationNbPoint2, $this->situationReponse3, $this->situationNbPoint3);
		
    		//add situation to the gameFile
    		$this->modelGame->addSituationInGameFile($gameFile[0], $arrayForm);
    	}
    	$this->executeAction("Index");
    }

    public function viewGame()
    {
        $gameTab=$this->modelGame->getGameList($_SESSION["login"]);
        $gameList='<div class="accordion" id="accordion2">';
        for($i=1;$i<=sizeof($gameTab);$i++)
        {
            $detailsGame = $this->modelGame->gameDetails($gameTab[($i-1)]);
            $gameList .='<div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#game'.$i.'">Jeux N°'.$i.' : '.$gameTab[($i-1)].'</a>
                            </div>
                            <div id="game'.$i.'" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <label style="font-weight:bold;">Titre du jeu : </label>'.$detailsGame["jeu"]["titre"].'<br>
                                    <label style="font-weight:bold;">Créateur : </label>'.$detailsGame["jeu"]["createur"].'<br>
                                    <label style="font-weight:bold;">Date de création : </label>'.$detailsGame["jeu"]["datecreation"].'<br>
                                    <label style="font-weight:bold;">Description du jeu : </label>'.$detailsGame["jeu"]["description"].'<br>
                                    <label style="font-weight:bold;">Difficulté du jeu : </label>'.$detailsGame["jeu"]["difficulte"].'<br>
                                    <label style="font-weight:bold;">Nombre de situation(s) : </label>'.$detailsGame["jeu"]["nbsituation"].'<br>
                                </div>
                            </div>
                        </div>';
        }
        $gameList .='</div>';

        $this->generateView(array('gameList' => $gameList));
    }
}