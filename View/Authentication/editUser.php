<div class="hero-unit">
    <form method="post" id="inscriptionForm" action="Authentication/ModifUser">
        <label>Nom : </label><input type="text" onkeyup="writeMail()" name="lname" id="lnameInput" value="<?=$userDetail["lname"]?>" disabled/>
        <label>Prénom : </label><input type="text" onkeyup="writeMail()" name="fname" id="fnameInput" value="<?=$userDetail["fname"]?>" disabled/>
        <label>Login : </label><input type="text" name="login"  id="loginInput" value="<?=$userDetail["login"]?>" disabled/>
        <input type="hidden" id="login" name="login" value="<?=$userDetail["login"]?>">
        <label>Type : </label><select id="typeUser" name="typeUser">
<?php       if($userDetail["type"]=="member")
            {
?>
             <option value="member" selected>Membre</option>
             <option value="admin">Administrateur</option>
<?php
            }
            else
            {
?>
                <option value="member">Membre</option>
                <option value="admin" selected>Administrateur</option>
<?php
            }
?>
        </select>

        <label>Mail : </label><input type="email" name="email" id="emailInput" value="<?=$userDetail["mail"]?>" required/>
        <label>Mot de passe : </label><input type="password" name="pwd" id="pwdInput" value="<?=$userDetail["pwd"]?>" required/>
        <label>Confirmation : </label><input type="password" name="pwdConf" id="pwdConfInput" value="<?=$userDetail["pwd"]?>" required/>
        <center><input type="submit" value="valider"></center>
    </form>
</div>