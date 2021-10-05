<?php
	include('server.php');
?>
<html>
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="Styles/main.css">
</head>

<body>
<div class=container>
<fieldset>
  <form action="login" method="post">
    <h1>Connexion</h1>
    <label for="username">Identifiant :</label>
    <br/>
    <input type="text" id="username" name="username" required size="30">
    <br/>
    <label for="password">Mot de passe :</label>
    <br/>
    <input type="password" id="password" name="password" required size="30">
    <br/>
    <br/>
    <input type="submit" id="login" value="Se connecter">
  </form>
</fieldset>

</div>

<?php

?>
</body>
</html>