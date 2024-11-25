<?php
include("header.html");
include("nav_bar.php");
include("form.php");


// Traitement des données si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("form_processus.php");
}

include("footer.html");
?>



