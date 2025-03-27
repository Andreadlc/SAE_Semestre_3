<?php
session_start();

// Vérification du rôle de l'administrateur système
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: acces_refuser.php");
    exit();
}

// Vérification si un fichier a été spécifié
if (!isset($_GET['file']) || empty($_GET['file'])) {
    die("Aucun fichier spécifié.");
}

// Sécurisation du nom du fichier
$file_name = basename($_GET['file']); // Ne garde que le nom du fichier
$file_path = "logs/" . $file_name; // Chemin complet

// Vérifier si le fichier existe avant de supprimer
if (!file_exists($file_path)) {
    die("Le fichier demandé n'existe pas.");
}

// Suppression du fichier
if (unlink($file_path)) {
    echo "Le fichier $file_name a été supprimé avec succès.";
} else {
    echo "Erreur lors de la suppression du fichier.";
}

// Redirection vers la page d'administration après 2 secondes
header("refresh:2;url=adminsystem.php");
exit();
?>
