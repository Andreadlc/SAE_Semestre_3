<?php

include_once("Login.php");


// Si l'utilisateur est déjà connecté, redirigez-le vers la page utilisateur
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    header('Location: accueil.php');
    exit();
}

if (!isset($_SESSION['i'])) { // Initialise les tentatives si elles ne sont pas définies
    $_SESSION['i'] = 0;
}

if (isset($_POST['ok'], $_POST['username'], $_POST['password'])) {

    $uname = $_POST['username'];
    $password = $_POST['password'];

    if ($uname == 'admin' && $password == 'admin') {
        $_SESSION['user_logged_in'] = true; // Marque l'utilisateur comme connecté
        $_SESSION['username'] = 'admin'; // Facultatif : enregistrez l'username de l'utilisateur
        header('Location: accueil.php');
        exit();
    }

    else {
        $co = mysqli_connect("localhost", "root", ""); // Connexion à la base de données MySQL

        if (!$co) {
            die("La connexion a échoué : " . mysqli_connect_error());
        }

        // Sélection de la base de données
        $bd = mysqli_select_db($co, "test");
        if (!$bd) {
            die("Impossible de sélectionner la base de données : " . mysqli_error($co));
        }

        $table = "client"; // Table des utilisateurs
        $password_md5 = md5($password); // Hachage du mot de passe

        $searchnameql = "SELECT * FROM $table WHERE login = '$uname'"; // Requête pour vérifier le nom d'utilisateur
        $searchpassql = "SELECT * FROM $table WHERE mdp = '$password_md5'"; // Requête pour vérifier le mot de passe

        $resultuname = mysqli_query($co, $searchnameql); // Exécution de la requête
        $resultpass = mysqli_query($co, $searchpassql); // Exécution de la requête

        if ($resultuname && $resultpass) {
            $rowu = mysqli_fetch_assoc($resultuname); // Récupère le résultat du nom d'utilisateur
            $rowp = mysqli_fetch_assoc($resultpass); // Récupère le résultat du mot de passe

            // Limiter les tentatives de connexion
            if ($_SESSION['i'] >= 3) {
                echo "Êtes-vous sûr de posséder un compte ?";
                session_destroy();
                exit();
            }

            // Vérification si l'utilisateur et le mot de passe existent
            if (!$rowu || !$rowp) {
                $_SESSION['i']++; // Incrémenter les tentatives
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            } else {
                $_SESSION['user_logged_in'] = true; // Marque l'utilisateur comme connecté
                $_SESSION['username'] = $uname; // Enregistre le nom d'utilisateur dans la session
                $_SESSION['success_message_connexion'] = "Connexion reussite.";
                header("Location: Login.php"); // Redirige l'utilisateur vers la page utilisateur
                exit();
            }
        } else {
            echo "Erreur de requête : " . mysqli_error($co);
            session_destroy();
        }

        mysqli_close($co); // Fermeture de la connexion à la base de données
    }
}


