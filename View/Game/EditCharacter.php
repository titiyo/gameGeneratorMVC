<!--
 *
 * Created by IntelliJ IDEA.
 * User: Chris
 * Date: 11/11/13
 * Time: 12:20
 * To change this template use File | Settings | File Templates.
 *
 -->
<?php $character["type"]?>
<div class="hero-unit">
    <form name="createSituation" method="post" action="game/createCharacters?gameTitle=<?=$_GET["gameTitle"]?>">
        <label>Nom du héros : </label><input type="text" name="charName" id="charName" value="<?=$character["nom"]?>">
        <label>Type du héros </label>

        <select id="charType" name="charType" required>
                <option value="H" >Héros</option>
                <option value="E" Selected>Ennemi</option>
        </select>
        <fieldset>
            <legend>Caractéristiques : </legend>
            <label>Points de vie : </label><input type="text" name="lifePoint" id="lifePoint" required>
            <label>Points de défense : </label><input type="text" name="defPoint" id="defPoint" required>
            <label>Points d'attaque : </label><input type="text" name="atkPoint" id="atkPoint" required>
            <label>Points d'esquive : </label><input type="text" name="escPoint" id="escPoint" required>
        </fieldset><br>
        <input type="submit"  value="Ok"/>
    </form>
</div>