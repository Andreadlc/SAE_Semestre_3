<?php
// Démarrage de la session
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    die("Erreur : utilisateur non authentifié.");
}

// Connexion à la base de données
$co = mysqli_connect("localhost", "root", "", "bd_sae"); // Assurez-vous que "bd_sae" est le bon nom de votre base de données
if (!$co) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupère les données envoyées via POST
$utilisateur_id = $_SESSION['id']; // ID de l'utilisateur connecté
$a = $_POST['a']; // Coefficient a
$b = $_POST['b']; // Coefficient b
$c = $_POST['c']; // Coefficient c
$discriminant = $_POST['discriminant']; // Discriminant
$racine_1 = $_POST['racine_1']; // Racine 1 (peut être complexe)
$racine_2 = $_POST['racine_2']; // Racine 2 (peut être complexe)

// Insère les données dans la table "resultat_polynome"
$sql = "INSERT INTO resultat_polynome (utilisateur_id, coefficient_a, coefficient_b, coefficient_c, discriminant, racine_1, racine_2, date_calcul)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($co, $sql);

// Lier les paramètres à la requête préparée
mysqli_stmt_bind_param($stmt, 'iddidss', $utilisateur_id, $a, $b, $c, $discriminant, $racine_1, $racine_2);

if (mysqli_stmt_execute($stmt)) {
    // Si l'insertion réussit, rediriger l'utilisateur avec un message de succès
    $_SESSION['success_message'] = "Les résultats ont été sauvegardés avec succès.";
    header('Location: module_polynome.php'); // Redirection vers la page du module
    exit();
} else {
    // En cas d'erreur, rediriger avec un message d'erreur
    $_SESSION['error_message'] = "Erreur lors de la sauvegarde : " . mysqli_error($co);
    header('Location: module_polynome.php'); // Redirection en cas d'erreur
    exit();
}

// Fermer la requête préparée et la connexion à la base de données
mysqli_stmt_close($stmt);
mysqli_close($co);
?>
