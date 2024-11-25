<?php
include("header.html");
include("nav_bar.php");

// Afficher les messages de succès ou d'erreur si disponibles
if (isset($_SESSION['success_message'])) {
    echo "<p style='color: green;'>".$_SESSION['success_message']."</p>";
    unset($_SESSION['success_message']); // Supprimer le message après l'affichage
}

if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>".$_SESSION['error_message']."</p>";
    unset($_SESSION['error_message']); // Supprimer le message après l'affichage
}

echo "<fieldset><legend>Inscritpion</legend>
<form method='post' action='Insertion.php'>
<label>Nom d'utilisateur</label>
<input type='text' name='uname' placeholder='Nom utilisateur'>
    <label>Mot de passe</label>
<input type='password' name='password'  placeholder='Mot de passe'>
    <input type='submit' name='ok' value='créer le compte'>
</form></fieldset>";




include("footer.html");