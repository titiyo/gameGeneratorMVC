<!--
 *
 * Created by IntelliJ IDEA.
 * User: Chris
 * Date: 11/11/13
 * Time: 12:20
 * To change this template use File | Settings | File Templates.
 *
 -->
<div class="hero-unit">
    <form name="createSituation" method="post" action="game/EditCharacters">
        <input type="hidden" name="gameTitle" value="<?=$gameTitle?>" />
        <input type="hidden" name="createDate" value="<?=$createDate?>" />
        <label>Nom du héros : </label><input type="text" name="char" id="char" value="<?=$character["nom"]?>" disabled>
        <input type="hidden" id="charName" name="charName" value="<?=$character["nom"]?>">
        <label>Type du héros </label>

        <select id="charType" name="charType" required>
<?php
            if($character["type"]=="E")
            {
?>
                <option value="H" >Héros</option>
                <option value="E" selected>Ennemi</option>
<?php
            }
            else
            {
?>
                <option value="H" selected >Héros</option>
                <option value="E" >Ennemi</option>
<?php
            }
?>
        </select>
        <fieldset>
            <legend>Caractéristiques : </legend>
            <label>Points de vie : </label><input type="text" name="lifePoint" id="lifePoint" value="<?=$character["vie"]?>"required>
            <label>Points de défense : </label><input type="text" name="defPoint" id="defPoint" value="<?=$character["defense"]?>" required>
            <label>Points d'attaque : </label><input type="text" name="atkPoint" id="atkPoint" value="<?=$character["attaque"]?>" required>
            <label>Points d'initiative : </label><input type="text" name="iniPoint" id="iniPoint" value="<?=$character["initiative"]?>" required>
        </fieldset><br>
        <input type="submit" value="Ok"/>
    </form>
</div>