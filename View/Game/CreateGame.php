<div class="hero-unit">
    <form action="game/createGameFile" method="POST">
        <label>Titre du jeu : </label><input type="text" name="gameTitle" value="<?= $gameTitle ?>" required/>
        <label>Synopsis : </label><input type="text" name="description" value="<?= $description ?>" required/>
        <label>Difficulté : </label>
        <select name="difficulty" required >
            <option value="">Not Selected</option>
            <?php foreach($difficultyList as $key => $value):  ?>
                <option value="<?=$key?>"><?=$value?></option>
            <?php endforeach; ?>
        </select>
        <br/>
        <input type="submit" value="Valider"/>
    </form>
</div>