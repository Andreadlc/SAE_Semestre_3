<?php
session_start();

// Vérification du rôle de l'administrateur système
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: acces_refuser.php");
    exit();
}

// Vérification si le paramètre "file" est bien présent
if (!isset($_GET['file']) || empty($_GET['file'])) {
    echo "<p>Aucun fichier spécifié. Redirection en cours...</p>";
    echo '<meta http-equiv="refresh" content="2;url=adminsystem.php">';
    exit();
}

// Assainissement du chemin du fichier pour éviter les failles de sécurité
$file_name = basename($_GET['file']); // Ne garde que le nom du fichier
$file_path = "logs/" . $file_name; // Chemin complet vers le fichier

// Vérification de l'existence du fichier
if (!file_exists($file_path)) {
    echo "<p>Le fichier demandé n'existe pas. Redirection en cours...</p>";
    echo '<meta http-equiv="refresh" content="2;url=adminsystem.php">';
    exit();
}

// Définition des en-têtes pour le téléchargement
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Length: ' . filesize($file_path));

// Lire et envoyer le fichier
readfile($file_path);
exit();
?>
