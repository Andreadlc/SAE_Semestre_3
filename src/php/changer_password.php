<?php
session_start();
include("ChiffrementRC4/rc4.php");  // Inclusion de RC4

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: Login.php"); // Rediriger si l'utilisateur n'est pas connecté
    exit();
}

// Connexion à la base de données
$co = mysqli_connect("localhost", "root", "", "bd_sae");
if (!$co) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id']; // Récupérer l'ID de l'utilisateur
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $key = "MaCleSecreteRC4"; // Clé pour RC4

    // Vérification de l'ancien mot de passe
    $sql = "SELECT mot_de_passe FROM utilisateur WHERE id = ?";
    $stmt = mysqli_prepare($co, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $stored_password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_free_result($stmt); // Libérer le résultat

    // Chiffrement du mot de passe saisi avec RC4
    $old_password_encrypted = bin2hex(rc4($key, $old_password));

    if ($old_password_encrypted !== $stored_password) {
        $_SESSION['error_message'] = "L'ancien mot de passe est incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = "Les nouveaux mots de passe ne correspondent pas.";
    } else {
        // Chiffrement du nouveau mot de passe avec RC4
        $new_password_encrypted = bin2hex(rc4($key, $new_password));

        // Mise à jour du mot de passe
        $update_sql = "UPDATE utilisateur SET mot_de_passe = ? WHERE id = ?";
        $update_stmt = mysqli_prepare($co, $update_sql);
        mysqli_stmt_bind_param($update_stmt, 'si', $new_password_encrypted, $user_id);
        mysqli_stmt_execute($update_stmt);

        if (mysqli_stmt_affected_rows($update_stmt) > 0) {
            // Enregistrement dans les logs
            $log_message = "L'utilisateur ID: $user_id a changé son mot de passe à " . date('Y-m-d H:i:s') . "\n";
            file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);

            $_SESSION['success_message_connexion'] = "Votre mot de passe a été mis à jour avec succès.";
        } else {
            $_SESSION['error_message'] = "Erreur lors de la mise à jour du mot de passe. Veuillez réessayer.";
        }

        mysqli_stmt_close($update_stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($co);
}

header("Location: form_change_password.php"); // Rediriger après la tentative de changement
exit();
?>
