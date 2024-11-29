<?php
include("header.html");

include("nav_bar.php");


if (isset($_SESSION['success_message_connexion'])) {
    echo "<p style='color: green;'>" . $_SESSION['success_message_connexion'] . "</p>";
    unset($_SESSION['success_message_connexion']); // Supprimez le message après affichage
}
include("main.html");



include("footer.html");


echo "</body></html>";