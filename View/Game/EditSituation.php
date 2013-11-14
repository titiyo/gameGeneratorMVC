<div class="hero-unit">
    <form name="editSituation" method="post" action="game/editSituations">
        <?php include("_CreateOrEditSituation.php");  ?>
        <input type="hidden" name="idSituation" value="<?= $situation["idSituation"]; ?>"/>
        <input type="submit" name="editSituations" value="Submit"/>
    </form>
</div>