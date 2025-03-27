<?php
session_start();
include("ChiffrementRC4/rc4.php");  // Inclusion de l'algorithme RC4

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
    $ip_address = $_SERVER['REMOTE_ADDR']; // Récupérer l'adresse IP

    // Connexion à la base de données
    $co = mysqli_connect("localhost", "root", "", "bd_sae");
    if (!$co) {
        $_SESSION['error_message'] = "La connexion à la base de données a échoué.";
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

    // Définition du fichier de log JSON du jour
    $date_today = date("Y-m-d");
    $log_file = "logs/$date_today.json";

    // Charger les logs existants du jour
    $logs = [];
    if (file_exists($log_file)) {
        $json_content = file_get_contents($log_file);
        $logs = json_decode($json_content, true);
        if (!is_array($logs)) {
            $logs = []; // Sécurité contre un fichier corrompu
        }
    }

    // Vérification de l'utilisateur
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user_logged_in'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $uname;
        $_SESSION['role'] = $user['role'];

        // Définir le message de connexion selon le rôle
        switch ($user['role']) {
            case 0:
                $_SESSION['success_message'] = "Bienvenue Utilisateur !";
                break;
            case 1:
                $_SESSION['success_message'] = "Administrateur web connecté";
                break;
            case 2:
                $_SESSION['success_message'] = "Administrateur système connecté";
                break;
        }

        // Ajouter le log de connexion réussie
        $logs[] = [
            "date" => $date_today,
            "heure" => date("H:i:s"),
            "ip" => $ip_address,
            "login" => $uname,
            "status" => "succès"
        ];

        // Sauvegarde des logs dans le fichier JSON du jour
        file_put_contents($log_file, json_encode($logs, JSON_PRETTY_PRINT));

        header("Location: accueil.php");
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

        // Ajouter le log de tentative échouée
        $logs[] = [
            "date" => $date_today,
            "heure" => date("H:i:s"),
            "ip" => $ip_address,
            "login" => $uname,
            "status" => "échec"
        ];

        // Sauvegarde des logs dans le fichier JSON du jour
        file_put_contents($log_file, json_encode($logs, JSON_PRETTY_PRINT));

        header("Location: Login.php");
        exit();
    }

    // Fermeture des connexions
    mysqli_stmt_close($stmt);
    mysqli_close($co);
}
?>
