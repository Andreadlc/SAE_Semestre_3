<?php
session_start();

if (isset($_POST['ok'], $_POST['user_id'], $_POST['username'])) {
    $user_id = intval($_POST['user_id']); // Récupère l'ID en tant qu'entier
    $username = $_POST['username']; // Récupère le nom d'utilisateur

    // Connexion à la base de données
    $co = mysqli_connect("localhost", "root", "", "bd_sae");
    if (!$co) {
        die("La connexion a échoué : " . mysqli_connect_error());
    }

    // Vérifiez que l'administrateur ne supprime pas son propre compte
    $admin_username = $_SESSION['username']; // Nom d'utilisateur de l'admin stocké en session
    $check_admin_query = "SELECT id FROM utilisateur WHERE nom_utilisateur = ? AND id = ?";
    $stmt_check_admin = mysqli_prepare($co, $check_admin_query);
    mysqli_stmt_bind_param($stmt_check_admin, "si", $admin_username, $user_id);
    mysqli_stmt_execute($stmt_check_admin);
    $result_admin_check = mysqli_stmt_get_result($stmt_check_admin);

    if ($result_admin_check && mysqli_num_rows($result_admin_check) > 0) {
        $_SESSION['error_delete'] = "Vous ne pouvez pas supprimer votre propre compte.";
        header("Location: Delete.php");
        exit();
    }

    // Vérification de l'utilisateur : ID et nom d'utilisateur doivent correspondre
    $verify_user_query = "SELECT id FROM utilisateur WHERE id = ? AND nom_utilisateur = ?";
    $stmt_verify_user = mysqli_prepare($co, $verify_user_query);
    mysqli_stmt_bind_param($stmt_verify_user, "is", $user_id, $username);
    mysqli_stmt_execute($stmt_verify_user);
    $result_verify_user = mysqli_stmt_get_result($stmt_verify_user);

    if ($result_verify_user && mysqli_num_rows($result_verify_user) > 0) {
        // Suppression de l'historique de l'utilisateur
        $delete_history_query = "DELETE FROM resultat_probabilite WHERE utilisateur_id = ?";
        $stmt_delete_history = mysqli_prepare($co, $delete_history_query);
        mysqli_stmt_bind_param($stmt_delete_history, "i", $user_id);
        mysqli_stmt_execute($stmt_delete_history);

        // Suppression de l'utilisateur
        $delete_user_query = "DELETE FROM utilisateur WHERE id = ?";
        $stmt_delete_user = mysqli_prepare($co, $delete_user_query);
        mysqli_stmt_bind_param($stmt_delete_user, "i", $user_id);
        mysqli_stmt_execute($stmt_delete_user);

        // Journalisation de la suppression
        $log_message = "Admin: $admin_username a supprimé l'utilisateur : $username (ID: $user_id) à " . date('Y-m-d H:i:s') . "\n";
        file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);

        $_SESSION['success_delete'] = "Compte supprimé avec succès.";
        header("Location: Delete.php");
    } else {
        $_SESSION['error_delete'] = "L'utilisateur avec cet ID et ce nom n'existe pas.";
        header("Location: Delete.php");
    }

    // Fermeture des statements et de la connexion
    mysqli_stmt_close($stmt_check_admin);
    mysqli_stmt_close($stmt_verify_user);
    mysqli_stmt_close($stmt_delete_history);
    mysqli_stmt_close($stmt_delete_user);
    mysqli_close($co);
}
?>
