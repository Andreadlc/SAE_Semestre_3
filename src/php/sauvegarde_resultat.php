<?php
// Démarrage de la session
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    die("Erreur : utilisateur non authentifié.");
}

// Connexion à la base de données
$co = mysqli_connect("localhost", "root", "", "bd_sae");
if (!$co) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Récupére les données envoyées via POST
$utilisateur_id = $_SESSION['id']; // ID de l'utilisateur connecté
$result = $_POST['result'];
$lambda = $_POST['lambda'];
$mean = $_POST['mean'];
$std_dev = $_POST['std_dev'];
$mu = $_POST['mu'];
$t = $_POST['t'];
$n = $_POST['n'];
$method = $_POST['method'];

// Insére les données dans la table "resultat_probabilite"
$sql = "INSERT INTO resultat_probabilite (utilisateur_id, esperance_mu, forme_lambda, valeur_t, nombre_valeurs_n, methode_calcul, valeur_probabilite, moyenne_x, ecart_type_sigma)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($co, $sql);


mysqli_stmt_bind_param($stmt, 'iddidsddd', $utilisateur_id, $mu, $lambda, $t, $n, $method, $result, $mean, $std_dev);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['success_message'] = "Résultat sauvegardé avec succès.";
    header('Location: module.php'); // Redirection vers la page du module
    exit();
} else {
    $_SESSION['error_message'] = "Erreur lors de la sauvegarde : " . mysqli_error($co);
    header('Location: module.php'); // Redirection en cas d'erreur
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($co);
?>
