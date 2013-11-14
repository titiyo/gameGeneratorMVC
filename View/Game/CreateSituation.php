<div class="hero-unit">
    <form name="createSituation" method="post" action="game/createSituations">
        <?php include("_CreateOrEditSituation.php");  ?>

        <input type="button" value="Ajout d'une réponse" onclick="addAnswer();" />
        <input type="submit" name="createSituation" value="Submit"/>
    </form>
</div>