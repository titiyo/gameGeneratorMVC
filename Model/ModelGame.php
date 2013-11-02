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

    private $fileXml;

    public function __construct() {
        $this->fileXml = simplexml_load_file("Content/xml/users.xml");
    }

    /**
     * @param $gameTitle
     * @param $description
     * @param $owner
     * @param $difficulty
     */
    public function createGame($gameTitle, $description, $owner, $difficulty) {
        //ON ADMET QU'UNE VARIABLE DE SESSION AVEC NOM ET PRENOM UTILISATEUR EXISTE
        //PUISQU'IL S'EST AUTHENTIFIE
        $nomprenom = "julienbreton";

        //script création de jeu :
        setlocale(LC_TIME, 'fra_fra');

        $datecreation = strftime('%d%m%Y');
        $id = uniqid();
        $nbsituation = 0;
        $titrejeu = $gameTitle;
        $description = $description;
        $createur = $owner;
        $difficulte = $difficulty;

        //On change de répertoire
        chdir("C:/Program Files (x86)/EasyPHP-DevServer-13.1VC9/data/localweb/Projet5A/gameGeneratorMVC/membres/jullienbreton");

        //Création du répertoire de jeu
        mkdir($titrejeu, 0777);

        //on se déplace dans le répertoire nouvellement créé
        chdir($titrejeu);

        //Le champ créateur pourrait être enlevé puisqu'on a déjà le nomprenom dans la var de session
$stringxml = <<<XML
<?xml version='1.0'?>
<jeu>
    <id>$id</id>
    <datecreation>$datecreation</datecreation>
    <nbsituation>$nbsituation</nbsituation>
    <titre>$titrejeu</titre>
    <createur>$nomprenom</createur>
    <description>$description</description>
    <difficulte>$difficulte</difficulte>
</jeu>
XML;

        $xml = simplexml_load_string($stringxml);

        $nomfichier = "fichier_jeu_".$nomprenom."_".$datecreation.".xml";
        $xml->asXml($nomfichier);

        //Ajouter une balise <jeu> dans le fichier user.xml
        chdir("..");
        $xml = simplexml_load_file("userGames.xml");
        $nouveaujeu = $xml->addChild("jeu", $titrejeu);
        $xml->asXml("userGames.xml");
    }
}