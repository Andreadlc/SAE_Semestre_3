<?php



session_start();



// Vérifier si un utilisateur est connecté
if (isset($_SESSION['username'])) {
    // Récupére le nom d'utilisateur avant de détruire la session
    $uname = $_SESSION['username'];

    // Message de log pour indiquer que l'utilisateur se déconnecte
    $log_message = "L'Admin: $uname s'est déconnecté à " . date('Y-m-d H:i:s') . "\n";
    file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);
}


// Terminer la session
session_destroy(); // Détruit la session et ses données


header("Location: accueil.php");