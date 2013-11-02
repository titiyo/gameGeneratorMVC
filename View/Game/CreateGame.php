<div class="hero-unit">
    <form action="game/createGameFile" method="POST">
        <label>Titre du jeu : </label><input type="text" name="gameTitle" value="<?= $gameTitle ?>" required/>
        <label>Synopsis : </label><input type="text" name="description" value="<?= $description ?>" required/>
        <!--Le champ créateur pourrait être enlevé puisqu'on a déjà le nomprenom dans la var de session-->
        <label>Créateur : </label><input type="text" name="owner" value="<?= $owner ?>" required/>
        <label>Difficute : </label><input type="text" name="difficulty" <?= $difficulty ?> required/>
        <br/>
        <input type="hidden" name="isNew" value="false"/>
        <input type="submit" value="Valider"/>
    </form>
</div>