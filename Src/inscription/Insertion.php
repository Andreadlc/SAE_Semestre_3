<?php



session_start();  // Démarre la session pour utiliser $_SESSION


// Si le formulaire a été soumis
if (isset($_POST['ok'], $_POST['uname'], $_POST['password'])) {

    $uname = $_POST['uname'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $co = mysqli_connect("localhost", "root", "");

    if (!$co) {
        die("La connexion a échoué : " . mysqli_connect_error());
    }

    // Sélection de la base de données
    $bd = mysqli_select_db($co, "test");
    if (!$bd) {
        die("Impossible de sélectionner la base de données : " . mysqli_error($co));
    }

    $table = "client"; // Table des utilisateurs

    // Hachage du mot de passe
    $password_md5 = md5($password);

    // Vérifier si l'utilisateur existe déjà
    $sureql = "SELECT * FROM $table WHERE login = '$uname'";
    $result = mysqli_query($co, $sureql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Si l'utilisateur existe déjà, afficher un message d'erreur
            $_SESSION['error_message'] = "Le nom d'utilisateur est déjà pris";
            header('Location: Create.php');  // Redirection vers la page d'inscription
            exit(); // Assurez-vous que le code s'arrête ici
        } else {
            // Si l'utilisateur n'existe pas, insérer les données
            $insertql = "INSERT INTO $table (login, mdp) VALUES ('$uname', '$password_md5')";

            if (mysqli_query($co, $insertql)) {
                $_SESSION['success_message'] = "Votre compte a été créé avec succès !";
                header('Location: Create.php');  // Redirection après l'inscription réussie
                exit(); // Assurez-vous que le code s'arrête ici
            } else {
                $_SESSION['error_message'] = "Erreur d'insertion dans la base de données";
                header('Location: Create.php');  // Redirection en cas d'erreur d'insertion
                exit(); // Assurez-vous que le code s'arrête ici
            }
        }
    } else {
        // En cas d'erreur lors de l'exécution de la requête
        $_SESSION['error_message'] = "Erreur de requête : " . mysqli_error($co);
        header('Location: Create.php');
        exit();
    }

    mysqli_close($co);
}
