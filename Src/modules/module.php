<?php



include("../html/header.html");
include("../acceuil/nav_bar.php");
include("form.php");


// Traitement des données si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("form_processus.php");
}


include("../html/footer.html");
?>



