<?php

include("includes/header.html");
include("includes/nav_bar.php");
include("ChiffrementRC4/rc4.php");
// Vérifie si l'utilisateur est administrateur
if ($_SESSION['role'] != 1) {
    header('Location: acces_refuser.php');
    exit();
}

// Initialisation des variables pour les messages
$success_message = "";
$error_message = "";
$no_import_message = ""; // Message lorsque aucun utilisateur n'est importé
$key = "MaCleSecreteRC4";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $co = mysqli_connect("localhost", "root", "", "bd_sae");
    if (!$co) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Vérification si un fichier JSON a été envoyé
    if (!empty($_FILES['json_file']['tmp_name'])) {
        $file_content = file_get_contents($_FILES['json_file']['tmp_name']);
        $users_data = json_decode($file_content, true); // Décoder le fichier JSON
        $imported_count = 0; // Compteur pour suivre le nombre d'utilisateurs importés

        // Vérification si le JSON est valide
        if ($users_data === null) {
            $error_message = "Erreur : Le fichier JSON est invalide ou mal formaté.";
        } else {
            // Parcours de chaque utilisateur et insertion dans la base de données
            foreach ($users_data as $user) {
                // Validation des données
                if (isset($user['nom_utilisateur'], $user['mot_de_passe'], $user['role'])) {
                    $username = mysqli_real_escape_string($co, $user['nom_utilisateur']);
                    $password = bin2hex(rc4($key, $user['mot_de_passe']));
                    $role = intval($user['role']); // Rôle (doit être un entier)

                    // Vérification si l'utilisateur existe déjà dans la base de données
                    $check_user_sql = "SELECT id FROM utilisateur WHERE nom_utilisateur = '$username'";
                    $check_result = mysqli_query($co, $check_user_sql);

                    if (mysqli_num_rows($check_result) > 0) {
                        // Si l'utilisateur existe déjà, on ne fait pas l'insertion
                        continue; // Passer au prochain utilisateur dans le fichier JSON
                    }

                    // Insertion dans la base de données si l'utilisateur n'existe pas déjà
                    $sql = "INSERT INTO utilisateur (nom_utilisateur, mot_de_passe, role) 
                            VALUES ('$username', '$password', '$role')";

                    if (mysqli_query($co, $sql)) {
                        $imported_count++; // Compteur pour chaque utilisateur ajouté
                    } else {
                        $error_message = "Erreur lors de l'importation : " . mysqli_error($co);
                        break;
                    }
                }
            }

            // Si aucun utilisateur n'a été importé, afficher un message
            if ($imported_count == 0) {
                $no_import_message = "Aucun utilisateur n'a été importé, probablement en raison de doublons de noms d'utilisateurs existants.";
            }
        }

        if (empty($error_message) && empty($no_import_message)) {
            // Récupérer le nom de l'administrateur depuis la session
            $admin_username = $_SESSION['username'];

            // Message de succès
            $success_message = "$imported_count comptes utilisateurs importés avec succès.";

            // Écriture dans le fichier de logs
            $log_message = "Admin: $admin_username a importé un fichier JSON contenant $imported_count utilisateurs à " . date('Y-m-d H:i:s') . "\n";
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
    <legend class="form-legend">Importer un fichier JSON</legend>

    <!-- Affichage des messages -->
    <?php if (!empty($success_message)) echo "<p class='form-message form-message-success'>$success_message</p>"; ?>
    <?php if (!empty($error_message)) echo "<p class='form-message form-message-error'>$error_message</p>"; ?>
    <?php if (!empty($no_import_message)) echo "<p class='form-message form-message-warning'>$no_import_message</p>"; ?>

    <!-- Formulaire pour l'importation -->
    <form id="json-import-form" method="POST" enctype="multipart/form-data">
        <label for="json_file" class="form-label">Fichier JSON :</label>
        <input type="file" id="json_file" name="json_file" accept=".json" required>
        <button type="submit" class="form-button">Importer</button>
    </form>
</fieldset>

<?php
include("includes/footer.html");
?>
