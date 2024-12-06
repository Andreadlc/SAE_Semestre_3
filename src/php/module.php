<?php



include("includes/header.html");
include("includes/nav_bar.php");
include("form.php");


// Traitement des données si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("form_processus.php");
}


include("includes/footer.html");
?>



