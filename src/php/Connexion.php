<?php
session_start();

// Si l'utilisateur est déjà connecté, redirige vers l'historique des calculs
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    header('Location: historique_module_maths.php');
    exit();
}

if (!isset($_SESSION['i'])) { // Initialisation des tentatives de connexion
    $_SESSION['i'] = 0;
}

if (isset($_POST['ok'], $_POST['username'], $_POST['password'])) {
    // Vérification du captcha d'abord
    if (isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"]) {
        $uname = $_POST['username'];
        $password = $_POST['password'];

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

        // Vérification de l'utilisateur et du mot de passe
        $table = "utilisateur";
        $password_md5 = md5($password);  // Toujours mieux d'utiliser password_hash pour une meilleure sécurité

        // Préparation de la requête pour vérifier le nom d'utilisateur et le mot de passe
        $sql = "SELECT * FROM $table WHERE nom_utilisateur = ? AND mot_de_passe = ?";
        $stmt = mysqli_prepare($co, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $uname, $password_md5);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Si l'utilisateur est trouvé
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Vérification du rôle de l'utilisateur (0 = utilisateur normal, 1 = admin web, 2 = admin système)
            $_SESSION['user_logged_in'] = true;
            $_SESSION['id'] = $user['id']; // Stocke l'ID de l'utilisateur
            $_SESSION['username'] = $uname;
            $_SESSION['role'] = $user['role']; // Récupération du rôle
            // Redirection selon le rôle
            if ($user['role'] == 0) {
                // Utilisateur normal
                $_SESSION['success_message_connexion'] = "Bienvenue Utilisateur !";
                header("Location: accueil.php");
            } elseif ($user['role'] == 1) {
                // Administrateur web
                $_SESSION['success_message_connexion'] = "Administrateur web connecté";
                header("Location: accueil.php");
            } elseif ($user['role'] == 2) {
                // Administrateur système
                $_SESSION['success_message_connexion'] = "Administrateur système connecté";
                header("Location: accueil.php");
            }

            // Log de la connexion réussie
            $log_message = "Connexion réussie pour l'utilisateur: $uname à " . date('Y-m-d H:i:s') . "\n";  // Ajout du retour à la ligne
            file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);  // Ajout du message dans le fichier de log
            exit();
        } else {
            // Tentatives échouées
            $_SESSION['i']++;
            if ($_SESSION['i'] >= 3) {
                $_SESSION['error_message'] = "Vous avez dépassé le nombre maximal de tentatives. Veuillez réessayer plus tard.";
                session_destroy();
                header("Location: Login.php");
                exit();
            }

            $_SESSION['error_message'] = "Nom d'utilisateur ou mot de passe incorrect.";

            // Log de la tentative de connexion échouée
            $log_message = "Tentative de connexion échouée pour l'utilisateur: $uname à " . date('Y-m-d H:i:s') . "\n";  // Ajout du retour à la ligne
            file_put_contents("logs/suppressions.log", $log_message, FILE_APPEND);  // Ajout du message dans le fichier de log
            header("Location: Login.php");
            exit();
        }

        mysqli_stmt_close($stmt);
        mysqli_close($co);
    } else {
        $_SESSION['error_message'] = "Captcha incorrect. Veuillez réessayer.";




        header("Location: Login.php");
        exit();
    }
}

?>
