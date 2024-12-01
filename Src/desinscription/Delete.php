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


echo "<fieldset><legend>Désinscription</legend>
<form method='post' action='Suppression.php'>
<label>Username</label>
<input type='text' name='username'>
    <label>Password</label>
<input type='password' name='password'>
    <input type='submit' name='ok' value='supprimer le compte'>
</form></fieldset>";


include("../html/footer.html");
