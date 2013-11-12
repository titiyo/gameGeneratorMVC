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
</script>

<div class="hero-unit">
    <form name="editSituation" method="post" action="game/editSituations">
        <?php include("_CreateOrEditSituation.php");  ?>
        <input type="hidden" name="idSituation" value="<?= $situation["idSituation"]; ?>"/>
        <input type="submit" name="editSituations" value="Submit"/>
    </form>
</div>