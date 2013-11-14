<h1>Back-office : Liste des utilisateurs<h1/>
    <div>
        <div>
            <h2>Personnage(s) : </h2>
            <?php if($userList != null): ?>
                    <?php foreach($userList as $user):?>

                            <a href="Authentication/EditUser?userLogin=<?=$user->login?>">
                                <?php echo "Utilisateur ".$user->lname." ".$user->fname?>
                            </a>
                            <label style="font-weight:bold;">Login : </label><?=$user->login?>
                            <label style="font-weight:bold;">Type : </label><?=$user["group"]?>
                            <label style="font-weight:bold;">Mail : </label><?=$user->mail?>
                        <br><br>
                    <?php endforeach?>
            <?php endif; ?>
        </div>
    </div>