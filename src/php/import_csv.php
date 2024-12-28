<?php

include("includes/header.html");
include("includes/nav_bar.php");

// Vérifie si l'utilisateur est administrateur
if ($_SESSION['role'] != 1) {
    header('Location: acces_refuser.php');
    exit();
}

// Initialisation des variables pour les messages
$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $co = mysqli_connect("localhost", "root", "", "bd_sae");
    if (!$co) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Vérification si un fichier CSV a été envoyé
    if (!empty($_FILES['csv_file']['tmp_name'])) {
        $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
        $imported_count = 0; // Compteur pour suivre le nombre d'utilisateurs importés

        while (($data = fgetcsv($file, 1000, ',')) !== false) {
            // Extraction des colonnes depuis le CSV
            $username = mysqli_real_escape_string($co, $data[0]); // Nom utilisateur
            $password = md5($data[1]); // Mot de passe (chiffré en MD5 ici)
            $role = intval($data[2]); // Rôle (doit être un entier)

            // Insertion dans la base de données
            $sql = "INSERT INTO utilisateur (nom_utilisateur, mot_de_passe, role) 
                    VALUES ('$username', '$password', '$role')";

            if (mysqli_query($co, $sql)) {
                $imported_count++; // Compteur pour chaque utilisateur ajouté
            } else {
                $error_message = "Erreur lors de l'importation : " . mysqli_error($co);
                break;
            }
        }
        fclose($file);

        if (empty($error_message)) {
            // Récupérer le nom de l'administrateur depuis la session
            $admin_username = $_SESSION['username'];

            // Message de succès
            $success_message = "$imported_count comptes utilisateurs importés avec succès.";

            // Écriture dans le fichier de logs
            $log_message = "Admin: $admin_username a importé un fichier CSV contenant $imported_count utilisateurs à " . date('Y-m-d H:i:s') . "\n";
            file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);
        }
    } else {
        $error_message = "Aucun fichier sélectionné.";
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($co);
}
?>

<fieldset class="form-container">
    <legend class="form-legend">Importer un fichier CSV</legend>

    <!-- Affichage des messages -->
    <?php if (!empty($success_message)) echo "<p class='form-message form-message-success'>$success_message</p>"; ?>
    <?php if (!empty($error_message)) echo "<p class='form-message form-message-error'>$error_message</p>"; ?>

    <!-- Formulaire pour l'importation -->
    <form id="csv-import-form" method="POST" enctype="multipart/form-data">
        <label for="csv_file" class="form-label">Fichier CSV :</label>
        <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
        <button type="submit" class="form-button">Importer</button>
    </form>
</fieldset>

<?php
include("includes/footer.html");
?>
