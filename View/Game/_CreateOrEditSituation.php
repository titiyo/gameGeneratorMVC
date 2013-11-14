<script language="javascript" type="text/javascript">
    function typeForm(type)
    {
        if(type.toLowerCase() == "combat")
        {
            var winLabel = document.createElement("label");
            winLabel.innerHTML = "Point en cas de victoire :";

            var winInput = document.createElement("input");
            winInput.setAttribute("type","text");
            winInput.setAttribute("name","winPoint");

            var looseLabel = document.createElement("label");
            looseLabel.innerHTML = "Point en cas de défaite :";

            var looseInput = document.createElement("input");
            looseInput.setAttribute("type","text");
            looseInput.setAttribute("name","loosePoint");

            var trWin = document.createElement("tr");
            trWin.setAttribute("class","combatElements");
            var trLoose = document.createElement("tr");
            trLoose.setAttribute("class","combatElements");

            var winTD = document.createElement("td");
            winTD.appendChild(winLabel);
            winTD.appendChild(winInput);

            var looseTD = document.createElement("td");
            looseTD.appendChild(looseLabel);
            looseTD.appendChild(looseInput);

            var form = $("#tabSituation tbody")[0];

            form.appendChild(trWin).appendChild(winTD);
            form.appendChild(trLoose).appendChild(looseTD);
        }
        else
        {
            for(var i = 0; i <= $(".combatElements").length; i++)
            {
                $("#tabSituation tbody")[0].removeChild($(".combatElements")[0]);
            }
        }
    }

    function addAnswer()
    {
        var numberOfSituation = $(".answerSituation").length;
        var tab = $(".answerSituation").last();

        var tr = document.createElement("tr");
        tr.setAttribute("class","answerSituation")

        var tdAnswer = document.createElement("td");

        var AnswerInput = document.createElement("input");
        AnswerInput.setAttribute("type","text");
        AnswerInput.setAttribute("style","width:90%;");
        AnswerInput.setAttribute("name","situationReponse[" + numberOfSituation + "]");

        var labelAnswer = document.createElement("label");
        labelAnswer.innerHTML = "Réponse " + numberOfSituation + " :";

        tdAnswer.appendChild(labelAnswer);
        tdAnswer.appendChild(AnswerInput);

        var tdPoints = document.createElement("td");

        var pointInput = document.createElement("input");
        pointInput.setAttribute("style","width:90%;");
        pointInput.setAttribute("type","text");
        pointInput.setAttribute("name","situationNbPoint[" + numberOfSituation + "]");

        var labelPoints = document.createElement("label");
        labelPoints.innerHTML = "Nbr points : ";

        tdPoints.appendChild(labelPoints);
        tdPoints.appendChild(pointInput);

        var tdDeleteAnswer = document.createElement("input");
        tdDeleteAnswer.setAttribute("type","button");
        tdDeleteAnswer.setAttribute("value","Supprimer la réponse");
        tdDeleteAnswer.setAttribute("onclick","deleteAnswer(this)");

        tr.appendChild(tdAnswer);
        tr.appendChild(tdPoints);
        tr.appendChild(tdDeleteAnswer);

        tab[0].parentNode.insertBefore(tr, tab.nextSibling);
    }

    function deleteAnswer(trNode)
    {
        var trToDelete = trNode.parentNode;

        trToDelete.parentNode.removeChild(trToDelete);

        $.each($(".answerSituation"), function (i, item)
        {
            // Update label
            this.firstElementChild.firstElementChild.innerHTML = 	"Réponse " + i + " :";
            // Update situation response Name
            item.firstElementChild.lastElementChild.name = "situationReponse[" + i + "]";

            // Update Situation point name
            item.children[1].lastChild.name = "situationNbPoint[" + i + "]";

        });
    }
</script>

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
    <?php if(count($situation["answers"]) != 0):?>
        <?php for($i = 0; $i < count($situation["answers"]); $i++) :?>
            <tr class="answerSituation">
                <td>
                    <label>Réponse <?=$i?> : </label>
                    <input type="text" name="situationReponse[<?=$i?>]" style="width:90%;" value="<?=$situation["answers"][$i]?>"/>
                </td>
                <td>
                    <label>Nbr points : </label>
                    <input type="text" name="situationNbPoint[<?=$i?>]" style="width:90%;" value="<?=$situation["points"][$i]?>"/>
                </td>
            </tr>
        <?php endfor; ?>
    <?php else: ?>
        <tr class="answerSituation">
            <td>
                <label>Réponse 0 : </label>
                <input type="text" name="situationReponse[0]" style="width:90%;"/>
            </td>
            <td>
                <label>Nbr points : </label>
                <input type="text" name="situationNbPoint[0]" style="width:90%;"/>
            </td>
        </tr>
    <?php endif; ?>

</table>
<input type="hidden" name="gameTitle" value="<?=$gameTitle?>" />
<input type="hidden" name="createDate" value="<?=$createDate?>" />
<input type="hidden" name="idSituation" value="<?=$situation["idSituation"]?>" />