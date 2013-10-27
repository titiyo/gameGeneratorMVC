<form action="game/createGame" method="POST">
    Titre du jeu :<input type="text" name="gameTitle" value="<?= $gameTitle ?>"/>
    <br/>
    Synopsis :<input type="text" name="description" value="<?= $description ?>"/>
    <br/>
    <!--Le champ créateur pourrait être enlevé puisqu'on a déjà le nomprenom dans la var de session-->
    Créateur :<input type="text" name="owner" value="<?= $owner ?>"/>
    <br/>
    Difficute :<input type="text" name="difficulty" <?= $difficulty ?>/>
    <br/>
    <input type="hidden" name="isNew" value="false"/>
    <input type="submit" value="Valider"/>
</form>