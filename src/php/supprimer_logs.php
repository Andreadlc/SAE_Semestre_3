<?php
session_start();

// Vérification du rôle de l'administrateur système
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: acces_refuser.php");
    exit();
}

// Vérification si un fichier a été spécifié
if (!isset($_GET['file']) || empty($_GET['file'])) {
    echo "<p>Aucun fichier spécifié. Redirection en cours...</p>";
    echo '<meta http-equiv="refresh" content="2;url=adminsystem.php">';
    exit();
}

// Sécurisation du nom du fichier
$file_name = basename($_GET['file']); // Ne garde que le nom du fichier
$file_path = "logs/" . $file_name; // Chemin complet

// Vérifier si le fichier existe
if (!file_exists($file_path)) {
    echo "<p>Le fichier demandé n'existe pas. Redirection en cours...</p>";
    echo '<meta http-equiv="refresh" content="2;url=adminsystem.php">';
    exit();
}

// Suppression du fichier
if (unlink($file_path)) {
    echo "<p>Le fichier <strong>$file_name</strong> a été supprimé avec succès. Redirection en cours...</p>";
} else {
    echo "<p>Erreur lors de la suppression du fichier. Redirection en cours...</p>";
}

// Redirection vers la page d'administration après 2 secondes
echo '<meta http-equiv="refresh" content="2;url=adminsystem.php">';
exit();
?>
