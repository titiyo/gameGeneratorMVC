<h1>Game Panel<h1/>

<h2><?=$gameTitle?></h2>
<div>
    <div>
        <h2>Personnage(s)</h2>
        <input type="button" value="Créer un Héros" onclick="location.href='Game/CreateCharacter?gameTitle=<?=$gameTitle?>'">
    </div>
    <div>
        <h2>Situation(s)</h2>
        <?php if($situations != null): ?>
            <ul>
                <?php foreach($situations as $item):?>
                    <li>
                        <a href="Game/EditSituation?gameTitle=<?=$gameTitle?>&createDate=<?=$createDate?>&idSituation=<?=$item["idSituation"]?>">
                            (<i><?=$item["type"]?></i>)  <?=$item["title"]?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>
        <input type="button" value="Créer une situation" onclick="location.href='Game/CreateSituation?gameTitle=<?=$gameTitle?>&createDate=<?=$createDate?>'">
    </div>
</div>