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

<div class="hero-unit">
    <form name="editSituation" method="post" action="game/editSituations">
        <?php include("_CreateOrEditSituation.php");  ?>
        <input type="submit" name="editSituation" value="Submit"/>
    </form>
</div>