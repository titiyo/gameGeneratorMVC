<script language="javascript" type="text/javascript">
    function typeForm(type)
    {
        if(type.toLowerCase() == "combat")
        {
            $.each($(".answerSituation"), function (i, item)
            {
                item.remove();
            });
            addAnswer();

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

            var combattreInput = $(".answerSituation").first()[0];
            combattreInput.firstElementChild.lastElementChild.setAttribute("value","Voulez-vous attaquer ?" );
            combattreInput.firstElementChild.lastElementChild.setAttribute("readonly","true");

            var winTD = document.createElement("td");
            winTD.appendChild(winLabel);
            winTD.appendChild(winInput);

            var looseTD = document.createElement("td");
            looseTD.appendChild(looseLabel);
            looseTD.appendChild(looseInput);

            combattreInput.removeChild(combattreInput.lastElementChild);
            combattreInput.appendChild(winTD);
            combattreInput.appendChild(looseTD);

            combattreInput.setAttribute("class","answerSituation combatElements");

            addAnswer();

            var fuiteInput = $(".answerSituation").last()[0];
            fuiteInput.firstElementChild.lastElementChild.setAttribute("value","Voulez-vous fuir ?");
            fuiteInput.firstElementChild.lastElementChild.setAttribute("readonly","true");
            fuiteInput.setAttribute("class","answerSituation combatElements");
            fuiteInput.children[1].lastElementChild.name = "situationNbPoint[0]";


            $.each($(".deleteResponse"), function (i, item)
            {
                item.parentNode.remove();
            });
            $.each($(".addResponse"), function (i, item)
            {
                item.remove();
            });
        }
        else
        {
            for(var i = 0; i <= $(".combatElements").length; i++)
            {
                $("#tabSituation tbody")[0].removeChild($(".combatElements")[0]);
            }
            addAnswer();

            var form = $("#situationForm")[0];
            var inputAdd = document.createElement("input");
            inputAdd.setAttribute("type","button");
            inputAdd.setAttribute("value","Ajouter une réponse");
            inputAdd.setAttribute("onclick","addAnswer()");
            inputAdd.setAttribute("class","addResponse");
            form.appendChild(inputAdd);
        }
    }

    function addAnswer()
    {
        var numberOfSituation = $(".answerSituation").length;
        var tab = $("#tabSituation")[0].tBodies[0].lastElementChild;

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

        tr.appendChild(tdAnswer);
        tr.appendChild(tdPoints);

        if(numberOfSituation > 0)
        {
            var tdDeleteAnswer = document.createElement("td");
            var inputDelete = document.createElement("input");
            inputDelete.setAttribute("type","button");
            inputDelete.setAttribute("value","Supprimer la réponse");
            inputDelete.setAttribute("onclick","deleteAnswer(this)");
            inputDelete.setAttribute("class","deleteResponse");
            tdDeleteAnswer.appendChild(inputDelete);
            tr.appendChild(tdDeleteAnswer);
        }

        tab.parentNode.insertBefore(tr, tab.nextSibling);
    }

    function deleteAnswer(trNode)
    {
        var trToDelete = trNode.parentNode.parentNode;

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
        <?php if(count($situation["answers"]) != 0 && $situation["type"] != "Combat"):?>
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
                    <?php if(!empty($situation["situationsMap"])):?>
                        <td>
                            <label>Mapping <?=$i?> :</label>
                            <select name="mappingSituation[<?=$i?>]" style="width:90%;">
                                <option value="1">Situation Fin</option>
                                <?php for($j = 0; $j < count($situation["situationsMap"]); $j++):?>
                                    <option value="<?=$situation["situationsMap"][$j]["idSituation"]?>"><?=$situation["situationsMap"][$j]["title"]?></option>
                                <?php endfor;?>
                            </select>
                        </td>
                    <?php endif;?>
                    <?php if($i!=0):?>
                        <td>
                             <input type="button" class="deleteResponse" value="Suppression d'une réponse" onclick="deleteAnswer(this);" />
                        </td>
                    <?php endif;?>
            <?php endfor; ?>
        <?php elseif(count($situation["answers"]) != 0): ?>

            <tr class="answerSituation">
                <td>
                    <label>Réponse 0 : </label>
                    <input readonly = "true" type="text" name="situationReponse[0]" style="width:90%;" value="<?=$situation["answers"][0]?>"/>
                </td>
                <td>
                    <label>Point en cas de victoire : </label>
                    <input type="text" name="winPoint" style="width:90%;" value="<?=$situation["winPoint"]?>"/>
                </td>
                <td>
                    <label>Point en cas de défaite : </label>
                    <input type="text" name="loosePoint" style="width:90%;" value="<?=$situation["loosePoint"]?>"/>
                </td>
                <?php if(!empty($situation["situationsMap"])):?>
                    <td>
                        <label>Mapping win :</label>
                        <select name="mappingSituation[0]" style="width:90%;">
                            <option value="1">Situation Fin</option>
                            <?php for($i = 0; $i < count($situation["situationsMap"]); $i++):?>
                                <option value="<?=$situation["situationsMap"][$i]["idSituation"]?>"><?=$situation["situationsMap"][$i]["title"]?></option>
                            <?php endfor;?>
                        </select>
                    </td>
                <?php endif;?>
            </tr>
            <tr>
                <td>
                    <label>Réponse 1 : </label>
                    <input readonly = "true" type="text" name="situationReponse[1]" style="width:90%;" value="<?=$situation["answers"][1]?>"/>
                </td>
                <td>
                    <label>Nbr points : </label>
                    <input type="text" name="situationNbPoint[0]" style="width:90%;" value="<?=$situation["points"][1]?>"/>
                </td>
                <?php if(!empty($situation["situationsMap"])):?>
                    <td>
                        <label>Mapping Fuite :</label>
                        <select name="mappingSituation[1]" style="width:90%;">
                            <option value="1">Situation Fin</option>
                            <?php for($i = 0; $i < count($situation["situationsMap"]); $i++):?>
                                <option value="<?=$situation["situationsMap"][$i]["idSituation"]?>"><?=$situation["situationsMap"][$i]["title"]?></option>
                            <?php endfor;?>
                        </select>
                    </td>
                <?php endif;?>
            </tr>
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
        <?php endif; ?>
     </tr>
</table>
<input type="hidden" name="gameTitle" value="<?=$gameTitle?>" />
<input type="hidden" name="createDate" value="<?=$createDate?>" />
<input type="hidden" name="idSituation" value="<?=$situation["idSituation"]?>" />

<input type="button" class="addResponse" value="Ajout d'une réponse" onclick="addAnswer();" />