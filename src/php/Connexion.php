<?php
session_start();
include("ChiffrementRC4/rc4.php");  // Inclusion de RC4

// Si l'utilisateur est déjà connecté, rediriger vers l'historique des calculs
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    header('Location: historique_module_maths.php');
    exit();
}

// Initialisation du compteur de tentatives de connexion
if (!isset($_SESSION['i'])) {
    $_SESSION['i'] = 0;
}

// Vérification si le formulaire a été soumis
if (isset($_POST['ok'], $_POST['username'], $_POST['password'])) {

    // Vérification du captcha
    if (!isset($_POST["captcha"]) || $_POST["captcha"] == "" || $_SESSION["code"] != $_POST["captcha"]) {
        $_SESSION['error_message'] = "Captcha incorrect. Veuillez réessayer.";
        header("Location: Login.php");
        exit();
    }

    // Récupération des informations du formulaire
    $uname = $_POST['username'];
    $password = $_POST['password'];
    $key = "MaCleSecreteRC4";  // Clé pour RC4

    // Connexion à la base de données
    $co = mysqli_connect("localhost", "root", "", "bd_sae");
    if (!$co) {
        $_SESSION['error_message'] = "La connexion à la base de données a échoué.";
        header("Location: Login.php");
        exit();
    }

    // Sélection de la base de données
    $bd = mysqli_select_db($co, "bd_sae");
    if (!$bd) {
        $_SESSION['error_message'] = "Impossible de sélectionner la base de données.";
        header("Location: Login.php");
        exit();
    }

    // Chiffrement du mot de passe entré avec RC4
    $password_encrypted = bin2hex(rc4($key, $password)); // Chiffrement et conversion en hexadécimal


    // Vérification dans la base de données
    $sql = "SELECT * FROM utilisateur WHERE nom_utilisateur = ? AND mot_de_passe = ?";
    $stmt = mysqli_prepare($co, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $uname, $password_encrypted);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Vérification de l'utilisateur
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user_logged_in'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $uname;
        $_SESSION['role'] = $user['role'];

        // Redirection selon le rôle
        if ($user['role'] == 0) {
            $_SESSION['success_message'] = "Bienvenue Utilisateur !";
            header("Location: accueil.php");
        } elseif ($user['role'] == 1) {
            $_SESSION['success_message'] = "Administrateur web connecté";
            header("Location: accueil.php");
        } elseif ($user['role'] == 2) {
            $_SESSION['success_message'] = "Administrateur système connecté";
            header("Location: accueil.php");
        }

        // Log de la connexion réussie
        $log_message = "Connexion réussie pour l'utilisateur: $uname à " . date('Y-m-d H:i:s') . "\n";
        file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);

        exit();
    } else {
        // Gestion des tentatives échouées
        $_SESSION['i']++;
        if ($_SESSION['i'] >= 3) {
            $_SESSION['error_message'] = "Vous avez dépassé le nombre maximal de tentatives. Veuillez réessayer plus tard.";
            session_destroy();
            header("Location: Login.php");
            exit();
        }

        $_SESSION['error_message'] = "Nom d'utilisateur ou mot de passe incorrect.";

        // Log de la tentative de connexion échouée
        $log_message = "Tentative de connexion échouée pour l'utilisateur: $uname à " . date('Y-m-d H:i:s') . "\n";
        file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);

        header("Location: Login.php");
        exit();
    }

    // Fermeture des connexions
    mysqli_stmt_close($stmt);
    mysqli_close($co);
}
?>
