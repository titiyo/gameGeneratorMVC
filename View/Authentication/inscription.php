<div class="hero-unit">
    <form method="post" id="inscriptionForm" action="Authentication/createUser">
        <label>Nom : </label><input type="text" onchange="writeMail()" name="lname" id="lnameInput" required/>
        <label>Prénom : </label><input type="text" onchange="writeMail()" name="fname" id="fnameInput" required/>
        <label>Login : </label><input type="text" name="login"  id="loginInput"/>
        <label>Mail : </label><input type="email" name="email" id="emailInput" required/>
        <label>Mot de passe : </label><input type="password" name="pwd" id="pwdInput" required/>
        <label>Confirmation : </label><input type="password" name="pwdConf" id="pwdConfInput" required/>
        <center><input type="submit" value="valider"></center>
    </form>
</div>