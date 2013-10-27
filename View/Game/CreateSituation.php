<!--
o	Type
o	Titre
o	(code)
o	Exposition
o	QuestionLabel
o	List De choix (Nombre Max à définir ou illimité ?)
    	Champ mapping situation (mapper les situations)
    	Nombre de point
    	(Nombre de point en cas de victoire)
    	(Nombre de point en cas de défaite)
-->

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

            var br = document.createElement("br");

            var looseLabel = document.createElement("label");
            looseLabel.innerHTML = "Point en cas de défaite :";

            var looseInput = document.createElement("input");
            looseInput.setAttribute("type","text");
            looseInput.setAttribute("name","loosePoint");

            var combatElements = document.createElement("div");
            combatElements.setAttribute("id","combatElements")
            combatElements.appendChild(br);
            combatElements.appendChild(winLabel);
            combatElements.appendChild(winInput);
            combatElements.appendChild(br);
            combatElements.appendChild(looseLabel);
            combatElements.appendChild(looseInput);

            var form = document.getElementById("response");
            form.appendChild(combatElements);
        }
        else
        {
            var form = document.getElementById("response");
            var combatElements = document.getElementById("combatElements");
            if(combatElements != null)
            {
                form.removeChild(combatElements);
            }
        }
    }
</script>

<form name="createSituation" method="post" action="game/createSituatio">
    <label>Veuillez choisir le type de situation que vous voulez créer :</label>
    <select name="type" onchange="typeForm(this.value);">
        <?php foreach($types as $t):  ?>
            <option><?=$t?></option>
        <?php endforeach; ?>
    </select> <br/>

    <label>Titre : </label>
    <input type="text" name="title"/> <br/>

    <label>Exposition : </label>
    <textarea name="exposition" rows="4" cols="50" ></textarea>
    <br/>

    <label>Question : </label>
    <input type="text" name="question"/><br/>

    <div id="response">
        <?php for($i = 0; $i < $maxResponse; $i++):?>
            <label>Réponse <?=$i?> : </label>
            <input type="text" name="reponse<?=$i?>"/>
            <label>Nbr points : </label>
            <input type="text" name="nbPoint<?=$i?>"/><br/>
        <?php endfor; ?>
    </div>
    <input type="submit" name="createSituation" value="OK"/>
</form>