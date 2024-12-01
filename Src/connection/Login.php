<?php



include("../html/header.html");
include("../acceuil/nav_bar.php");


if (isset($_SESSION['success_message_connexion'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message_connexion'] . "</p>";
    unset($_SESSION['success_message_connexion']); // Supprimer le message après affichage
}


echo "<br><br><br>";

echo "<fieldset><legend>Authentification</legend>
<form method='post' action='Connexion.php'>
<label>Nom d'utilisateur</label>
<input type='text' name='username' placeholder='Nom utilisateur'>
<label>Mot de passe</label>
<input type='password' name='password' placeholder='Mot de passe'>
<input type='submit' name='ok' value='se connecter'>
<br>
</form></fieldset>";


include("../html/footer.html");
