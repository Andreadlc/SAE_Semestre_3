<?php
session_start();
include("ChiffrementRC4/rc4.php");  // Inclusion de RC4
// Si le formulaire a été soumis
if (isset($_POST['ok'], $_POST['username'], $_POST['password'])) {
    if (isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"]) {
        $uname = trim($_POST['username']);
        $password = trim($_POST['password']);
        $key = "MaCleSecreteRC4";  // Clé pour RC4

        //  Vérifier que le nom d'utilisateur est valide (uniquement lettres et chiffres, au moins 5 caractères)
        if (!preg_match('/^[A-Za-z0-9]{5,}$/', $uname)) {
            $_SESSION['error_message'] = "Le nom d'utilisateur doit contenir uniquement des lettres et chiffres et au moins 5 caractères.";
            header('Location: Create.php');
            exit();
        }

        //  Vérifier que le mot de passe contient au moins 8 caractères
        if (strlen($password) < 8) {
            $_SESSION['error_message'] = "Le mot de passe doit contenir au moins 8 caractères.";
            header('Location: Create.php');
            exit();
        }

        // Connexion à la base de données
        $co = mysqli_connect("localhost", "root", "", "bd_sae"); // Connexion directe à la base BDSA

        if (!$co) {
            die("La connexion a échoué : " . mysqli_connect_error());
        }

        $table = "utilisateur"; // Table des utilisateurs

        // Chiffrement du mot de passe avec RC4

        $password_encrypted = bin2hex(rc4($key, $password)); // Convertir en hexadécimal

        // Vérifier si l'utilisateur existe déjà
        $sureql = "SELECT * FROM $table WHERE nom_utilisateur = ?";
        $stmt = mysqli_prepare($co, $sureql);
        mysqli_stmt_bind_param($stmt, 's', $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $_SESSION['error_message'] = "Le nom d'utilisateur est déjà pris.";
            header('Location: Create.php');
            exit();
        } else {
            // Forcer le rôle à zéro (utilisateur normal)
            $role = 0;

            // Insérer les données
            $insertql = "INSERT INTO $table (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($co, $insertql);
            mysqli_stmt_bind_param($stmt_insert, 'ssi', $uname, $password_md5, $role);

            if (mysqli_stmt_execute($stmt_insert)) {
                $_SESSION['success_message'] = "Votre compte a été créé avec succès, vous pouvez maintenant vous connecter !";
                $log_message = "compte a été créé avec succès pour l'utilisateur: $uname à " . date('Y-m-d H:i:s') . "\n";  // Ajout du retour à la ligne
                file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);  // Ajout du message dans le fichier de log
                header('Location: Login.php');
                exit();
            } else {
                $_SESSION['error_message'] = "Erreur d'insertion dans la base de données.";
                header('Location: Create.php');
                exit();
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt_insert);
        mysqli_close($co);
    } else {
        $_SESSION['error_message'] = "Captcha incorrect. Veuillez réessayer.";
        header("Location: Create.php");
        exit();
    }
}
?>
