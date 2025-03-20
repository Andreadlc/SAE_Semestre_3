<?php
session_start();

// Connexion à la base de données
$co = mysqli_connect("localhost", "root", "", "bd_sae");

if (!$co) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Vérifier si les données ont bien été envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si tous les champs nécessaires sont envoyés
    if (isset($_POST['key_encrypt'], $_POST['text_encrypt'], $_POST['texte_original'], $_POST['operation']) && isset($_SESSION['id'])) {
        $utilisateur_id = $_SESSION['id']; // Vérifie que l'ID utilisateur est bien en session
        $cle = $_POST['key_encrypt'];
        $texte_original = $_POST['texte_original'];
        $texte_resultat = $_POST['text_encrypt']; // Le texte chiffré ou déchiffré
        $operation = $_POST['operation'];

        // Préparer la requête d'insertion
        $sql = "INSERT INTO historique_crypto (utilisateur_id, cle, texte_original, text, operation) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($co, $sql);

        // Vérifier si la préparation de la requête a échoué
        if (!$stmt) {
            die("Erreur de préparation de la requête : " . mysqli_error($co));
        }

        // Bind des paramètres pour l'exécution de la requête
        mysqli_stmt_bind_param($stmt, "issss", $utilisateur_id, $cle, $texte_original, $texte_resultat, $operation);

        // Exécution de la requête
        $execute = mysqli_stmt_execute($stmt);

        // Si l'exécution est réussie, rediriger vers l'historique
        if ($execute) {
            $_SESSION['success_message'] = "Résultat sauvegardé avec succès !";
            header("Location: historique_module_maths.php"); // Redirige vers l'historique
            exit();
        } else {
            die("Erreur lors de l'insertion : " . mysqli_error($co));
        }

        // Fermer la déclaration préparée
        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color:red;'>Erreur : Tous les champs ne sont pas remplis ou vous n'êtes pas connecté !</p>";
    }
} else {
    echo "<p style='color:red;'>Aucune donnée reçue.</p>";
}

// Fermer la connexion à la base de données
mysqli_close($co);
?>
