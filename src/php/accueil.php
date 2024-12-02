<?php



include("../includes/header.html");
include("../includes/nav_bar.php");


if (isset($_SESSION['success_message_connexion'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message_connexion'] . "</p>";
    unset($_SESSION['success_message_connexion']); // Supprimez le message après affichage
}


include("../includes/main.html");
include("../includes/footer.html");


echo "</body></html>";