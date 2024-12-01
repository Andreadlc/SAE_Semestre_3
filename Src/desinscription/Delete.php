<?php



include("../html/header.html");
include("../acceuil/nav_bar.php");


echo "<style>
form{
display: flex;
flex-direction: column;
width: 400px;
margin: auto;
}

input{
height: 50px;
margin-bottom: 1.5rem;
}

fieldset{
margin: auto;
max-width: 450px;
border-radius: 5px;
}

form p{
    color: red; 
}
</style>";


echo "<br><br><br>";

echo "<fieldset><legend>Désinscription</legend>
<form method='post' action='Suppression.php'>
<label>Nom d'utilisateur</label>
<input type='text' name='username' placeholder='Nom utilisateur'>
<label>Mot de passe</label>
<input type='password' name='password' placeholder='Mot de passe'>
<input type='submit' name='ok' value='Supprimer le compte'>
<br>
</form></fieldset>";



include("../html/footer.html");
