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
<?xml version='1.0'?>
<jeux>
</jeux>
XML;

        $xml = simplexml_load_string($stringxml);
        $xml->asXml($UserGameFile);
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
     */
    public function createFileGame($fileGameDirectory, $id, $createDate, $gameTitle, $description, $difficulty, $login)
    {
        $stringxml = <<<XML
<?xml version='1.0'?>
<jeu>
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
    }

    public function createFileCharacter($gameDir, $gameTitle, $charName, $charType, $lifePoint, $defPoint, $atkPoint, $escPoint)
    {
        $stringxml = <<<XML
<?xml version='1.0'?>
<personnages>
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
                $game = array("title" => $item, "gameDetail" => $this->gameDetails($item));
                array_push($games, $game);
            }
        }
        //print_r($games);
        return $games;
    }

    public function getAllSituations($gameFilePath)
    {
        $game = simplexml_load_file($gameFilePath);
        $situations = array();

        foreach($game->situation as $item)
        {
            $situation = array("type" => $item["type"], "title" => $item->situationTitle, "idSituation" => $item->situationCode);
            array_push($situations, $situation);
        }
        return $situations;
    }

    public function gameDetails($nameGame)
    {
        $gameDir ="Content/xml/members/".$_SESSION["login"]."/".$nameGame."/";
        //echo $gameDir."<br>";
        $root = scandir($gameDir,1);
        $detailTab=null;
        foreach($root as $value)
        {
            if($value!="." && $value!="..")
            {
                if(strpos($value, "fileGame")!== false)
                {
                    $detailGame = simplexml_load_file("Content/xml/members/".$_SESSION["login"]."/".$nameGame."/".$value);
                    $charGame = simplexml_load_file("Content/xml/members/".$_SESSION["login"]."/".$nameGame."/".$nameGame."Characters.xml");
                    $reqXpath = $charGame-> xpath("/personnages/personnage");
                    $countChar = count($reqXpath);

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
        //return null;
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

                return array("type" => $item["type"], "title" => $item->situationTitle, "code" => $item->situationCode, "exposition" => $item->situationExposition
                    , "question" => $item->question->label, "answers" => $answer, "points" => $points);
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
        	print_r($item);
            if($item->situationCode == $idSituation)
            {
                $item["type"] = $arrayForm["type"];
                $item->situationTitle = $arrayForm["title"];
                $item->situationExposition = $arrayForm["exposition"];
                $item->question->label =  $arrayForm["question"];

                for($i=0; $i < count($item->question->suivant->si->test); $i++)
                {
                    //$item->question->suivant->si->test[$i] = $arrayForm["answer".$i];
                	$item->question->choix->rep[$i] = $arrayForm["answer".$i];
                }

                if($arrayForm["type"]=="Combat")
                {
                    $item->question->suivant->si->test->si->test[0]->pointsVictoire = $arrayForm["winPoint"];
                    $item->question->suivant->si->test->si->test[1]->pointsDefaite = $arrayForm["loosePoint"];
                }
                else
                {
                	//reprendre ici
                    for($i=0; $i < count($item->question->suivant->si->test); $i++)
                    {
                        $item->question->suivant->si->test[$i]->points = $arrayForm["nbPoint".$i];
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
    	$situation->addAttribute("type",$arrayForm[0]);
    	$situation->addChild("situationCode", uniqid());
    	$situation->addChild("situationTitle",$arrayForm[1]);
    	$situation->addChild("situationExposition",$arrayForm[2]);

    	if($arrayForm[0]=="Combat")
    	{
    		$situation->addChild("ennemi",0);
    	}

    	$question = $situation->addChild("question");
    	$question->addChild("label", $arrayForm[3]);
    	$choix = $question->addChild("choix");
    	$rep = $choix->addChild("rep",$arrayForm[4]);
    	$rep->addAttribute("val", "1");

    	$rep = $choix->addChild("rep",$arrayForm[6]);
    	$rep->addAttribute("val", "2");

    	$rep = $choix->addChild("rep",$arrayForm[8]);
    	$rep->addAttribute("val","3");

    	$suivant = $question->addChild("suivant");
    	$si = $suivant->addChild("si");
    	$test = $si->addChild("test");
    	$test->addAttribute("val","1");

    	if($arrayForm[0]=="Combat")
    	{
    		$si = $test->addChild("si");
    		$test = $si->addChild("test");
    		$test->addAttribute("vieEnnemi","0");
    		$test->addChild("code", "0");
    		$test->addChild("pointsVictoire", $arrayForm[10]);
    		$test = $si->addChild("test");
    		$test->addAttribute("vieHeros","0");
    		$test->addChild("code", "0");
    		$test->addChild("pointsDefaite", $arrayForm[11]);
    		$test = $si->addChild("test");
    		$test->addChild("code", "0");
    	}
    	else
    	{
    		$points = $test->addChild("points", $arrayForm[5]);
    		$code = $test->addChild("code", "0");
    		$test = $si->addChild("test");
    		$test->addAttribute("val","2");
    		$points = $test->addChild("points", $arrayForm[7]);
    		$code = $test->addChild("code", "0");

    		$test = $si->addChild("test");
    		$test->addAttribute("val","3");
    		$points = $test->addChild("points", $arrayForm[9]);
    		$code = $test->addChild("code", "0");
    	}

    	$xml->asXml($UserGameFile);
    	//$xml->asXml("Content/xml/Members/jbreton/Star Wars/fileGame_jbreton_05112013.xml");
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
        $typeChar = $char[0]->xpath("@type");

        return array("nom"=> $charName,
            "type" => $typeChar[0],
            "vie" => $char[0]->caracteristiques->vie,
            "defense" => $char[0]->caracteristiques->defense,
            "attaque" => $char[0]->caracteristiques->attaque,
            "initiative" => $char[0]->caracteristiques->initiative);
    }

    function updateCharacter($gameTitle, $charName, $typeChar, $lifePoint, $defPoint, $atkPoint, $iniPoint)
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
}