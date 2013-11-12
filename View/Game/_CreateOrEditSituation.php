<table id="tabSituation">
    <tr>
        <td>
            <label>Veuillez choisir le type de situation que vous voulez créer :</label>
            <select name="type" onchange="typeForm(this.value);" style="width:90%;">
                <?php foreach($types as $t):  ?>
                    <?php if($t == $situation["type"]): ?>
                        <option selected="true"><?=$t?></option>
                    <?php else :?>
                        <option><?=$t?></option>
                    <?php endif;?>
                <?php endforeach; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <label>Titre : </label>
            <input type="text" name="situationTitle" style="width:90%;" value="<?=$situation["title"]?>"/>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <label>Exposition : </label>
            <textarea name="situationExposition" rows="4" cols="50" style="width:90%;"> <?=$situation["exposition"]?> </textarea>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <label>Question : </label>
            <input type="text" name="situationQuestion" style="width:90%;" value="<?=$situation["question"]?>"/>
        </td>
    </tr>

    <?php for($i = 0; $i < $maxResponse; $i++):?>
        <tr>
            <td>
                <label>Réponse <?=$i?> : </label>
                <?php if( $i < count($situation["answers"])): ?>
                    <input type="text" name="situationReponse<?=$i?>" style="width:90%;" value="<?=$situation["answers"][$i]?>"/>
                <?php else: ?>
                    <input type="text" name="situationReponse<?=$i?>" style="width:90%;"/>
                <?php endif; ?>
            </td>
            <td>
                <label>Nbr points : </label>
                <?php if( $i < count($situation["points"])): ?>
                    <input type="text" name="situationNbPoint<?=$i?>" style="width:90%;" value="<?=$situation["points"][$i]?>"/>
                <?php else: ?>
                    <input type="text" name="situationNbPoint<?=$i?>" style="width:90%;"/>
                <?php endif; ?>
            </td>
        </tr>
    <?php endfor; ?>
</table>
<input type="hidden" name="gameTitle" value="<?=$gameTitle?>" />
<input type="hidden" name="createDate" value="<?=$createDate?>" />
<input type="hidden" name="idSituation" value="<?=$situation["idSituation"]?>" />