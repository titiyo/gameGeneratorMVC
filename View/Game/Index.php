<h1>Game Panel<h1/>

<h2><?=$gameTitle?></h2>
<div>
    <div>
        <h2>Personnage(s)</h2>
        <input type="button" value="Créer un Héros" onclick="location.href='Game/CreateCharacter'">
    </div>
    <div>
        <h2>Situation(s)</h2>
        <input type="button" value="Créer une situation" onclick="location.href='Game/CreateSituation/<?=$gameTitle?>'">
    </div>
</div>