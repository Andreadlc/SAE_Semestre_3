<?php



include("../includes/header.html");
include("../includes/nav_bar.php");


if (isset($_SESSION['success_message_connexion'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message_connexion'] . "</p>";
    unset($_SESSION['success_message_connexion']); // Supprimer le message après affichage
}


echo "<br><br><br>";

echo "<fieldset><legend>Authentification</legend>
<form method='post' action='Connexion.php'>
<label for='username'>Nom d'utilisateur</label> 
<input type='text' name='username' id='username' placeholder='Nom utilisateur'> <!-- Added id -->
<label for='password'>Mot de passe</label> 
<input type='password' name='password' id='password' placeholder='Mot de passe'> <!-- Added id -->
<input type='submit' name='ok' value='Se connecter'>
<br>
</form></fieldset>";


include("../includes/footer.html");
