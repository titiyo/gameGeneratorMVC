<div class="accordion" id="accordion2">
    <?php foreach ($games as $key => $item) :?>
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#game<?=$key?>">Jeux N°<?=$key?> : <?=$item["title"]?></a>
            </div>
            <div id="game<?=$key?>" class="accordion-body collapse">
                <div class="accordion-inner">
                    <label style="font-weight:bold;">Titre du jeu : </label><?=$item["gameDetail"]["title"]?><br>
                    <label style="font-weight:bold;">Créateur : </label><?=$item["gameDetail"]["creator"]?><br>
                    <label style="font-weight:bold;">Date de création : </label><?=$item["gameDetail"]["creationDate"]?><br>
                    <label style="font-weight:bold;">Description du jeu : </label><?=$item["gameDetail"]["description"]?><br>
                    <label style="font-weight:bold;">Difficulté du jeu : </label><?=$item["gameDetail"]["difficulty"]?><br>
                    <label style="font-weight:bold;">Nombre de personnage(s) : </label><?=$item["gameDetail"]["nbCharacter"]?><br>
                    <label style="font-weight:bold;">Nombre de situation(s) : </label><?=$item["gameDetail"]["nbSituation"]?><br>
                    <input type="button" value="Game Panel" onclick="location.href='Game/index?gameTitle=<?=$item["gameDetail"]["title"]?>&createDate=<?=$item["gameDetail"]["creationDate"]?>'">
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>