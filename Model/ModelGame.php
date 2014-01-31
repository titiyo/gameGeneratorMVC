<?php
/**
 * Created by IntelliJ IDEA.
 * User: ty
 * Date: 25/10/13
 * Time: 22:05
 * To change this template use File | Settings | File Templates.
 */

require_once 'Framework/Model.php';

class ModelGame extends Model {

    public function __construct() {
    }

    /**
     * @param $UserGameFile
     */
    public function createUserFileGame($UserGameFile)
    {
        $stringxml = <<<XML
<?xml version = "1.0" encoding="ISO-8859-1" standalone = "no" ?>
<jeux xmlns="http://userGames.org" xsi:schemaLocation="http://userGames.org /Content/xsd/userGames.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
</jeux>
XML;

        $xml = simplexml_load_string($stringxml);
        $xml->asXml($UserGameFile);
    }
    
    public function createUserFileBestScores($UserBestScoresFile)
    {
    	$stringxml = <<<XML
<?xml version = "1.0" encoding="ISO-8859-1" standalone = "no" ?>
<scores xmlns="http://userGames.org" xsi:schemaLocation="http://userGames.org /Content/xsd/userGames.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
</scores>
XML;
    	
    	$xml = simplexml_load_string($stringxml);
    	$xml->asXml($UserBestScoresFile);
    }
    
    public function createFileSavedGames($UserSavedGamesFile)
    {
    	$stringxml = <<<XML
<?xml version = "1.0" encoding="ISO-8859-1" standalone = "no" ?>
<saves xmlns="http://userGames.org" xsi:schemaLocation="http://userGames.org /Content/xsd/userGames.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
</saves>
XML;
    	$xml = simplexml_load_string($stringxml);
    	$xml->asXml($UserSavedGamesFile);
    }

    /**
     * @param $UserGameFile
     * @param $gameTitle
     */
    public function addGameInUserFileGame($UserGameFile, $gameTitle)
    {
        $xml = simplexml_load_file($UserGameFile);
        $xml->addChild("jeu", $gameTitle);
        $xml->asXml($UserGameFile);
    }

    /**
     * @param $fileGameDirectory
     * @param $id
     * @param $createDate
     * @param $gameTitle
     * @param $description
     * @param $difficulty
     * @param $login
     * @return string
     */
    public function createFileGame($fileGameDirectory, $id, $createDate, $gameTitle, $description, $difficulty, $login)
    {
        $stringxml = <<<XML
<?xml version = "1.0" encoding="ISO-8859-1" standalone = "no" ?>
<jeu xmlns="http://game.org" xsi:schemaLocation="http://game.org /Content/xsd/game.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <id>$id</id>
    <datecreation>$createDate</datecreation>
    <nbsituation>0</nbsituation>
    <titre>$gameTitle</titre>
    <createur>$login</createur>
    <description>$description</description>
    <difficulte>$difficulty</difficulte>
</jeu>
XML;

        $xml = simplexml_load_string($stringxml);

        $fileName = $fileGameDirectory."/fileGame_".$login."_".$createDate.".xml";
        $xml->asXml($fileName);
        return $fileName;
    }

    public function createFileCharacter($gameDir, $gameTitle, $charName, $charType, $lifePoint, $defPoint, $atkPoint, $escPoint)
    {
        $stringxml = <<<XML
<?xml version = "1.0" encoding="ISO-8859-1" standalone = "no" ?>
<personnages xsi:schemaLocation="http://Characters.org /Content/xsd/Characters.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <personnage type="$charType">
        <nom>$charName</nom>
        <caracteristiques>
            <vie>$lifePoint</vie>
            <defense>$defPoint</defense>
            <attaque>$atkPoint</attaque>
            <initiative>$escPoint</initiative>
        </caracteristiques>
    </personnage>
</personnages>
XML;

        $xml = simplexml_load_string($stringxml);

        $fileName = $gameDir."/".$gameTitle."Characters.xml";
        $xml->asXml($fileName);
    }

    public function getGameList($login)
    {
        $dir = "Content/xml/members/";
        $root = scandir($dir,1);
        $foundDir=false;
        $games = array();
        foreach($root as $value)
        {
            if($login==$value)
            {
                $foundDir=true;
                break;
            }
        }
        if($foundDir)
        {
            $gameFileXml = simplexml_load_file($dir.$login."/userGames.xml");

            foreach($gameFileXml->jeu as $item)
            {
                $game = array("title" => $item, "gameDetail" => $this->gameDetails($_SESSION["login"],$item));
                array_push($games, $game);
            }
        }
        return $games;
    }

    public function getAllSituations($gameFilePath, $idSituation)
    {
        $game = simplexml_load_file($gameFilePath);
        $situations = array();

        foreach($game->situation as $item)
        {
        	if($idSituation != $item->situationCode)
        	{
        		$situation = array("type" => $item["type"], "title" => $item->situationTitle, "idSituation" => $item->situationCode);
        		array_push($situations, $situation);
        	}
        }
        return $situations;
    }

    public function gameDetails($login, $nameGame)
    {
        $gameDir ="Content/xml/members/".$login."/".$nameGame."/";

        $root = scandir($gameDir,1);
        $detailTab=null;
        foreach($root as $value)
        {
            if($value!="." && $value!="..")
            {
                if(strpos($value, "fileGame")!== false)
                {
                    $detailGame = simplexml_load_file("Content/xml/members/".$login."/".$nameGame."/".$value);

                    $pathCharacters = "Content/xml/members/".$login."/".$nameGame."/".$nameGame."Characters.xml";
                    $countChar = 0;
                    if(file_exists($pathCharacters))
                    {
                        $charGame = simplexml_load_file($pathCharacters);
                        $reqXpath = $charGame-> xpath("/personnages/personnage");
                        $countChar = count($reqXpath);
                    }

                    return array("creationDate"=> $detailGame->datecreation,
                    "title"=>$detailGame->titre,
                    "creator"=>$detailGame->createur,
                    "nbSituation"=>$detailGame->nbsituation,
                    "description"=>$detailGame->description,
                    "difficulty"=>$detailGame->difficulte,
                    "nbCharacter"=>$countChar);

                }

            }
        }
        return null;
    }

    public function situationDetails($gameFilePath, $idSituation)
    {
        $game = simplexml_load_file($gameFilePath);

        foreach($game->situation as $item)
        {
            if($item->situationCode == $idSituation)
            {
                $answer = array();
                foreach($item->question->choix->rep as $a)
                {
                    array_push($answer, $a);
                }

                $points = array();
                foreach($item->question->suivant->si->test as $b)
                {
                    array_push($points, $b->points);
                }

                $winPoint = "";
                $loosePoint = "";
                if($item->question->suivant->si->test->si->test != null)
                {
                    $winPoint = $item->question->suivant->si->test->si->test->pointsVictoire;
                    $loosePoint = $item->question->suivant->si->test->si->test[1]->pointsDefaite;
                }

                $situationsMap = $this->getAllSituations($gameFilePath, $idSituation);
                
                return array("type" => $item["type"], "title" => $item->situationTitle, "code" => $item->situationCode, "exposition" => $item->situationExposition
                    , "question" => $item->question->label, "answers" => $answer, "points" => $points, "situationsMap" => $situationsMap, "idSituation" => $idSituation,
                    "winPoint" => $winPoint, "loosePoint" => $loosePoint);
            }
        }
        return array("title" => null, "code" => null, "exposition" => null, "question" => null, "answers" => array(), "points" => array());
    }

    public function UpdateNumberOfSituation($UserGameFile)
    {
        $game = simplexml_load_file($UserGameFile);

        $game->nbsituation++;

        $game->asXml($UserGameFile);
    }

    public function editSituationInGameFile($UserGameFile, $arrayForm, $idSituation)
    {
    	$game = simplexml_load_file($UserGameFile);
        foreach($game->situation as $item)
        {
            if($item->situationCode == $idSituation)
            {
                $item["type"] = $arrayForm["situationType"];
                $item->situationTitle = $arrayForm["situationTitle"];
                $item->situationExposition = $arrayForm["situationExposition"];
                $item->question->label =  $arrayForm["situationQuestion"];
                                                
                while(count($item->question->choix->rep) > count($arrayForm["tabSituationReponses"]))
                {
                	unset($item->question->choix->rep);
                }
           
                for($i = 0; $i < count($arrayForm["tabSituationReponses"]); $i++)
                {
                	if(count($item->question->choix->rep) >= $i)
                	{
                		// Modification
                		$item->question->choix->rep[$i] = $arrayForm["tabSituationReponses"][$i];
                		
                		$attr = $item->question->choix->rep[$i]->attributes();
                		              		
                		if(count($attr)==0)
                		{
                			$item->question->choix->rep[$i]->addAttribute("val", $i);
                		}
                		
                	}
                	else 
                	{
                		//Cr�ation
             			
                		$rep = $item->question->choix->addChild("rep",$arrayForm["tabSituationReponses"][$i])->addAttribute("val", $i);
                		$rep->addAttribute("val", $i);
                   	}
                }
                
                if($arrayForm["situationType"]=="Combat")
                {
                	$item->ennemi = $arrayForm["enemyCharacter"];
                	
                    $item->question->suivant->si->test->si->test[0]->pointsVictoire = $arrayForm["winPoints"];
                    $item->question->suivant->si->test->si->test[0]->code = $arrayForm["situationMapping"][0];
                    $item->question->suivant->si->test->si->test[1]->pointsDefaite = $arrayForm["loosePoints"];
                    // code 1 => situation fin
                    $item->question->suivant->si->test->si->test[1]->code = "1";

                    $item->question->suivant->si->test[1]->code = $arrayForm["situationMapping"][1];
                }
                else
                {
                   	while(count($item->question->suivant->si->test) > count($arrayForm["tabSituationPoints"]))
                	{
                		unset($item->question->suivant->si->test);
                	}
                    //for($i=0; $i < count($arrayForm["tabSituationPoints"]); $i++)
                	for($i=0; $i < count($arrayForm["tabSituationReponses"]); $i++)
                    {
                    		// Modification
                    		$item->question->suivant->si->test[$i]->points = $arrayForm["tabSituationPoints"][$i];
                    		$item->question->suivant->si->test[$i]->code = "0";
                            if(count($arrayForm["situationMapping"]) > $i)
                            {
                                $item->question->suivant->si->test[$i]->code = $arrayForm["situationMapping"][$i];
                            }
                            
                            if(count($item->question->suivant->si->test[$i]->attributes())==0)
                            {
                            	$item->question->suivant->si->test[$i]->addAttribute("val",$i);
                            	
                            }
                            
                    	                      
                    }
                }

                $game->asXml($UserGameFile);
                return null;
            }
        }
        return null;
    }

    public function addSituationInGameFile($UserGameFile, $arrayForm)
    {
    	$xml = simplexml_load_file($UserGameFile);

    	$situation = $xml->addChild("situation");
    	$situation->addAttribute("type",$arrayForm["situationType"]);
    	$situation->addChild("situationCode", uniqid());
    	$situation->addChild("situationTitle",$arrayForm["situationTitle"]);
    	$situation->addChild("situationExposition",$arrayForm["situationExposition"]);

    	if($arrayForm["situationType"] == "Combat")
    	{
    		$situation->addChild("ennemi",$arrayForm["enemyCharacter"]);
    	}

    	$question = $situation->addChild("question");
    	$question->addChild("label", $arrayForm["situationQuestion"]);

    	$choix = $question->addChild("choix");

        for($i = 0; $i < count($arrayForm["tabSituationReponses"]) ; $i++)
        {
            $rep = $choix->addChild("rep",$arrayForm["tabSituationReponses"][$i]);
            $rep->addAttribute("val", $i);
        }

    	$suivant = $question->addChild("suivant");
    	$si = $suivant->addChild("si");

    	if($arrayForm["situationType"] == "Combat")
    	{
            $testCombat = $si->addChild("test");
            $testFuite = $si->addChild("test");


            $testCombat->addAttribute("val","0");
    		$si = $testCombat->addChild("si");
            $testCombat = $si->addChild("test");
            $testCombat->addAttribute("vieEnnemi","0");
            $testCombat->addChild("code", "0");
            $testCombat->addChild("pointsVictoire", $arrayForm["winPoints"]);
            $testCombat = $si->addChild("test");
            $testCombat->addAttribute("vieHeros","0");
            $testCombat->addChild("code", "0");
            $testCombat->addChild("pointsDefaite", $arrayForm["loosePoints"]);

            $testFuite->addAttribute("val","1");
            $testFuite->addChild("code","0");
            $testFuite->addChild("points", $arrayForm["tabSituationPoints"][0]);
        }
    	else
    	{
            for($i = 0; $i < count($arrayForm["tabSituationPoints"]) ; $i++)
            {
                $test = $si->addChild("test");
                $test->addAttribute("val",$i);

                $test->addChild("points", $arrayForm["tabSituationPoints"][$i]);
                $test->addChild("code", "0");
            }
    	}

    	$xml->asXml($UserGameFile);
    }
    
    public function getAllSituationsInGameFile($userGameFile)
    {
    	$xml = simplexml_load_file($userGameFile);
    	 
    	$result1 = $xml->xpath("/jeu/situation/situationCode");
    	$result2 = $xml->xpath("/jeu/situation/situationTitle");
    	 
    	//$tabSituationsCodeTitle=array();
    	$tabRetour=array();
    	for($i=0;$i<count($result1);$i++)
    	{
    
    	$tabSituationsCodeTitle= array("code$i" => $result1[$i], "title$i" => $result2[$i]);
    	array_push($tabRetour, $tabSituationsCodeTitle);
    
    	}
    	return $tabRetour;
    }

    function createNewCharacter($gameDir, $gameTitle, $charName, $charType, $lifePoint, $defPoint, $atkPoint, $iniPoint)
    {
        $xmlFile = simplexml_load_file($gameDir.$gameTitle."Characters.xml");
        $character = $xmlFile->addChild('personnage');
        $character->addAttribute('type', $charType);
        $character->addChild('nom', $charName);

        $characteristic= $character->addChild('caracteristiques');
        $characteristic->addChild('vie', $lifePoint);
        $characteristic->addChild('defense', $defPoint);
        $characteristic->addChild('attaque', $atkPoint);
        $characteristic->addChild('initiative', $iniPoint);
        $xmlFile->asXML($gameDir.$gameTitle."Characters.xml");
        

        $dom = dom_import_simplexml($xmlFile)->ownerDocument;
        $dom->formatOutput = true;
        $dom->saveXML();
    }

    function getAllCharacters($charFilePath)
    {
        $char = simplexml_load_file($charFilePath);
        $characters = array();

        foreach($char->personnage as $item)
        {
            //echo  $item->nom." ".(string)$item->attributes()->type." ".$item->caracteristiques->vie." ".$item->caracteristiques->defense." ".$item->caracteristiques->attaque." ".$item->caracteristiques->initiative."<br>";
            $character = array("nom" => $item->nom,
                                "type" => (string)$item->attributes()->type,
                                "vie" => $item->caracteristiques->vie,
                                "defense" => $item->caracteristiques->defense,
                                "attaque" => $item->caracteristiques->attaque,
                                "initiative" => $item->caracteristiques->initiative);
            array_push($characters, $character);
        }
        return $characters;
    }

    public function getCharacterByName($charName, $gameTitle)
    {
        $xmlFile = simplexml_load_file("Content/xml/members/".$_SESSION["login"]."/".$gameTitle."/".$gameTitle."Characters.xml");
        $char = $xmlFile->xpath("personnage[nom='$charName']");
        //$typeChar = $char[0]->xpath("@type");
        $typeChar = $char[0]->xpath("@type");

        return array("nom"=> $charName,
            "type" => $typeChar[0],
            "vie" => $char[0]->caracteristiques->vie,
            "defense" => $char[0]->caracteristiques->defense,
            "attaque" => $char[0]->caracteristiques->attaque,
            "initiative" => $char[0]->caracteristiques->initiative);
    }

    public function updateCharacter($gameTitle, $charName, $typeChar, $lifePoint, $defPoint, $atkPoint, $iniPoint)
    {
        $xmlFile = simplexml_load_file("Content/xml/members/".$_SESSION["login"]."/".$gameTitle."/".$gameTitle."Characters.xml");
        //$charFounded = $xmlFile->xpath("personnage[nom='$charName']");

        foreach($xmlFile->personnage as $char)
        {
             if($char->nom==$charName)
             {
                $char[0]["type"]=$typeChar;
                $char->caracteristiques->vie=$lifePoint;
                $char->caracteristiques->defense=$defPoint;
                $char->caracteristiques->attaque=$atkPoint;
                $char->caracteristiques->initiative=$iniPoint;
             }
        }
        $xmlFile->asXml("Content/xml/members/".$_SESSION["login"]."/".$gameTitle."/".$gameTitle."Characters.xml");
    }
    
    public function getCharacterByType($characterFilePath,$characterType)
    {
    	$xmlFile = simplexml_load_file($characterFilePath);
    	//$characters = $xmlFile->xpath("personnage[@type='".$characterType."']");
    	$tabCharacters = array();
    	foreach($xmlFile->personnage as $character)
    	{
            if($character["type"] == 'E')
            {
                $characterTab = array("name" => $character->nom);
                array_push($tabCharacters, $characterTab);
            }
    	}
    	return $tabCharacters;
    }
    
}