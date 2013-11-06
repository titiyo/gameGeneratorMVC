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
     * @param $owner
     * @param $difficulty
     * @param $login
     */
    public function createFileGame($fileGameDirectory, $id, $createDate, $gameTitle, $description, $owner, $difficulty, $login)
    {
$stringxml = <<<XML
<?xml version='1.0'?>
<jeu>
    <id>$id</id>
    <datecreation>$createDate</datecreation>
    <nbsituation>0</nbsituation>
    <titre>$gameTitle</titre>
    <createur>$owner</createur>
    <description>$description</description>
    <difficulte>$difficulty</difficulte>
</jeu>
XML;

        $xml = simplexml_load_string($stringxml);

        $fileName = $fileGameDirectory."/fileGame_".$login."_".$createDate.".xml";
        $xml->asXml($fileName);
     }

    /*
    * @param $login
    */
    public function getGameList($login)
    {
        $dir = "Content/xml/members/";
        $root = scandir($dir,1);
        $foundDir=false;
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
            $i=0;
            foreach($gameFileXml->jeu as $game)
            {
                $gameList[$i]=$game;
                $i++;
            }
        }
        return $gameList;
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
                $detailGame = simplexml_load_file("Content/xml/members/".$_SESSION["login"]."/".$nameGame."/".$value);
                //echo "Content/xml/members/".$_SESSION["login"]."/".$nameGame."/".$value."<br>";
                $detailTab["jeu"]=array("datecreation"=> $detailGame->datecreation,
                    "titre"=>$detailGame->titre,
                    "createur"=>$detailGame->createur,
                    "nbsituation"=>$detailGame->nbsituation,
                    "description"=>$detailGame->description,
                    "difficulte"=>$detailGame->difficulte);
                break;
            }
        }
        return $detailTab;
    }
    
    public function addSituationInGameFile($UserGameFile, $arrayForm)
    {
    	$xml = simplexml_load_file($UserGameFile);
    	//$xml = simplexml_load_file("Content/xml/Members/jbreton/'/fileGame_jbreton_05112013.xml");
    	
    	$situation = $xml->addChild("situation");
    	$situation->addAttribute("type",$arrayForm[0]);
    	$situation->addChild("situationCode", uniqid());
    	$situation->addChild("situationTitle",$arrayForm[1]);
    	$situation->addChild("situationExposition",$arrayForm[2]);
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
    	
    	//$xml->asXml($UserGameFile);
    	$xml->asXml("Content/xml/Members/jbreton/Star Wars/fileGame_jbreton_05112013.xml");
    }
}